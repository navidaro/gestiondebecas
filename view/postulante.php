<!DOCTYPE html>
<?php
session_start();
include_once '../model/BecaModel.php';
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
        <title>Postulante</title>
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
                    <li><a href="../view/postulante.php">Inicio</a></li>
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
            <h5>DATOS DEL POSTULANTE</h5>
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
                echo "<h6><b>Promedio: </b></h6>";
                echo "</div>";
                echo "<div class='col s5'>";
                echo "<h6>" . $usuario->getUs_promedio() . "</h6>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
            ?>
            <div class="divider"></div>
            <br>

            <form action="../controller/controllerPostulante.php" >
                <div class="row">
                    <div class="col s2" style="margin-top: 15px;"><b>BECA A POSTULARSE</b></div>
                    <div class="col s4">
                        <select name="cod_beca">
                            <?php
                            $becaModel = new BecaModel();
                            $listado = $becaModel->getBecas();
                            echo "$listado";
                            echo "<option value='0'><pre>-----------------Seleccionar----------------</pre></option>";
                            foreach ($listado as $beca) {
                                echo "<option value='" . $beca->getBe_id() . "'>" . $beca->getBe_nombre() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col s2" style="margin-top: 10px;">
                        <input type="hidden" name="opcion" value="insertarPostulacion">
                        <button class="waves-effect waves-light btn" style="background-color: red" type="submit" name="action">Postular</button>  
                    </div>
                </div>
            </form>
            <div class="divider"></div>
            <br><br>
        </div>
        <div class="container">
            <table class="highlight centered"> 
                <thead>
                    <tr>
                        <th>NOMBRE</th>
                        <th>MONTO</th>
                        <th>FECHA</th>
                        <th>ESTADO</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //verificamos si existe en sesion el listado de becas
                    $catalogoModel = new catalogoModel();
                    if (isset($_SESSION['postulaciones'])) {
                        $listado = unserialize($_SESSION ['postulaciones']);
                        foreach ($listado as $beca) {
                            echo "<tr>";
                            echo "<td>" . $becaModel->getBeca($beca->getBeca_id())->getBe_nombre() . "</td>";
                            echo "<td>" . $becaModel->getBeca($beca->getBeca_id())->getBe_monto() . "</td>";
                            echo "<td>" . $beca->getPo_fecha() . "</td>";
                            echo "<td>" . $catalogoModel->getCatalogo($beca->getPo_estado())->getCa_nombre() . "</td>";
                            echo "<td align='center'>"
                            . "<a title='Completar Requisitos' href='../controller/controllerPostulante.php?opcion=requisitos&beca_id=" . $beca->getBeca_id() . "'><i class='material-icons'>description</i></a>"
                            . "<a title='Eliminar Postulación' id='detalles' href='controller/controllerPostulante.php?opcion=eliminar&beca_id=" . $beca->getBeca_id() .
                            "'" . "><i id='controller/controllerPostulante.php?opcion=eliminar&beca_id=" . $beca->getBeca_id() .
                            "' class='material-icons' onclick='return confirmacion(event)'>delete</i></a>"
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