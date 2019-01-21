<!DOCTYPE html>
<?php
session_start();
include_once '../model/BecaModel.php';
include_once '../Entity/Beca.php';
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
        <title>Becas</title>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
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
                        window.location.assign("http://" + "localhost/gestiondebecas/" + event.target.id);
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
            <div class="row">
                <div class="col s10">
                    <h5>ADMINISTRAR BECAS</h5>
                </div>
                <div class="col s2">
                    <a class="waves-effect waves-light btn red" href="../view/createBeca.php"><i class="material-icons right">add</i>Crear</a>
                </div>
            </div>
            <div class="divider"></div>
            <br>
            <table class="highlight centered"> 
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>MONTO</th>
                        <th>PROMEDIO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_SESSION['becas'])) {
                        $listado = unserialize($_SESSION ['becas']);
                        foreach ($listado as $beca) {
                            echo "<tr>";
                            echo "<td>" . $beca->getBe_nombre() . "</td>";
                            echo "<td>" . $beca->getBe_monto() . "</td>";
                            echo "<td>" . $beca->getBe_promedio() . "</td>";
                            echo "<td>" . $beca->getBe_descripcion() . "</td>";
                            echo "<td align='center'>"
                            . "<a title='Requisitos' href='../controller/controllerBeca.php?opcion=editar&beca_id=" . $beca->getBe_id() . "'><i class='material-icons'>edit</i></a>"
                            . "<a title='Requisitos' href='../controller/controllerBeca.php?opcion=eliminar&beca_id=" . $beca->getBe_id() . "'><i class='material-icons'>delete</i></a>"
                            . "<a title='Requisitos' href='../controller/controllerRequisito.php?opcion=requisitos&beca_id=" . $beca->getBe_id() . "'><i class='material-icons'>description</i></a>"
                            . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "No se han cargado datos";
                    }
                    ?>
                </tbody>
            </table>
            <br><br>
            <a class="waves-effect waves-light btn right"  style="background-color:#EB1D20" href="../view/administrador.php">Regresar</a>
        </div>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
    </body>
</html>
<?php
unset($_SESSION['mensaje']);