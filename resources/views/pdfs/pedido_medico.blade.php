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
        @page {
            size: A4 landscape;
            /* Define la orientación horizontal */
            margin: 0.5cm;
            /* Ajuste de márgenes para impresión */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            max-width: 35%;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            /* Ajuste para el formato apaisado */
            margin: 0 auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 60%;
            margin-bottom: 10px;
        }

        .patient-info,
        .prescription {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .patient-info p,
        .prescription p {
            margin: 3px 0;
        }

        .prescription {
            min-height: 390px;
            height: auto;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('storage/images/hu_logo.jpg') }}" alt="Logo UNCuyo" class="logo">
        </div>

        <div class="patient-info">
            <p><strong>Paciente:</strong> {{ $paciente->apellidos . ' ' . $paciente->nombres }}</p>
            <p><strong>Documento:</strong> {{ $paciente->documento }}</p>
            <p><strong>Obra social:</strong>
                {{ DatoPersonaModel::where('tipo_dato', 'obra_social')->where('persona_id', $paciente->id)->first()->dato ??($paciente->obra_social ?? null) }}
            </p>
            <p><strong>Fecha:</strong>
                {{ $alert->pedido_medico_created_at ? \Carbon\Carbon::parse($alert->pedido_medico_created_at)->format('d/m/Y') : 'N/A' }}
            </p>
        </div>

        <div class="prescription">
            <h3 style="margin: 0;">Rp/</h3>
            <div style="margin-left: 20px;">    
                <h3 style="margin: 0; margin-top:5%;">STO:</h3>
                <div>
                    @foreach ($examenes as $examen)
                        <p style="margin-left: 10px;">
                            - {{ ExamenModel::find($examen->tipo_examen_id)->nombre }}
                        </p>
                    @endforeach
                </div>
                <h3 style="margin: 0; margin-top:1%;">Diagnóstico:</h3>
                <p style="margin-left: 10px;">{{ $alert->detalle }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Firmado electrónicamente por {{ User::find($alert->created_by)->sexo === 'M' ? 'el Dr.' : 'la Dra.' }}
                {{ User::find($alert->created_by)->name ?? '' }} - Matrícula:
                {{ User::find($alert->created_by)->matricula ?? '' }} - Información confidencial - Secreto médico -
                Alcances del art. 156 del Código Penal. Validado en el sistema HIS-Alephoo según el art. 5 de la Ley
                25.506 "Firma Electrónica".
                <br> Paso de los Andes 3051 - Ciudad de Mendoza.
            </p>
            <p>Teléfonos (0261) 4135011 / (0261) 4135021 - info@hospital.uncu.edu.ar - www.hospital.uncu.edu.ar </p>
        </div>
    </div>
</body>

</html>
