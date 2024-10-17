@php
    use App\Models\ExamenModel;
    use App\Models\DatoPersonaModel;
    use App\Models\User;
    @endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 75%;
            margin-bottom: 20px;
        }

        .patient-info,
        .prescription {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            margin-right: 25px;
        }

        .patient-info p,
        .prescription p {
            margin: 5px 0;
        }

        .prescription {
            min-height: 500px;
            /* Set a reasonable min-height value */
            height: auto;
            /* Allows the content to adjust if it's larger than the min-height */
            margin-right: 25px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('storage/images/hu_logo.jpg') }}" alt="Logo UNCuyo" class="logo">
        </div>

        <div class="patient-info">
            <p style="margin-top: -5px;"><strong>Paciente:</strong>
                {{ $paciente->apellidos . ' ' . $paciente->nombres }}</p>
            <p style="margin-top: -5px;"><strong>Documento:</strong> {{ $paciente->documento }}</p>
            <p style="margin-top: -5px;"><strong>Fecha:</strong>
                {{ \Carbon\Carbon::parse($alert->fecha_objetivo)->format('d/m/Y') }}</p>
            <p style="margin-top: -5px;"><strong>Obra social:</strong>
                {{ DatoPersonaModel::where('tipo_dato', 'obra_social')->where('persona_id', $paciente->id)->first()->dato ??($paciente->obra_social ?? null) }}
            </p>
        </div>

        <div class="prescription">
            <h3 style="margin-top: 0;">Examenes:</h3>
            <div style="margin-top: -15px">
                @foreach ($examenes as $examen)
                    <p style="margin-left: 10px;margin-top: -10px;">
                        {{ ExamenModel::find($examen->tipo_examen_id)->nombre }}</p>
                @endforeach
            </div>
            <h3 style="margin-top: 0;">Diagnóstico:</h3>
            <p style="margin-left: 10px;margin-top: -15px;">{{ $alert->detalle }}</p>
        </div>

        <div class="footer">
            <p>Firmado electrónicamente por {{ (User::find($alert->created_by)->sexo === 'M') ? "el Dr." : "la Dra." }} {{ User::find($alert->created_by)->name ?? '' }} - Matrícula:
                {{ User::find($alert->created_by)->matricula ?? '' }} - Información confidencial - secreto médico -
                alcances del art. 156 del Código Penal
                y validado en sistema HIS-Alephoo según art. 5 de la Ley 25.506 "Firma Digital" - Paso de los Andes 3051
                - Ciudad de Mendoza.</p>
            <p>Teléfonos (0261) 4135011 / (0261) 4135021 - info@hospital.uncu.edu.ar/www.hospital.uncu.edu.ar </p>
        </div>
    </div>
</body>

</html>
