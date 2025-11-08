<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon Nefiscal - Sesiune #{{ $session->id }}</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
            @page {
                margin: 1cm;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
            color: #333;
        }
        
        .receipt-container {
            max-width: 300px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .print-button button {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .print-button button:hover {
            background: #059669;
        }
        
        .receipt-header {
            text-align: center;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .receipt-header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #1f2937;
        }
        
        .receipt-header .subtitle {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .company-info .company-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        
        .company-info .company-details {
            font-size: 11px;
            color: #6b7280;
            line-height: 1.5;
        }
        
        .receipt-body {
            margin-bottom: 15px;
        }
        
        .receipt-section {
            margin-bottom: 12px;
        }
        
        .receipt-section .label {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .receipt-section .value {
            font-size: 13px;
            font-weight: 600;
            color: #1f2937;
        }
        
        .divider {
            border-top: 1px dashed #ddd;
            margin: 15px 0;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 15px;
        }
        
        .items-table tr {
            border-bottom: 1px dashed #e5e7eb;
        }
        
        .items-table td {
            padding: 8px 0;
            font-size: 12px;
        }
        
        .items-table td:first-child {
            color: #6b7280;
        }
        
        .items-table td:last-child {
            text-align: right;
            font-weight: 600;
            color: #1f2937;
        }
        
        .total-section {
            border-top: 2px solid #1f2937;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
            padding: 5px 0;
        }
        
        .total-row .label {
            color: #1f2937;
        }
        
        .total-row .amount {
            color: #10b981;
            font-size: 18px;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #ddd;
            font-size: 10px;
            color: #9ca3af;
            line-height: 1.6;
        }
        
        .receipt-number {
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
            margin-top: 10px;
        }
        
        .payment-info {
            background: #f9fafb;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="no-print print-button">
        <button onclick="window.print()">
            🖨️ Printează Bon
        </button>
    </div>
    
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>{{ $session->tenant->name ?? 'Loc de Joacă' }}</h1>
            <div class="subtitle">Bon Nefiscal</div>
        </div>
        
        <div class="company-info">
            @if($session->tenant)
            <div class="company-name">{{ $session->tenant->name }}</div>
            @if($session->tenant->address)
            <div class="company-details">{{ $session->tenant->address }}</div>
            @endif
            @if($session->tenant->phone)
            <div class="company-details">Tel: {{ $session->tenant->phone }}</div>
            @endif
            @if($session->tenant->email)
            <div class="company-details">{{ $session->tenant->email }}</div>
            @endif
            @endif
        </div>
        
        <div class="receipt-body">
            <div class="receipt-section">
                <div class="label">Data și Ora</div>
                <div class="value">{{ $session->ended_at->format('d.m.Y H:i') }}</div>
            </div>
            
            <div class="divider"></div>
            
            <div class="receipt-section">
                <div class="label">Copil</div>
                <div class="value">
                    {{ $session->child ? $session->child->first_name . ' ' . $session->child->last_name : '-' }}
                </div>
            </div>
            
            @if($session->child && $session->child->guardian)
            <div class="receipt-section">
                <div class="label">Părinte/Tutor</div>
                <div class="value">{{ $session->child->guardian->name }}</div>
            </div>
            @endif
            
            <div class="receipt-section">
                <div class="label">Brățară</div>
                <div class="value">{{ $session->bracelet_code ?: '-' }}</div>
            </div>
            
            <div class="divider"></div>
            
            <table class="items-table">
                <tr>
                    <td>Început sesiune:</td>
                    <td>{{ $session->started_at->format('H:i') }}</td>
                </tr>
                <tr>
                    <td>Sfârșit sesiune:</td>
                    <td>{{ $session->ended_at->format('H:i') }}</td>
                </tr>
                <tr>
                    <td>Durata efectivă:</td>
                    <td>{{ $session->getFormattedDuration() }}</td>
                </tr>
                @if($session->price_per_hour_at_calculation)
                <tr>
                    <td>Preț/ora:</td>
                    <td>{{ number_format($session->price_per_hour_at_calculation, 2, '.', '') }} RON</td>
                </tr>
                @endif
            </table>
            
            <div class="divider"></div>
            
            <div class="total-section">
                <div class="total-row">
                    <span class="label">TOTAL DE PLATĂ:</span>
                    <span class="amount">{{ $session->getFormattedPrice() }}</span>
                </div>
            </div>
            
            <div class="payment-info">
                <strong>Metodă de plată:</strong> Cash / Card<br>
                <strong>Status:</strong> Achitat
            </div>
        </div>
        
        <div class="receipt-footer">
            <div>Mulțumim pentru vizită!</div>
            <div style="margin-top: 5px;">Acest document este un bon nefiscal</div>
            <div style="margin-top: 5px;">Bon generat la: {{ now()->format('d.m.Y H:i:s') }}</div>
        </div>
        
        <div class="receipt-number">
            Bon #{{ str_pad($session->id, 6, '0', STR_PAD_LEFT) }}
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 500);
        // };
    </script>
</body>
</html>



