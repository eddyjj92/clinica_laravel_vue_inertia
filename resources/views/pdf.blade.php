<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Certificado Médico</title>
        <style>

            @page {
                margin: 0cm 0cm;
            }

            /** Defina ahora los márgenes reales de cada página en el PDF **/
            body {
                margin-top: 0.5cm;
                margin-left: 0.5cm;
                margin-right: 0.5cm;
                margin-bottom: 0.2cm;
            }

            /** Definir las reglas del pie de página **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1.2cm;

                /** Estilos extra personales **/
                background-color: #AFAFAFFF;
                color: white;
                text-align: center;
            }

            /*table, th, td {
                border: 1px solid black;
            }*/
        </style>
    </head>
    <body>
    {{--{{dd($cuestionario->data['datos_generales']['avatar'])}}--}}
    <!-- Defina bloques de encabezado y pie de página antes de su contenido -->
<!--
    <header>

    </header>
-->

    <footer>
        <p style="font-size: 10px; font-weight: bold; margin-top: 5px">
            <script type="text/php">
               if ( isset($pdf) ) {
                 $h = $pdf->get_height();

                 $size = 10;
                 $font_bold = $fontMetrics->getFont("helvetica", "bold"); // intenta uno  diferente
                 $text_height = $fontMetrics->getFontHeight($font_bold, $size);
                 $y = $h - $text_height - 12;

                 $pdf->page_text(260, $y, "Página {PAGE_NUM} de {PAGE_COUNT}", $font_bold, $size, [0, 0, 0]); // longitud ingresada de la pagina
               }
            </script>
        </p>
    </footer>

    <main style="display: block;width: 100%;">
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="width: 30%"><img style="width: 250px; height: 80px; justify-content: start; align-items: start" src="img/certificado/logo.png" alt="Laboratorio Clinico y Patológico"></td>
                    <td style="width: 30%"></td>
                    <td style="width: 40%;">
                        <h4 style="text-align: center; margin-bottom: 1px">Ultrasonografía Diagnóstica </h4>
                        <div style="line-height: 1px">
                            <p style="text-align: center; font-size: 10px">Dr. J. Aníbal Pérez González UAT y U. Juárez</p>
                            <p style="text-align: center; font-size: 10px">MÉDICO CIRUJANO, MEDICINA GENERAL</p>
                            <p style="text-align: center; font-size: 10px">Fco. Villa # 90, entre Roberto Guerra</p>
                            <p style="text-align: center; font-size: 10px">y Alejando Prieto Col. Treviño Zapata</p>
                            <p style="text-align: center; font-size: 10px">Tel: (866) 813 9906, 203 1600, H. Matamoros, Tamaulipas</p>
                            <p style="text-align: center; font-size: 10px; text-transform: uppercase"> Cédula Profesional: 1818779</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td colspan="2" style="text-align: center"><b>H. MATAMOROS TAMAULIPAS:</b> {{$fecha}}</td>
                <tr>
                    <td colspan="2" style="text-align: center"><b>ASUNTO:</b> CERTIFICADO MÉDICO</td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center"><b>A QUIEN CORRESPONDA:</b> {{ $data['datos_generales']['empresa'] }}</td>
                </tr>
                <tr style="margin-top: 20px">
                    <td colspan="1" style="width: 70%;">
                        <br><center>Por medio de la presente, hago de su conocimiento que el paciente:</center>
                        <h3 style="text-align: center; font-style: italic; margin-top: 5px; margin-bottom: 5px ">{{$data['datos_generales']['nombre']}}</h3>
                        <p style="text-align: justify">
                            Fue enviado a mi consultorio para efectuar una valoración médica, para lo que se le realizó una radiografía de Tele de
                            Tórax (La cual salió normal). También se hicieron exámenes de laboratorio clínico tales como; Glucosa, perfil
                            hemático, Gpo. y Rh (Tipo de sangre), examen general de orina, V.D.R.L., H.I.V, reacciones febriles, prueba de
                            embarazo, examen coproparasitoscópico y detección de cocaína y marihuana en orina (cuyos resultados se anexan
                            en el expediente). Así como una amplia auscultación, interrogación y exploración médica, obteniendo los siguientes
                            resultados:
                        </p>

                    </td>
                    <td colspan="1"><img style="width: 100%; border-radius: 5px;border: 1px dashed #000" src="{{public_path().'/img/pacientes/'.$data['datos_generales']['avatar']}}"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b>RESULTADOS {Marca temporal}</b><br>
                        <p style="text-align: justify">
                            PE/S: {PE/S} GLUC: {GLUC} EGO: {EGO} BH: {BH} Grupo y RH: {Grupo y RH} VDRL&HIV:
                            {VDRL&HIV} ANTIDOPING 3: {ANTIDOPING 3} CPU: {CPU} REX.FEB: {REX.FEB }
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b>A.P.N.P (Antecedentes personales no patológicos)</b><br>
                        <p style="text-align: justify">
                            Paciente de {{$data['datos_generales']['edad']}} años, de sexo {{$data['datos_generales']['sexo']}}. Originario de {{$data['datos_generales']['ciudad_origen']}}. Actualmente {{$data['estado_civil']['estado']}} y
                            {{--{{¿Tiene usted hijos?}} {{Mencione sus edades (En caso de tener hijos)}}--}}. Con escolaridad {{$data['escolaridad']['grado_estudios']}}. De oficio “{{$data['oficio_profesion']['oficio']}}”. Antes de
                            aplicar trabajó en {{$data['oficio_profesion']['ultimo_trabajo']}}, hasta {{$data['oficio_profesion']['hasta_cuando']}}. Según él con tabaquismo {{$data['toxicomanias']['fuma']}} {{$data['toxicomanias']['cuantos_cigarillos']}}
                            y alcoholismo {{$data['toxicomanias']['bebe']}} @if($data['toxicomanias']['cuanta_bebida'] != null){{ $data['toxicomanias']['cuanta_bebida'] }} @endif. Habita con su @foreach($data['vivienda']['personas_vivienda'] as $persona) {{$persona}}, @endforeach en casa de {{$data['vivienda']['propietario_vivienda']}} ({{$data['vivienda']['estado_vivienda']}}).
                            Casa hecha de {{$data['vivienda']['material_vivienda']}}. Con {{$data['vivienda']['recamaras']}} recámaras, {{$data['vivienda']['cuartos']}}
                            cuartos y {{$data['vivienda']['banos']}} baños, donde habitan {{$data['vivienda']['cantidad_personas']}}
                            personas, Aparentemente con regulares Hábitos Higiénico-Dietéticos.
                            Hábitos del sueño: Roncar {{$data['habitos_sueno']['ronca']}}, dejar de respirar {{$data['habitos_sueno']['deja_respirar']}}, sentirse cansado {{$data['habitos_sueno']['adormilado']}}.
                            Hábitos de ejercicio (Semanal): {{$data['estado_salud']['ejercicio_semana']}}. Vacuna de influenza y/o COVID: Influenza {{$data['estado_salud']['vacuna_influenza']}}, COVID {{$data['estado_salud']['vacuna_covid']}}.
                            A.P.P: Negados.
                            A.H.F: Negados.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <b>INTERROGATORIO POR APARATOS Y SISTEMAS: Sin Datos patológicos y bien orientada en las tres esferas</b><br>
                        <p style="text-align: justify">
                            E.F: Paciente de complexión {{$data['senas_particulares']['complexion_fisica']}}, estatura media, tez {{$data['senas_particulares']['tono_piel']}}, cabello {{$data['senas_particulares']['color_cabello']}},
                            {{$data['senas_particulares']['pelo_tenido']}} de longitud {{$data['senas_particulares']['longitud_cabello']}} y {{$data['senas_particulares']['tipo_cabello']}}. Ojos {{$data['senas_particulares']['color_ojos']}}, {{$data['discapacidades']['lentes_pupilentes']}} utiliza
                            lentes. Nariz {{$data['senas_particulares']['forma_nariz']}}, piezas dentales completas, {{$data['discapacidades']['empastes']}} empastes, {{$data['discapacidades']['protesis']}} prótesis. Señas Particulares; {{$data['senas_particulares']['cicatriz']}}, @if($data['senas_particulares']['cicatriz_descripcion'] != null) {{$data['senas_particulares']['cicatriz_descripcion']}},@endif
                            {{$data['senas_particulares']['tatuaje']}}  @if($data['senas_particulares']['tatuaje_descripcion'] != null) {{$data['senas_particulares']['tatuaje_descripcion']}} @endif. {{$data['senas_particulares']['lunar']}} @if($data['senas_particulares']['lunar_descripcion'] != null) {{$data['senas_particulares']['lunar_descripcion']}} @endif. Con una edad aparentemente igual a la cronológica. Sin
                            novedades en Área Cardiopulmonar, Sin novedades en Área de Otorrinolaringología, Abdomen abultado, Músculos
                            bien tonificados y con buenos reflejos y con los siguientes signos vitales:
                            SIGNOS VITALES: PESO: {{$data['signos_vitales']['peso']}} Kg. ESTATURA: {{$data['signos_vitales']['estatura']}} mts, IMC: {{(float)$data['signos_vitales']['peso']/(float)$data['signos_vitales']['estatura'] * (float)$data['signos_vitales']['estatura']}}
                            TA: {{$data['signos_vitales']['p_sistolica']}}/{{$data['signos_vitales']['p_diastolica']}} mmHg, PULSO: {{$data['signos_vitales']['pulso']}}/min TEMP {{$data['signos_vitales']['temperatura']}}°C
                            MEDIDAS METABÓLICAS: CUELLO: {{$data['medidas']['cuello']}} CM, PECHO: {{$data['medidas']['pecho']}} CM, CINTURA: {{$data['medidas']['cintura']}} CM, CADERA: {{$data['medidas']['caderas']}} CM
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">

                        <br><b>El día de Hoy: Paciente Clínicamente Sano Y Apto para trabajar.</b><br>
                        <p style="text-align: justify">
                            Se extiende el presente CERTIFICADO MÉDICO a petición de {{$data['datos_generales']['empresa']}}
                            para los fines y usos legales que a ella misma convengan, siendo el día {{$fecha}} ,
                            en esta ciudad de H. Matamoros, Tamaulipas.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><br><p style="text-align: center; margin-bottom: 5px; line-height: 5px">_____________________________________</p><br>
                        <p style="text-align: center; margin-top: 5px; font-weight: bold">
                            DR. JOSE ANIBAL PÉREZ GONZÁLEZ
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>


    </body>
</html>





