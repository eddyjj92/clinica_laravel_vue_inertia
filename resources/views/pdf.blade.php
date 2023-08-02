<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Estados Financieros</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <style>
                /**
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
                **/
            @page {
                margin: 0cm 0cm;
            }

            /** Defina ahora los márgenes reales de cada página en el PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Definir las reglas del encabezado **/
            header {
                position: fixed;
                top: 0.5cm;
                left: 0cm;
                right: 0cm;
                height: 1cm;

                /** Estilos extra personales **/
                background-color: #ffffff;
                color: white;
                text-align: center;
                line-height: 1.5cm;
            }

            /** Definir las reglas del pie de página **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1.5cm;

                /** Estilos extra personales **/
                background-color: #AFAFAFFF;
                color: white;
                text-align: center;

            }
        </style>
    </head>
    <body>
    <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
    <header>

    </header>

    <footer>
        <p style="font-size: 10px; font-weight: bold">Oficina 301 Carrera 14 # 94a-10 Bogotá, Colombia<br>
            Teléfono: +57 601 702 5310<br>
            Correo: comercial@getcoveredworld.com
        </p>
    </footer>

    <main style="margin: 0 auto;display: block;width: 100%;">
        <table style="font-family: Arial,serif;" width="100%" border="0">
            <thead>
                <tr>
                    <th class="text-center">Hola</th>
                    <th class="text-center">Hola</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < 200; $i++)
                    <tr>
                        <td class="text-center">Hola</td>
                        <td class="text-center">Hola</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </main>


    </body>
</html>





