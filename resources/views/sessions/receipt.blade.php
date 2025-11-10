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
                size: 80mm auto;
                margin: 5mm;
            }
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', Courier, monospace;
            padding: 20px;
            background: #f5f5f5;
            color: #000;
        }
        
        .receipt-container {
            max-width: 227px;
            width: 100%;
            margin: 0 auto;
            background: white;
            padding: 10px;
        }
        
        @media print {
            .receipt-container {
                max-width: 100%;
                padding: 5mm;
                box-shadow: none;
            }
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
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        
        .receipt-header h1 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
            color: #000;
            text-transform: uppercase;
        }
        
        .receipt-body {
            margin-bottom: 10px;
        }
        
        .receipt-row {
            margin-bottom: 6px;
            font-size: 11px;
            line-height: 1.4;
        }
        
        .receipt-row .label {
            font-weight: bold;
            display: inline-block;
            min-width: 90px;
        }
        
        .receipt-row .value {
            display: inline-block;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }
        
        .total-section {
            border-top: 1px solid #000;
            padding-top: 8px;
            margin-top: 8px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 0;
        }
        
        .receipt-footer {
            text-align: center;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px dashed #000;
            font-size: 9px;
            color: #000;
            line-height: 1.5;
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
        </div>
        
        <div class="receipt-body">
            <div class="receipt-row">
                <span class="label">Data și ora:</span>
                <span class="value">{{ $session->ended_at->format('d.m.Y H:i') }}</span>
            </div>
            
            <div class="divider"></div>
            
            <div class="receipt-row">
                <span class="label">Nume copil:</span>
                <span class="value">{{ $session->child ? $session->child->first_name . ' ' . $session->child->last_name : '-' }}</span>
            </div>
            
            @if($session->child && $session->child->guardian)
            <div class="receipt-row">
                <span class="label">Nume părinte:</span>
                <span class="value">{{ $session->child->guardian->name }}</span>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <div class="receipt-row">
                <span class="label">Început sesiune:</span>
                <span class="value">{{ $session->started_at->format('H:i') }}</span>
            </div>
            
            <div class="receipt-row">
                <span class="label">Sfârșit sesiune:</span>
                <span class="value">{{ $session->ended_at->format('H:i') }}</span>
            </div>
            
            <div class="receipt-row">
                <span class="label">Durată efectivă:</span>
                <span class="value">{{ $session->getFormattedDuration() }}</span>
            </div>
            
            @if($session->price_per_hour_at_calculation)
            <div class="receipt-row">
                <span class="label">Preț/oră:</span>
                <span class="value">{{ number_format($session->price_per_hour_at_calculation, 2, '.', '') }} RON</span>
            </div>
            @endif
            
            <div class="divider"></div>
            
            <div class="total-section">
                <div class="total-row">
                    <span>TOTAL DE PLATĂ:</span>
                    <span>{{ $session->getFormattedPrice() }}</span>
                </div>
            </div>
        </div>
        
        <div class="receipt-footer">
            <div>Mulțumim pentru vizită!</div>
            <div style="margin-top: 4px;">Acest document este un bon nefiscal</div>
        </div>
    </div>
    
    <script>
        // Print-ul este controlat din JavaScript prin iframe
        // Nu mai este nevoie de auto-print aici
    </script>
</body>
</html>
