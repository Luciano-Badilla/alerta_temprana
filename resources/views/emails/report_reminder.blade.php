<!DOCTYPE html>
<html>
<head>
    <title>Recordatorio de Reporte Vencido</title>
</head>
<body>
    <h1>Recordatorio de Reporte</h1>
    <p>Estimado usuario,</p>
    <p>Este es un recordatorio de que el reporte <strong>{{ $alert->especialidad }}</strong> está vencido.</p>
    <p>Detalle del reporte:</p>
    <p>{{ $alert->detalle }}</p>
    <p>Por favor, tome las acciones necesarias.</p>
    <p>Saludos cordiales,</p>
    <p>El equipo de alertas</p>
</body>
</html>
