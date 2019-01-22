<!DOCTYPE html>
<?php
session_start();
include_once '../model/RequisitoModel.php';
include_once '../Entity/Requisito.php';
include_once '../Entity/Usuario.php';
include_once '../Entity/Postulante.php';
include_once '../Entity/RequisitoPostulante.php';
include_once '../model/CatalogoModel.php';
include_once '../model/LoginModel.php';
$loginModel = new loginModel();
$res = false;
$res = $loginModel->ingresar($_SESSION['user'], $_SESSION['pass']);
if ($res) {
    
} else {
    header('Location: ../index.php');
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>GESTION BECAS</title>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src="../js/jquery-2.1.4.js"></script>
        <script src="../smoke.js-master/smoke.js"></script>
        <script src="../smoke.js-master/smoke.min.js"></script>
        <script src="../smoke.js-master/bower.json"></script>
        <link   href="../smoke.js-master/smoke.css" rel="stylesheet">
        <script src="../js/Validaciones.js"></script>
        <script language="JavaScript">
            function senial() {
                smoke.signal("EL POSTULANTE HA SIDO GUARDADO", function (e) {
                }, {
                    duration: 3000,
                    classname: "custom-class"
                });
            }

            function confirmacion(event) {
                event.preventDefault()
                smoke.confirm("Está Seguro de Eliminar?", function (e) {
                    if (e) {
                        window.location.assign(event.target.id);
                    } else {

                    }
                }, {
                    ok: "Si",
                    cancel: "No",
                    classname: "custom-class",
                    reverseButtons: true
                });
            }

        </script>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper" style="background-color: #E73F41">
                <a href="#" class="brand-logo" style="margin-top: 5px;margin-left: 5px;"><img src="../img/sello.png" width="150 px" height="50 px" ></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="../view/postulante.php">Inicio</a></li>
                    <li><a href="../controller/controllerLogin.php?opcion=salir">Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h4>Requisitos de la Beca</h4>
            <div class="divider"></div>
            <br>
            <?php
            if (isset($_SESSION['mensaje'])) {
                echo "<script type='text/javascript'>
                         M.toast({html: '" . $_SESSION['mensaje'] . "', classes: 'rounded', displayLength: '2000'});
                      </script>";
            }
            ?>
            <table data-toggle="table" data-pagination="true" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>OBLIGATORIO</th>
                        <th>ESTADO</th>
                        <th>OBSERVACIÓN</th>
                        <th><div class="row" ><div class="col s4"></div><div class="col s1">OPCIONES</div></div></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $requisitoModel = new requisitoModel();
                    $catalogoModel = new catalogoModel();
                    $usuario = unserialize($_SESSION['userdata']);
                    //verificamos si existe en sesion el listado de requisitos
                    if (isset($_SESSION['requisitos'])) {
                        $listado = unserialize($_SESSION ['requisitos']);
                        foreach ($listado as $re) {
                            echo "<tr>";
                            echo "<td>" . $re->getRe_nombre() . "</td>";
                            echo "<td>" . ($re->getRe_obligatorio() ? 'SI' : 'NO') . "</td>";
                            if (isset($_SESSION['postulante'])) {
                                $postulante = unserialize($_SESSION ['postulante']);
                                $requisitoPostulante = $requisitoModel->getRequisitosPostulante($re->getRe_id(), $postulante->getPo_id());

                                echo "<td>" . $catalogoModel->getCatalogo($requisitoPostulante->getRp_estado())->getCa_nombre() . "</td>";
                            }
                            $subida = "";
                            if ($requisitoPostulante->getRp_archivo_nombre() == "") {
                                $subida = "disabled";
                            }
                            echo "<td>" . $requisitoPostulante->getRp_observacion() . "</td>";
                            echo "<td>"
                            . '<div class="row">'
                            . '<div class="col s6">'
                            . '<form action="../controller/controllerFile.php" method="POST" enctype="multipart/form-data" name="form1">
                                        <input type="hidden" name="opcion" value="upload">   
                                        <input type="hidden" name="requisito_id" value="' . $re->getRe_id() . '"> 
                                        <input type="hidden" name="postulante_id" value="' . $postulante->getPo_id() . '"> 
                                        <div id="mensaje">
                                        <p align="center">
                                            <div class=" file-field input-field">
                                                <div class="btn-floating waves-effect waves-light blue">
                                                    <span ></span>
                                                    <input title="Agregar PDF" name="archivo" onchange="javascript:this.form.submit(); M.toast({html: ' . "'Archivo Guardado Correctamente.'" . '});" type="file" id="archivo" accept=".pdf" >
                                                        <i class="material-icons center">file_upload</i>
                                                    </input>
                                    </div>
                                    <div class="file-path-wrapper" style="float: left">
                                         <input disabled class="file-path" type="text" value="' . $requisitoPostulante->getRp_archivo_nombre() . '">
                                    </div>
                                    </div>
                                    </p>
                                </div>
                            </form>'
                            . '</div>'
                            . '<div class="col s1">'
                            . '<form action="../controller/controllerFile.php" method="POST" enctype="multipart/form-data" name="form1">
                                        <input type="hidden" name="opcion" value="download">   
                                        <input type="hidden" name="requisito_id" value="' . $re->getRe_id() . '"> 
                                        <input type="hidden" name="postulante_id" value="' . $postulante->getPo_id() . '"> 
                                    <div id="mensaje">
                                        <p align="center">
                                           <button title="Descargar PDF"  class="btn-floating btn-small waves-effect waves-light blue ' . $subida . '" type="submit" name="action">
                                             <i class="material-icons right">file_download</i>
                                           </button>
                                    </div>
                                    </p>
                                </div>
                            </form>'
                            . "<a id='detalles' title='Eliminar PDF' class='btn-floating btn-small waves-effect waves-light blue " . $subida . "' style='margin-top: 16px; margin-left: 65px; ' href='../controller/controllerFile.php?opcion=eliminar&requisito_id=" . $re->getRe_id() . "&postulante_id=" . $postulante->getPo_id() .
                            "'" . "><i id='../controller/controllerFile.php?opcion=eliminar&requisito_id=" . $re->getRe_id() . "&postulante_id=" . $postulante->getPo_id() .
                            "' class='material-icons' onclick='return confirmacion(event)'>delete</i></a>"
                            . '</div>'
                            . '</div>'
                            . "</td>";
                        }
                    } else {
                        echo "No se han cargado datos.";
                    }
                    ?>
                </tbody>
            </table>
            <div class="divider"></div>
            <br>
            <a class="waves-effect waves-light btn red" href="postulante.php"><i class="material-icons right">keyboard_return</i>Regresar</a>
        </div>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
    </body>
</html>
<?php
unset($_SESSION['mensaje']);