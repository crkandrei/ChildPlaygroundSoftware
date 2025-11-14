<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Nefiscal - Final de Zi</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 20px;
                font-family: 'Courier New', monospace;
                font-size: 12pt;
            }
            .no-print {
                display: none !important;
            }
        }
        
        @media screen {
            body {
                font-family: 'Courier New', monospace;
                font-size: 14pt;
                padding: 20px;
                max-width: 80mm;
                margin: 0 auto;
                background: #f5f5f5;
            }
        }
        
        body {
            margin: 0;
            padding: 20px;
            font-family: 'Courier New', monospace;
            font-size: 12pt;
            line-height: 1.5;
        }
        
        .report-content {
            text-align: center;
            white-space: pre-line;
        }
        
        .report-line {
            margin: 5px 0;
        }
        
        .report-title {
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 10px;
        }
        
        .report-separator {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .no-print {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
        }
        
        .no-print button {
            background: #10b981;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14pt;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .no-print button:hover {
            background: #059669;
        }
    </style>
</head>
<body>
    <div class="report-content">
        <div class="report-line report-title">RAPORT FINAL DE ZI</div>
        <div class="report-line">{{ $date }}</div>
        <div class="report-separator"></div>
        <div class="report-line">Nr total sesiuni: {{ $totalSessions }}</div>
        <div class="report-line">Nr total birthday: {{ $birthdaySessions }}</div>
        <div class="report-line">Nr total ore: {{ $totalHoursFormatted }}</div>
        <div class="report-separator"></div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print()">Imprimă</button>
        <button onclick="window.close()" style="background: #6b7280; margin-left: 10px;">Închide</button>
    </div>
    
    <script>
        // Auto-print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 250);
        };
    </script>
</body>
</html>

