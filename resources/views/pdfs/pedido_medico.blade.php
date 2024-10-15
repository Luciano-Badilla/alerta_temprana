<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
            max-width: 600px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 50px;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .diagnosis {
            margin-top: 30px;
        }
        .diagnosis p {
            font-size: 16px;
            font-weight: bold;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('storage/images/hu_logo.jpg') }}" alt="Logo UNCuyo">
        </div>
        
        <div class="info">
            <p><strong>Paciente:</strong> {{ $alert->nombre }}</p>
            <p><strong>Documento:</strong> {{ $alert->documento }}</p>
            <p><strong>Fecha:</strong> {{ date('d/m/Y') }}</p>
        </div>

        <div class="diagnosis">
            <p><strong>Procedimiento:</strong> {{ $alert->procedimiento }}</p>
            <p><strong>Diagnóstico:</strong> {{ $alert->diagnostico }}</p>
        </div>

        <div class="signature">
            <p>______________________________</p>
            <p><strong>Dr. {{ $alert->medico_nombre }}</strong></p>
            <p>{{ $alert->medico_matricula }}</p>
        </div>

        <div class="footer">
            <p>Hospital Universitario, UNCuyo - Paso de los Andes 3051, Ciudad de Mendoza</p>
            <p>Tel: 261 4494220 - Turnos: 0810 999 1029</p>
        </div>
    </div>
</body>
</html>
