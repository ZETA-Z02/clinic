<!DOCTYPE html>
<html>

<head>
    <title>Recibo</title>
    <style>
        .container {
            margin: auto;
            width: 100%;
            max-width: 600px;
            color: #77f;
        }
        table{
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .titulo-principal, .recibo{
            border: 1px solid #77f;
            border-radius: 15px;
            overflow: hidden;
        }
        .titulo-principal td, .fecha th, .fecha td{
            border-radius: none;
            overflow: hidden;
        }
        #fecha{
            margin-top: 10px;
        }
        .bordeado{
            border: 1px solid #77f;
            border-radius: 15px;
            padding: 5px;
        }
        .title{
             
        }
        td {
            text-align: center;
        }
        .boleta-contenido tr td{
            border: 1px solid #77f;
            margin: 0;
            padding: 0;
        }
        .totales p {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="titulo-principal">
        <table>
            <tr>
                <td >
                    <h2>Gestión y Asesoramiento para Empresas de la
                        Salud</h2>
                    <h4>Ortodoncia</h4>
                    <p>JR. Lambayeque Nº 117 A Puno - Puno - Puno</p>
                </td>
                <td class="">
                    <div class="recibo">
                        <h2 class="title">RECIBO</h2>
                        <span>N : 1000123</span>
                    </div>
                    <div class="bordeado" id="fecha">
                    <table class="fecha">
                        <tr>
                            <th>Dia</th>
                            <th>Mes</th>
                            <th>Año</th>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>11</td>
                            <td>2024</td>
                        </tr>
                    </table>
                    </div>
                </td>
            </tr>
        </table>
        </div>
        <div class="cliente bordeado">
            <p><strong>Señor(a): </strong> Celestino Ururi Quispe</p>
            <p><strong>DNI: </strong> 72345678</p>
        </div>
        <div class="bordeado">
        <table class="boleta-contenido">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th>Descripcion</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ortodoncia</td>
                    <td>1000</td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="totales">
            <p><strong>TOTAL S/: 100,00</strong></p>
        </div>
    </div>
</body>

</html>