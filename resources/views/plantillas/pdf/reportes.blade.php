<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-f8"/>
    <meta charset="UTF-8">
    <title>Reporte Panel {{ $panel->id }}</title>
    <style>
        /* Estilos CSS para el PDF - dompdf es sensible con el CSS */
        @page {
            margin: 25px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #333;
            padding-bottom: 10px;
        }

        /* Tabla de cabecera con datos */
        .header-table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 25px;
        }

        .header-table th,
        .header-table td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .header-table th {
            width: 25%;
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Contenedor de las fotos */
        h2 {
            text-align: center;
            font-size: 16px;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            margin-top: 30px;
        }
        
        /* Grilla de fotos (usamos una tabla para compatibilidad con dompdf) */
        .photo-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .photo-grid td {
            width: 50%; /* Dos columnas */
            padding: 5px;
            vertical-align: top;
            text-align: center;
        }

        .photo-grid img {
            width: 100%;
            max-width: 340px; /* Ajusta el tamaño máximo */
            height: auto;
            border: 1px solid #ddd;
        }

        .no-image {
            width: 340px;
            height: 250px;
            border: 1px dashed #ccc;
            display: inline-block;
            padding-top: 120px;
            color: #888;
        }

    </style>
</head>
<body>

    <h1>Reporte de Panel Fotográfico</h1>

    <table class="header-table">
        <tr>
            <th>Producto / O/C</th>
            <td>
                {{ $panel->producto->nombre ?? 'N/A' }}
                ==
                {{ $panel->oc ?? 'N/A' }}
            </td>
        </tr>
        <tr>
            <th>Guía N°</th>
            <td>{{ $panel->n_guia ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td>{{ $panel->fecha->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Precinto</th>
            <td>{{ $panel->precinto ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Placa</th>
            <td>{{ $panel->placa ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Ubicación</th>
            <td>{{ $panel->ubicacion ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Observaciones</th>
            <td>{{ $panel->observaciones ?? 'N/A' }}</td>
        </tr>
    </table>

    <h2>Fotografías (Máx. 4)</h2>

    @php
        // Obtenemos solo las primeras 4 fotos
        $fotos = $panel->fotos->take(4);
    @endphp

    <table class="photo-grid">
        <tr>
            <td>
                @if (isset($fotos[0]) && file_exists(storage_path('app/public/' . $fotos[0]->foto)))
                    <img src="{{ storage_path('app/public/' . $fotos[0]->foto) }}">
                @else
                    <span class="no-image">Foto 1 no disponible</span>
                @endif
            </td>
            <td>
                @if (isset($fotos[1]) && file_exists(storage_path('app/public/' . $fotos[1]->foto)))
                    <img src="{{ storage_path('app/public/' . $fotos[1]->foto) }}">
                @else
                    <span class="no-image">Foto 2 no disponible</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>
                @if (isset($fotos[2]) && file_exists(storage_path('app/public/' . $fotos[2]->foto)))
                    <img src="{{ storage_path('app/public/' . $fotos[2]->foto) }}">
                @else
                    <span class="no-image">Foto 3 no disponible</span>
                @endif
            </td>
            <td>
                @if (isset($fotos[3]) && file_exists(storage_path('app/public/' . $fotos[3]->foto)))
                    <img src="{{ storage_path('app/public/' . $fotos[3]->foto) }}">
                @else
                    <span class="no-image">Foto 4 no disponible</span>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>