<!DOCTYPE html>
<?php
session_start();
include_once '../model/BecaModel.php';
include_once '../model/UsuarioModel.php';
include_once '../model/CatalogoModel.php';
include_once '../Entity/Beca.php';
include_once '../Entity/Postulante.php';
include_once '../Entity/Usuario.php';
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
        <meta charset="UTF-8">
        <title>Administrador</title>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src="../js/jquery-2.1.4.js"></script>
        <script src="../smoke.js-master/smoke.js"></script>
        <script src="../smoke.js-master/smoke.min.js"></script>
        <link   href="../smoke.js-master/smoke.css" rel="stylesheet">
        <script language="JavaScript">
            function senial() {
                smoke.signal("EL POSTULANTE HA SIDO GUARDADO", function (e) {
                }, {
                    duration: 3000,
                    classname: "custom-class"
                });
            }

            function aprobar(event) {
                event.preventDefault()
                smoke.confirm("Está Seguro de Aprobar esta Beca?", function (e) {
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
            
            function rechazar(event) {
                event.preventDefault()
                smoke.confirm("Está Seguro de Rechazar esta Beca?", function (e) {
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
                    <li><a href="../view/administrador.php">Inicio</a></li>
                    <li><a href="../controller/controllerBeca.php?opcion=becas">Administrar Becas y Requisitos</a></li>
                    <li><a href="../controller/controllerLogin.php?opcion=salir">Logout</a></li>
                </ul>
            </div>
        </nav>
        <div id="capa" style="display: none;padding: 10px; background-color: #FFE4C4">
            EL POSTULANTE HA SIDO GUARDADO CON EXITO
        </div>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<script type='text/javascript'>
                         M.toast({html: '" . $_SESSION['mensaje'] . "', classes: 'rounded', displayLength: '1000'});
                      </script>";
        }
        ?>
        <div class="container">
            <br>
            <h5>DATOS DEL ADMINISTRADOR</h5>
            <div class="divider"></div>
            <br>
            <?php
            echo "<div class='row'>";
            if (isset($_SESSION['userdata'])) {
                $usuario = unserialize($_SESSION['userdata']);
                $_SESSION['cedulauser'] = $usuario->getUs_cedula();
                echo "<div class='row'>";
                echo "<div class='col s1'>";
                echo "<h6><b>Cédula: </b></h6>";
                echo "</div>";
                echo "<div class='col s5'>";
                echo "<h6>" . $usuario->getUs_cedula() . "</h6>";
                echo "</div>";
                echo "<div class='col s1'>";
                echo "<h6><b>Nombres: </b></h6>";
                echo "</div>";
                echo "<div class='col s5'>";
                echo "<h6>" . $usuario->getUs_nombres() . "</h6>";
                echo "</div>";
                echo "</div>";
                echo "<div class='row'>";
                echo "<div class='col s1'>";
                echo "<h6><b>Apellidos: </b></h6>";
                echo "</div>";
                echo "<div class='col s5'>";
                echo "<h6>" . $usuario->getUs_apellidos() . "</h6>";
                echo "</div>";
                echo "<div class='col s1'>";
                echo "<h6><b>Teléfono: </b></h6>";
                echo "</div>";
                echo "<div class='col s5'>";
                echo "<h6>" . $usuario->getUs_telefono() . "</h6>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
            ?>
            <br>           
            <div class="divider"></div>
            <br>
        </div>
        <div class="container">
            <table class="highlight centered"> 
                <thead>
                    <tr>
                        <th>CÉDULA</th>
                        <th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>BECA</th>
                        <th>ESTADO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //verificamos si existe en sesion el listado de postulantes
                    $catalogoModel = new catalogoModel();
                    $usuarioModel = new UsuarioModel();
                    $becaModel = new becaModel();
                    if (isset($_SESSION['postulantes'])) {
                        $listado = unserialize($_SESSION ['postulantes']);
                        foreach ($listado as $postulante) {
                            echo "<tr>";
                            echo "<td>" . $postulante->getUs_cedula() . "</td>";
                            echo "<td>" . $usuarioModel->getUsuario($postulante->getUs_cedula())->getUs_nombres() . "</td>";
                            echo "<td>" . $usuarioModel->getUsuario($postulante->getUs_cedula())->getUs_apellidos() . "</td>";
                            echo "<td>" . $becaModel->getBeca($postulante->getBeca_id())->getBe_nombre() . "</td>";
                            echo "<td>" . $catalogoModel->getCatalogo($postulante->getPo_estado())->getCa_nombre() . "</td>";
                            echo "<td align='center'>"
                            . "<a title='Aprobar Beca' href='../controller/controllerAdministrador.php?opcion=requisitoaprobar&postulante_id=" . $postulante->getPo_id() . "&beca_id=" . $postulante->getBeca_id() . "'>"
                            . "<i class='material-icons' onclick='return aprobar(event)' id='../controller/controllerAdministrador.php?opcion=requisitoaprobar&postulante_id=" . $postulante->getPo_id() . "&beca_id=" . $postulante->getBeca_id() . "'>check</i></a>"
                            . "<a title='Rechazar Beca' href='../controller/controllerAdministrador.php?opcion=requisitorechazar&postulante_id=" . $postulante->getPo_id() . "&beca_id=" . $postulante->getBeca_id() . "'>"
                            . "<i class='material-icons' onclick='return rechazar(event)' id='../controller/controllerAdministrador.php?opcion=requisitorechazar&postulante_id=" . $postulante->getPo_id() . "&beca_id=" . $postulante->getBeca_id() . "'>close</i></a>"
                            . "<a title='Revisar Requisitos' href='../controller/controllerAdministrador.php?opcion=requisitosadmin&beca_id=" . $postulante->getBeca_id() . "&us_cedula=" . $postulante->getUs_cedula() . "'>"
                            . "<i class='material-icons' >description</i></a>"
                            . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "No se han cargado datos";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
    </body>
</html>
<?php
unset($_SESSION['mensaje']);