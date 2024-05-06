<?php
// ejemplo.php
if (isset($argv[1])) {
    $parametro = $argv[2];
    echo "El parámetro recibido es: $parametro";
} else {
    echo "No se recibió ningún parámetro.";
}


function encryptCedula($cedula)
{
    // Contenido de la clave pública
    $public_key_file = dirname(__DIR__) . "/models/PBKey.txt";
    // Lee el contenido del archivo PEM
    $public_key_content = file_get_contents($public_key_file);
    // Elimina espacios en blanco adicionales alrededor del contenido
    $public_key_content = trim($public_key_content);

    $rsaKey = openssl_pkey_get_public($public_key_content);
    if (!$rsaKey) {
        // Manejar el error de obtener la clave pública
        return [0, openssl_error_string(), $public_key_file];
    }
    // // Divide el texto en bloques para encriptar
    $encryptedData = '';
    $encryptionSuccess = openssl_public_encrypt($cedula, $encryptedData, $rsaKey);

    // Obtener detalles del error, si hubo alguno
    // $error = openssl_error_string();
    // if ($error) {
    //     // Manejar el error de OpenSSL
    //     return $error;
    // }

    // Liberar la clave pública RSA de la memoria
    openssl_free_key($rsaKey);

    if ($encryptionSuccess === false) {
        // Manejar el error de encriptación
        return [0, null, $public_key_file];
    }

    // Devolver la cédula encriptada
    return [1, base64_encode($encryptedData)];
    // echo json_encode(base64_encode($encryptedData));
    // exit();
    // return ($encrypted);
}

function Obtener_Datos_Credito($param, $param_DATOS, $val)
{
    try {
        // $old_error_reporting = error_reporting();
        // Desactivar los mensajes de advertencia
        // error_reporting($old_error_reporting & ~E_WARNING);
        if ($val == 1) {
            $cedula = $param->CEDULA;
            $nacimiento = $param->FECHA_NACIM;
            $CELULAR = base64_decode($param_DATOS["celular"]);
        } else {
            $cedula = $param["CEDULA"];
            $nacimiento = $param["FECHA_NACIM"];
            $CELULAR = ($param_DATOS["celular"]);
        }



        // $cedula = "0930254909";
        $cedula_ECrip = $this->encryptCedula($cedula);
        if ($cedula_ECrip[0] == 0) {
            return [0, $cedula_ECrip, [], []];
        } else {
            $cedula_ECrip = $cedula_ECrip[1];
        }

        $fecha = DateTime::createFromFormat('d/m/Y', $nacimiento);
        $fecha_formateada = $fecha->format('Ymd');
        $ingresos = "500";
        $Instruccion = "SECU";
        $SEC = $this->Get_Secuencial_Api_Banco();
        $SEC = intval($SEC[0]["valor"]) + 1;

        $data = array(
            "transaccion" => 4001,
            "idSession" => "1",
            "secuencial" => $SEC,
            "mensaje" => array(
                "IdCasaComercialProducto" => 8,
                "TipoIdentificacion" => "CED",
                "IdentificacionCliente" => $cedula_ECrip, // Encriptar la cédula
                "FechaNacimiento" => $fecha_formateada,
                "ValorIngreso" => $ingresos,
                "Instruccion" =>  $Instruccion,
                "Celular" =>  $CELULAR
            )
        );

        // echo json_encode($data);
        // exit();
        // Convertir datos a JSON
        $data_string = json_encode($data);
        // URL del API
        $url = 'https://bs-autentica.com/cco/apiofertaccoqa1/api/CasasComerciales/GenerarCalificacionEnPuntaCasasComerciales';
        // API Key
        $api_key = '0G4uZTt8yVlhd33qfCn5sazR5rDgolqH64kUYiVM5rcuQbOFhQEADhMRHqumswphGtHt1yhptsg0zyxWibbYmjJOOTstDwBfPjkeuh6RITv32fnY8UxhU9j5tiXFrgVz';
        // Inicializa la sesión cURL
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        // Configura las opciones de la solicitud
        $verbose = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string),
            'ApiKeySuscripcion: ' . $api_key
        ));
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1');

        // Ejecuta la solicitud y obtiene la respuesta
        $response = (curl_exec($ch));
        // Cierra la sesión cURL
        $error = (curl_error($ch));
        curl_close($ch);
        // Imprime la respuesta
        // echo $response;
        // return [1, $ARRAY];
        rewind($verbose);
        $verboseLog = stream_get_contents($verbose);
        $response_array = json_decode($response, true);

        $this->Update_Secuencial_Api_Banco($SEC);

        // echo json_encode($response_array);
        // exit();
        // if (extension_loaded('curl')) {
        //     echo "cURL está habilitado en este servidor.";
        // } else {
        //     echo "cURL no está habilitado en este servidor.";
        // }

        // Verificar si hay un error en la respuesta
        if (isset($response_array['esError'])) {

            $_inci = array(
                "ERROR_TYPE" => "API_SOL",
                "ERROR_CODE" => $response_array['codigo'],
                "ERROR_TEXT" => $response_array['esError'] . "-"
                    . $response_array['descripcion'] . "-"
                    . $response_array['idSesion'] . "-"
                    . $response_array['secuencial'],
            );
            date_default_timezone_set('America/Guayaquil');
            $hora_actual = date('G');

            if ($response_array['esError'] == true) {
                if ($response_array['descripcion'] == "No tiene oferta") {
                    $INC = $this->INCIDENCIAS($_inci);
                    return [2, $response_array, $data, $INC];
                } else if ($response_array['descripcion'] == "Ha ocurrido un error" && $hora_actual >= 21) {
                    $INC = $this->INCIDENCIAS($_inci);
                    return [3, $response_array, $data, $INC, $hora_actual];
                }
            } else {
                $INC = $this->INCIDENCIAS($_inci);
                return [1, $response_array, $data];
            }
        } else {
            // $INC = $this->INCIDENCIAS($_inci);

            return [0, $response_array, $data, $error, $verboseLog, extension_loaded('curl')];
        }
    } catch (Exception $e) {
        // Captura la excepción y maneja el error
        // echo "Error: " . $e->getMessage();
        $param = array(
            "ERROR_TYPE" => "API_SOL_FUNCTION",
            "ERROR_CODE" => "",
            "ERROR_TEXT" => $e->getMessage(),
        );
        $this->INCIDENCIAS($param);
        return [0, "Error al procesar la solictud banco", $e->getMessage()];
    }
}
