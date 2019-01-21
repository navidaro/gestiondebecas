<?php
session_start();
session_destroy();
?>
<html>
    <head>
        <title>Ingreso</title>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
        <div class="section"></div>
    <center>
        <div class="section"></div>
        <div class="container">
            <div id="form" class="z-depth-1 grey lighten-4 row" style="width: 600px; display: inline-table; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">
                <img class="responsive-img" style="width: 170px;" src="img/selloUtn.png" />

                <form class="col s12" action="controller/controllerLogin.php">
                    <div class='row'>
                        <div class='col s12'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='input-field col s11'>
                            <i class="material-icons prefix " style="color: #F7474A; margin-top: 10px;">person</i>
                            <input class='validate' type='text' name='user' id='cedula' minlength="0"  maxlength="10"/>
                            <label class="left-align" for='cedula'>Cédula</label>
                            <span class="helper-text" data-error="" data-success=""></span>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='input-field col s11'>
                            <i class="material-icons prefix" style="color: #F7474A; margin-top: 10px;">vpn_key</i>
                            <input class='validate' type='password' name='pass' id='password' />
                            <label class="left-align" for='pass'>Contraseña</label>
                        </div>
                    </div>
                    <br/>
                    <div class='row'>
                        <input type="hidden" name="opcion" value="Ingreso">
                        <button type='submit' style="background-color:#EB1D20" name="action" class='col s12 btn btn-large waves-effect' id="connect">Ingresar</button>
                        <div id="snipper" style="width: 500px; display: inline-table;">
                            <div class="progress col s12">
                                <div class="indeterminate red lighten-1"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if (isset($_SESSION['mensaje'])) {
                            $mensaje = $_SESSION ['mensaje'];
                            echo "<p id='validation' style='color:red;'>" . $mensaje . "</p>";
                        }
                        unset($_SESSION['mensaje']);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </center>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#snipper').hide();
            $('#validation').show();
            $('#connect').click(function () {
                $('#snipper').show();
                $('#validation').hide();
            });
        });
    </script>
</body>
</html>
<?php
unset($_SESSION['mensaje']);
