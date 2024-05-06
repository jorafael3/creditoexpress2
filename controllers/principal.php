<?php


class Principal extends Controller
{

    function __construct()
    {

        parent::__construct();
    }
    function render()
    {

        $this->view->render('principal/nueva');
    }


    function Validar_Celular()
    {

        $array = json_decode(file_get_contents("php://input"), true);

        // echo json_encode($array["celular"]);
        // exit();

        if (strlen(trim($array["celular"])) != 10) {
            echo json_encode([0, "El teléfono no tiene un formato valido", "error"]);
            exit();
        } else {
            $TEL = $this->validateEcuadorianCellphone(trim($array["celular"]));
            if ($TEL == 0) {
                echo json_encode([0, "El teléfono no tiene un formato valido", "error"]);
                exit();
            } else {
                $TERMINOS = $array["terminos"];
                if ($TERMINOS != true) {
                    echo json_encode([0, "Debe aceptar los términos y condiciones para continuar", "info"]);
                    exit();
                } else {
                    $Ventas =  $this->model->Validar_Celular($array);
                }
            }
        }
    }

    function Validar_Codigo()
    {
        $array = json_decode(file_get_contents("php://input"), true);
        $celular = base64_decode($array["TELEFONO"]);
        $codigo = $array["CODIGO"];
        $c1 = $codigo[0];
        $c2 = $codigo[1];
        $c3 = $codigo[2];
        $c4 = $codigo[3];
        $CODIGO_JUNTO = strval($c1) . strval($c2) . strval($c3) . strval($c4);

        if (strlen($CODIGO_JUNTO) == 4) {
            $Ventas =  $this->model->Validar_Codigo($CODIGO_JUNTO, $celular);
        } else {
            echo json_encode([0, "El código debe tener 4 dígitos", "error"]);
            exit();
        }
    }

    function Validar_Cedula()
    {
        $array = json_decode(file_get_contents("php://input"), true);
        if (trim($array["cedula"]) == null || trim($array["cedula"]) == "") {
            echo json_encode([0, "Debe ingresar un numero de Cédula valido", "error"]);
            exit();
        } else {
            $length = strlen(trim($array["cedula"]));
            if ($length >= 10 && $length <= 13) {
                if (ctype_digit(trim($array["cedula"]))) {
                    $cedula = trim($array["cedula"]);
                    $email = trim($array["email"]);
                    if ($email == "") {
                        $Ventas =  $this->model->Validar_Cedula($array);
                    } else {
                        $VAL_EMAIL = $this->is_valid_email($email);
                        if ($VAL_EMAIL == true) {
                            $Ventas =  $this->model->Validar_Cedula($array);
                        } else {
                            echo json_encode([0, "El email no es valido", ""]);
                        }
                    }

                    // $_SESSION["CED"] = "";
                    // $_SESSION["CED"] = trim($array["cedula"]);
                    // $Ventas =  $this->model->Validar_Cedula($array);
                } else {
                    echo json_encode([0, "La cédula solo debe ser numérica", ""]);
                    exit();
                }
            } else {
                echo json_encode([0, "La cédula ingresada no tiene la cantidad de numeros correcta", ""]);
                exit();
            }
        }
    }

    function is_valid_email($str)
    {
        $matches = null;
        return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
    }

    function validateEcuadorianCellphone($cellphone)
    {
        // Regular expression pattern for a valid Ecuadorian cellphone number
        $pattern = '/^(09|\+5939)\d{8}$/';

        // Check if the provided cellphone number matches the pattern
        return preg_match($pattern, $cellphone);
    }

    function validarCedulaEcuador($cedula)
    {
        // Verificar longitud correcta
        if (strlen($cedula) != 10) {
            return false;
        }

        // Verificar que los primeros dígitos sean numéricos
        if (!ctype_digit(substr($cedula, 0, 9))) {
            return false;
        }

        // Obtener el dígito verificador
        $digitoVerificador = (int) substr($cedula, 9, 1);

        // Calcular el dígito verificador esperado
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $valor = (int) substr($cedula, $i, 1);
            $suma += ($i % 2 == 0) ? $valor : ($valor * 2 > 9 ? $valor * 2 - 9 : $valor * 2);
        }

        $digitoEsperado = ($suma % 10 === 0) ? 0 : 10 - ($suma % 10);

        // Comparar con el dígito verificador proporcionado
        return $digitoVerificador == $digitoEsperado;
    }

    function Generar_pdf()
    {

        $array = json_decode(file_get_contents("php://input"), true);
       
        $Ventas =  $this->model->Generar_pdf($array);
        // $this->CrecimientoCategoriasIndex();
    }
}
