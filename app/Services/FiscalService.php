<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\FiscalCounter;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class FiscalService
{
    private const DEFAULT_OPERATOR_NUMBER = '0001';
    private const DEFAULT_TAX_GROUP = 2;

    public function buildReceiptPayload(array $items, string $paymentType, float $totalAmount, int $tenantId, ?string $sessionId = null): array
    {
        $normalizedItems = [];

        foreach ($items as $item) {
            $text = trim((string) ($item['text'] ?? $item['name'] ?? 'Item'));
            $quantity = (float) ($item['quantity'] ?? 1);
            $unitPrice = (float) ($item['unitPrice'] ?? $item['price'] ?? 0);
            $taxGroup = (int) ($item['taxGroup'] ?? self::DEFAULT_TAX_GROUP);

            $normalizedItems[] = [
                'text' => $text !== '' ? $text : 'Item',
                'quantity' => $quantity > 0 ? $quantity : 1,
                'unitPrice' => max(0, $unitPrice),
                'taxGroup' => $this->sanitizeTaxGroup($taxGroup),
            ];
        }

        $amount = max(0, round($totalAmount, 2));

        return [
            'sessionId' => $sessionId,
            'uniqueSaleNumber' => $this->generateUniqueSaleNumber($tenantId),
            'items' => $normalizedItems,
            'payments' => [
                [
                    'paymentType' => $this->mapPaymentType($paymentType),
                    'amount' => $amount,
                ],
            ],
        ];
    }

    public function generateUniqueSaleNumber(int $tenantId): string
    {
        return DB::transaction(function () use ($tenantId) {
            $counter = FiscalCounter::lockForUpdate()->firstOrCreate(
                ['tenant_id' => $tenantId],
                ['last_receipt_number' => 0]
            );

            $printerSerial = $this->resolvePrinterSerial($tenantId);
            if ($counter->printer_serial !== $printerSerial) {
                $counter->printer_serial = $printerSerial;
                $counter->save();
            }

            $receiptNumber = $counter->nextReceiptNumber();

            return sprintf(
                '%s-%s-%s',
                $printerSerial,
                self::DEFAULT_OPERATOR_NUMBER,
                $receiptNumber
            );
        });
    }

    public function mapPaymentType(string $type): string
    {
        return strtoupper($type) === 'CARD' ? 'card' : 'cash';
    }

    public function getDefaultTimeTaxGroup(int $tenantId): int
    {
        $tenant = Tenant::query()->find($tenantId);
        if (!$tenant) {
            return self::DEFAULT_TAX_GROUP;
        }

        return $this->sanitizeTaxGroup((int) ($tenant->default_time_tax_group ?? self::DEFAULT_TAX_GROUP));
    }

    public function sanitizeTaxGroup(int $taxGroup): int
    {
        if ($taxGroup < 1 || $taxGroup > 8) {
            return self::DEFAULT_TAX_GROUP;
        }

        return $taxGroup;
    }

    private function resolvePrinterSerial(int $tenantId): string
    {
        $agent = Agent::query()
            ->where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->orderByDesc('last_heartbeat_at')
            ->first();

        $serial = strtoupper((string) ($agent?->printer_serial_number ?: $agent?->printer_id ?: 'TENANT' . $tenantId));
        $normalized = preg_replace('/[^A-Z0-9_]/', '', $serial) ?: ('TENANT' . $tenantId);

        return $normalized;
    }
}
