<link rel="stylesheet" href="../Recursos/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="../Recursos/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
<script src="../Recursos/js/bootstrap.min.js"></script>
<?php
include_once '../../vendor/autoload.php'; // Incluye la librería de mPDF
include_once '../../Conexion/Conexion.php';

use Mpdf\Mpdf;

// Verifica si se enviaron los parámetros
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza el ID
    // Consulta a la BD para obtener los datos de la entidad
    $sql = "SELECT E.tipo_equipo, E.ubicacion, S.nombre_sede, S.direccion AS direccion_sede, MS.nombre AS municipio_sede, DS.nombre AS depto_sede, 
    E.serial, E.referencia, E.codigo_maquina, E.persona_a_cargo, E.observaciones, E.estado, E.estado_general, E.tipo_impresora, 
    E.procesador, E.ram, E.disco_duro, E.sistema_operativo, E.teclado, E.mouse, E.monitor, E.office, E.pad_mouse FROM equipos E JOIN sedes_empresa S ON E.id_sede=S.id LEFT JOIN municipios MS ON S.id_municipio=MS.id JOIN departamentos DS ON MS.departamento_id=DS.id WHERE E.id=" . $id;

    $hv = mysqli_fetch_row(ejecutarSQL::consultar($sql));

    $mantenimientos = ejecutarSQL::consultar("SELECT M.fecha, T.nombre_tipo, M.descripcion, M.realizado_por, M.observaciones FROM equipo_mantenimiento M JOIN tipo_mantenimiento T ON M.tipo=T.id WHERE M.id_equipo=$id ORDER BY M.fecha DESC");

    if ($hv) {
        // Crear el PDF con los datos obtenidos
        $mpdf = new Mpdf();
        $mpdf->Bookmark('Hoja de Vida Equipo');
        // $mpdf->SetWatermarkImage('../img/membrete.png', 0.8, [210, 300]);
        // $mpdf->SetWatermarkImage('../img/membrete.png', 0.1, [210, 300], 'L', true);
        $mpdf->showWatermarkImage = true;
        $html = '<head>
                            <style>
                                .titulo { font-size: 16px !important; background-color: #d4d8db; text-align: center; border: 1px solid black; }
                                .subtitulo { font-size: 9px !important; background-color: #d4d8db; text-align: center; border: 1px solid black; }
                                .valor { font-size: 14px !important; text-align: center; border: 1px solid black; }
                                .texto { font-size: 14px !important; text-align: left; border: 1px solid black; }                                
                            </style>
                    </head>';
        $mpdf->WriteHTML($html);
        $estado = '';
        if ($hv[11] == 1) {
            $estado = '<h5 class=\"badge badge-primary ml-1\">Activo</h5>';
        }
        if ($hv[11] == 2) {
            $estado = '<h5 class=\"badge badge-dark ml-1\">Inactivo</h5>';
        }
        if ($hv[11] == 3) {
            $estado = '<h5 class=\"badge badge-danger ml-1\">Dado de Baja</h5>';
        }
        $estado_gral = "";
        if ($hv[12] <= 5) {
            $estado_gral = "Regular";
        } else if ($hv[12] > 5 && $hv[12] <= 7) {
            $estado_gral = "Bueno";
        } else {
            $estado_gral = "Optimo";
        }

        $html = "<br><p><h2 style='text-align: center'>HOJA DE VIDA EQUIPO</h2>            
                <h3 style='text-align: center'>{$hv[0]}</h3></p>";
        $html .= "  <table style='width: 100%; border-collapse: collapse; '>";

        $html .= "      <tr>
                            <td class='subtitulo'><b>Ubicación</b></td>
                            <td class='valor' colspan='5'>{$hv[1]} {$hv[2]} - {$hv[3]} ({$hv[4]})</td>
                        </tr>";

        $html .= "      <tr style='border: 1px solid black; font-size: 9px !important; background-color: #d4d8db'>
                            <td class='subtitulo' colspan='2'><b>Referencia</b></td>
                            <td class='subtitulo'><b>Serial</b></td>
                            <td class='subtitulo' ><b>Código Interno</b></td>
                            <td class='subtitulo'><b>Estado General</b></td>
                            <td class='subtitulo'><b>Estado</b></td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 14px !important;'>
                            <td class='valor' colspan='2'>{$hv[7]}</td>
                            <td class='valor'>{$hv[6]}</td>
                            <td class='valor' >{$hv[8]}</td>
                            <td class='valor'>{$estado_gral}</td>
                             <td class='valor'>{$estado}</td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 9px !important; background-color: #d4d8db'>
                            <td class='subtitulo'><b>Persona a Cargo</b></td>
                            <td class='subtitulo' colspan='5'><b>Observaciones</b></td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 14px !important;'>
                            <td class='valor' >{$hv[9]}</td>
                            <td class='valor' colspan='5'>{$hv[10]}</td>
                        </tr>";
        if ($hv[0] == 'Impresora') {
            $html .= "  <tr>
                            <td class='subtitulo'><b>Tipo Impresora</b></td>
                            <td class='valor' colspan='5'>{$hv[13]}</td>
                        </tr>";
        } else {
            $html .= "  <tr style='border: 1px solid black; font-size: 9px !important; background-color: #d4d8db'>
                            <td class='subtitulo' colspan='2'><b>Procesador</b></td>
                            <td class='subtitulo' colspan='2'><b>RAM</b></td>
                            <td class='subtitulo' colspan='2'><b>Disco Duro</b></td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 14px !important;'>
                            <td class='valor' colspan='2'>{$hv[14]}</td>
                            <td class='valor' colspan='2'>{$hv[15]}</td>
                            <td class='valor' colspan='2'>{$hv[16]}</td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 9px !important; background-color: #d4d8db'>
                            <td class='subtitulo' colspan='2'><b>Teclado</b></td>
                            <td class='subtitulo' colspan='2'><b>Mouse</b></td>
                            <td class='subtitulo' colspan='2'><b>Monitor</b></td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 14px !important;'>
                            <td class='valor' colspan='2'>{$hv[18]}</td>
                            <td class='valor' colspan='2'>{$hv[19]}</td>
                            <td class='valor' colspan='2'>{$hv[20]}</td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 9px !important; background-color: #d4d8db'>
                            <td class='subtitulo' colspan='3'><b>Sistema Operativo</b></td>
                            <td class='subtitulo' colspan='3'><b>Office</b></td>
                        </tr>
                        <tr style='border: 1px solid black; font-size: 14px !important;'>
                            <td class='valor' colspan='3'>{$hv[17]}</td>
                            <td class='valor' colspan='3'>{$hv[21]}</td>
                        </tr>";
        }

        $html .= " </table>
                </body>";


        if (mysqli_num_rows($mantenimientos) > 0) {
            $html .= " <h3 style='text-align: center'>MANTENIMIENTOS Y REVISIONES</h3></p>
                        <table style='width: 100%; border-collapse: collapse; '>";
            $num = 1;
            while ($mantenimiento = mysqli_fetch_array($mantenimientos)) {

                $html .= "      <tr><td style='height: 15px; border-spacing: 0px 10px;'></td></tr>
                                <tr >
                                    <td class='subtitulo' colspan='6'><b>Mantenimiento #{$num}</b></td>
                                </tr>
                                <tr >
                                    <td class='subtitulo'><b>Fecha</b></td>
                                    <td class='valor'><p>{$mantenimiento['fecha']}<p></td>
                                    <td class='subtitulo'><b>Tipo</b></td>
                                    <td class='valor'><p>{$mantenimiento['nombre_tipo']}<p></td>
                                    <td class='subtitulo'><b>Realizado Por</b></td>
                                    <td class='valor'><p>{$mantenimiento['realizado_por']}<p></td>
                                </tr>
                                <tr >
                                    <td class='subtitulo' colspan='6'><b>Descripción</b></td>
                                </tr>
                                <tr >
                                    <td class='valor' colspan='6'><p>{$mantenimiento['descripcion']}<p></td>
                                </tr>";

                if ($mantenimiento['observaciones']) {
                    $html .= "  <tr >
                                    <td class='subtitulo' colspan='6'><b>Observaciones</b></td>
                                </tr>
                                <tr >
                                    <td class='valor' colspan='6'><p>{$mantenimiento['observaciones']}<p></td>
                                </tr>";
                }
                $num++;
            }
        }

        $html .= " </table>
                </body>";


        $mpdf->WriteHTML($html);

        $mpdf->Output('hv' . $hv[7], 'I'); // 'I' guarda el archivo sin mostrarlo

        echo json_encode(['success' => true, 'ruta' => $rutaPdf]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Entidad no encontrada']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Faltan parámetros']);
}
