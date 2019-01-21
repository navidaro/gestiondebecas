
function Validarcedula() {
    var cedula = document.getElementById("cedula");
    cedula = cedula.value;
    var res = false;
    //Preguntamos si la cedula consta de 10 digitos
    if (cedula.length === 10) {

        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0, 2);

        //Pregunto si la region existe ecuador se divide en 24 regiones
        if (digito_region >= 1 && digito_region <= 24) {

            // Extraigo el ultimo digito
            var ultimo_digito = cedula.substring(9, 10);

            //Agrupo todos los pares y los sumo
            var pares = parseInt(cedula.substring(1, 2)) + parseInt(cedula.substring(3, 4)) + parseInt(cedula.substring(5, 6)) + parseInt(cedula.substring(7, 8));
            //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
            var numero1 = cedula.substring(0, 1);
            var numero1 = (numero1 * 2);
            if (numero1 > 9) {
                var numero1 = (numero1 - 9);
            }

            var numero3 = cedula.substring(2, 3);
            var numero3 = (numero3 * 2);
            if (numero3 > 9) {
                var numero3 = (numero3 - 9);
            }

            var numero5 = cedula.substring(4, 5);
            var numero5 = (numero5 * 2);
            if (numero5 > 9) {
                var numero5 = (numero5 - 9);
            }

            var numero7 = cedula.substring(6, 7);
            var numero7 = (numero7 * 2);
            if (numero7 > 9) {
                var numero7 = (numero7 - 9);
            }

            var numero9 = cedula.substring(8, 9);
            var numero9 = (numero9 * 2);
            if (numero9 > 9) {
                var numero9 = (numero9 - 9);
            }

            var impares = numero1 + numero3 + numero5 + numero7 + numero9;

            //Suma total
            var suma_total = (pares + impares);

            //extraemos el primero digito
            var primer_digito_suma = String(suma_total).substring(0, 1);

            //Obtenemos la decena inmediata
            var decena = (parseInt(primer_digito_suma) + 1) * 10;

            //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
            var digito_validador = decena - suma_total;

            //Si el digito validador es = a 10 toma el valor de 0
            if (digito_validador === 10)
                var digito_validador = 0;

            //Validamos que el digito validador sea igual al de la cedula
            if (digito_validador.toString() === ultimo_digito.toString()) {
                res = true;
            } else {
                smoke.signal('LA CEDULA: ' + cedula + ' ES INCORRECTA!!!', function (e) {

                }, {
                    duration: 3000,
                    classname: "custom-class"
                });
            }
        } else {
            smoke.signal("LA CEDULA NO PERTENECE A UNA REGION", function (e) {

            }, {
                duration: 3000,
                classname: "custom-class"
            });
        }
    } else {
        smoke.signal('LA CEDULA CONTIENE MENOS DE 10 DIGITOS', function (e) {

        }, {
            duration: 3000,
            classname: "custom-class"
        });
    }
    return res;
}

function ValidarNota() {

    var nota = document.getElementById("nota");
    nota = nota.value;
    var res = false;
    if (nota < 8 || nota > 10) {
        smoke.signal('LA NOTA INGRESADA ES INVALIDA', function (e) {
        }, {
            duration: 3000,
            classname: "custom-class"
        });
    } else {
        res = true;
    }
    return res;
}

function Revisar1() {
    if (ValidarNota()) {
        document.P.submit();
    }
}

function Revisar() {
    if (Validarcedula() && ValidarNota()) {
        document.P.submit();
    }
}

function ValidarFechas() {
    var res = false;
    var fecha_ini = document.getElementById("fecha_ini");
    var fecha_fin = document.getElementById("fecha_fin");
    fecha_ini = fecha_ini.value;
    fecha_fin = fecha_fin.value;
    var vec_ini = fecha_ini.split("/");
    var vec_fin = fecha_fin.split("/");

    if (vec_ini[0] > vec_fin[0]) {
        smoke.signal('ERROR: LA FECHA INICIAL ES MAYOR QUE LA FINAL', function (e) {
        }, {
            duration: 3000,
            classname: "custom-class"
        });
    } else {
        res = true;
    }
    if (vec_ini[0] === vec_fin[0]) {
        if (vec_ini[1] < vec_fin[1]) {
            if (vec_ini[2] < vec_fin[2]) {
                res = true;
            }
        }
    }
    return res;
}

function Revisar2() {
    if (ValidarFechas()) {
        document.P.submit();
    }
}


