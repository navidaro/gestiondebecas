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
        <link   href="../smoke.js-master/smoke.css" rel="stylesheet">
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
                <ul class="right hide-on-med-and-down">
                    <li><a href="../view/administrador.php">Inicio</a></li>
                    <li><a href="../controller/controllerBeca.php?opcion=becas">Administrar Becas y Requisitos</a></li>
                    <li><a href="../controller/controllerLogin.php?opcion=salir">Logout</a></li>
                </ul>
            </div>
        </nav>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<script type='text/javascript'>
                         M.toast({html: '" . $_SESSION['mensaje'] . "', classes: 'rounded', displayLength: '1000'});
                      </script>";
        }
        ?>
        <div class="container">
            <br>    
            <h5>CREAR REQUISITO</h5>
            <div class="divider"></div>
            <br><br>
            <form class="col s12" action="../controller/controllerRequisito.php">
                <input type="hidden" name="opcion" value="crear">
                <div class='row'>
                    <div class='input-field col s6'>
                        <i class="material-icons prefix " style="color: #F7474A; margin-top: 10px;">ac_unit</i>
                        <input disabled value="<?php echo $_SESSION['becaname']; ?>" class='validate' type='text' name='beca' id='cedula' minlength="0"  maxlength="30"/>
                        <label class="left-align" for='beca'>Beca</label>
                    </div>
                    <div class='input-field col s6'>
                        <i class="material-icons prefix " style="color: #F7474A; margin-top: 10px;">face</i>
                        <input class='validate' type='text' name='nombre' id='cedula' minlength="0"  maxlength="30"/>
                        <label class="left-align" for='nombre'>Nombre</label>
                        <span class="helper-text" data-error="Inválido" data-success="Inválido"></span>
                    </div>
                </div>
                <div class='row'>
                    <div class='input-field col s6'>
                        <i class="material-icons prefix " style="color: #F7474A; margin-top: 10px;">assignment</i>
                        <input class='validate' type='text' name='descripcion' id='cedula' minlength="0"  maxlength="60"/>
                        <label class="left-align" for='descripcion'>Descripción</label>
                        <span class="helper-text" data-error="Inválido" data-success="Inválido"></span>
                    </div>
                    <div class='input-field col s6'>
                        <i class="material-icons prefix " style="color: #F7474A; margin-top: 10px;">gavel</i>
                        <select name="obligatorio">
                            <option value='1'><pre>Obligatorio</pre></option>
                            <option value='0'><pre>No Obligatorio</pre></option>
                        </select>
                        <label class="left-align" for='cedula'>Obligatoriedad</label>
                        <span class="helper-text" data-error="Cédula Inválida" data-success=""></span>
                    </div>
                    <br>
                    <div class='row'>
                    </div>
                    <div class='row'>
                        <div class='col s5'>
                        </div>
                        <div class='col s5'>
                            <button type='submit' style="background-color:#EB1D20" name="action" class='btn waves-effect center-align' id="connect">CREAR</button>
                            <a class="waves-effect waves-light btn"  style="background-color:#EB1D20" href="../view/crudRequisito.php">Cancelar</a>
                        </div>
                        <div class='col s4'>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript" src="../js/materialize.min.js"></script>
    </body>
</html>
<?php
unset($_SESSION['mensaje']);