<?php

// require_once "models/logmodel.php";
require('public/fpdf/fpdf.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


class principalmodel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    //*** CELULAR */

    function Validar_Celular($param)
    {
        // $this->Obtener_Datos_Credito($param);
        try {
            $celular = trim($param["celular"]);
            $terminos = $param["terminos"];
            $ip = $this->getRealIP();
            $dispositivo = $_SERVER['HTTP_USER_AGENT'];
            $numero_aleatorio = mt_rand(10000, 99999);
            // $ID_UNICO = date("Ymdhms").$numero_aleatorio;
            $SI_CONSULTO = $this->Validar_si_consulto_credito($param);
            // $SI_CONSULTO = 1;

            if ($SI_CONSULTO == 1) {
                $this->Anular_Codigos($param);
                $codigo = $this->Api_Sms($celular);
                if ($codigo[0] == 1) {
                    $query = $this->db->connect_dobra()->prepare('INSERT INTO solo_telefonos 
                        (
                            numero, 
                            codigo, 
                            terminos, 
                            ip, 
                            dispositivo
                        ) 
                        VALUES
                        (
                            :numero, 
                            :codigo, 
                            :terminos,
                            :ip, 
                            :dispositivo 
                        );
                    ');
                    $query->bindParam(":numero", $celular, PDO::PARAM_STR);
                    $query->bindParam(":codigo", $codigo[1], PDO::PARAM_STR);
                    $query->bindParam(":terminos", $terminos, PDO::PARAM_STR);
                    $query->bindParam(":ip", $ip, PDO::PARAM_STR);
                    $query->bindParam(":dispositivo", $dispositivo, PDO::PARAM_STR);

                    if ($query->execute()) {
                        $result = $query->fetchAll(PDO::FETCH_ASSOC);
                        $cel = base64_encode($celular);
                        // $ID_UNICO = base64_encode($ID_UNICO);
                        $codigo_temporal = "0000";
                        // $codigo_temporal = $this->Cargar_Codigo_Temporal($param);
                        $html = '
                            <div class="fv-row mb-10 text-center">
                                <label class="form-label fw-bold fs-2">Ingresa el código enviado a tu celular</label><br>
                                <label class="text-muted fw-bold fs-6">Verifica el número celular</label>
                                <input type="hidden" id="CEL_1" value="' . $cel . '">
                                <input type="hidden" id="CEL_1" value="' . $codigo_temporal . '">
                            </div>
                            <div class="row justify-content-center mb-5">
                                        <div class="col-md-12">
                                            <div class="row justify-content-center">
                                                <div class="col-auto">
                                                    <input type="text" maxlength="1" class="form-control code-input" />
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" maxlength="1" class="form-control code-input" />
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" maxlength="1" class="form-control code-input" />
                                                </div>
                                                <div class="col-auto">
                                                    <input type="text" maxlength="1" class="form-control code-input" />
                                                </div>
                                            </div>
                                        </div>
                            </div>';
                        echo json_encode([1, $celular, $html]);
                        exit();
                    } else {
                        $err = $query->errorInfo();
                        echo json_encode([0, "Error al generar solicitud, intentelo de nuevo", "error", $err]);
                        exit();
                    }
                }
            } else {
                echo json_encode([0, "Error al generar código, por favor intentelo en un momento", "error"]);
                exit();
            }
        } catch (PDOException $e) {

            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function Api_Sms($celular)
    {

        try {

            $url = 'https://api.smsplus.net.ec/sms/client/api.php/sendMessage';
            // $url = 'http://186.3.87.6/sms/ads/api.php/getMessage';

            $codigo = rand(1000, 9999);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $username = '999990165';
            $password = 'bt3QVPyQ6L8e97hs';

            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $phoneNumber = $celular;
            $messageId = "144561";
            // $transactionId = 141569;
            $dataVariable = [$codigo];
            $transactionId = uniqid();

            $dataWs = [
                'phoneNumber' => $phoneNumber,
                'messageId' => $messageId,
                'transactionId' => $transactionId,
                'dataVariable' => $dataVariable,
            ];

            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataWs));

            // Set Basic Authentication
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

            // for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $resp = curl_exec($curl);
            curl_close($curl);
            // $resp = '{"codError":100,"desError":"OK","transactionId":"240305230212179130"}';

            $responseData = json_decode($resp, true);

            // Verificar si la solicitud fue exitosa
            // Verificar el código de error y mostrar la respuesta
            if (isset($responseData['codError'])) {
                if ($responseData['codError'] == 100) {
                    // echo "Mensaje enviado correctamente. Transaction ID: ";
                    // echo json_encode("");
                    return [1, $codigo, $responseData];
                } else {
                    return [0, 0];
                    // echo "Error: " . $responseData['desError'];
                }
            } else {
                return [0, 0];
                // echo "Error desconocido al enviar el mensaje.";
            }
        } catch (Exception $e) {

            $e = $e->getMessage();
            return [0, 0];
        }
        // echo json_encode($resp);
        // exit();
    }

    function Cargar_Codigo_Temporal($param)
    {
        try {
            $celular = trim($param["celular"]);

            $query = $this->db->connect_dobra()->prepare('SELECT * FROM solo_telefonos
                Where numero = :numero and estado = 1');
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);

            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return ($result[0]["codigo"]);
            } else {
                $err = $query->errorInfo();
                echo json_encode([0, "Error al generar solicitud, intentelo de nuevo", "error", $err]);
                exit();
            }
        } catch (PDOException $e) {

            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    //************************************************* */

    function Validar_si_consulto_credito($param)
    {
        try {
            date_default_timezone_set('America/Guayaquil');
            $celular = trim($param["celular"]);
            $query = $this->db->connect_dobra()->prepare('SELECT * FROM creditos_solicitados
            WHERE numero = :numero and API_SOL_ESTADO != 0
            order by fecha_creado desc
            limit 1');
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                // echo json_encode($result);
                // exit();
                if (count($result) == 0) {
                    return 1;
                } else {

                    $DATOS_CREDITO_ = $result[0];


                    $currentDateTime = new DateTime();
                    $FECHA = $DATOS_CREDITO_["fecha_creado"];
                    $formattedDateTime = new DateTime($FECHA);
                    $difference = $currentDateTime->diff($formattedDateTime);
                    $daysDifference = $difference->days;

                    if ($daysDifference >= 15) {
                        $p = array(
                            "cedula" => $DATOS_CREDITO_["cedula"],
                            "celular" => base64_encode($DATOS_CREDITO_["numero"]),
                            "email" => $DATOS_CREDITO_["correo"],
                            "tipo" => 2,
                        );
                        $this->Validar_Cedula($p);
                        // echo json_encode($DATOS_CREDITO_);
                        // exit();
                    } else {

                        $ID_UNICO_TRANSACCION = $DATOS_CREDITO_["ID_UNICO"];
                        $TIPO_CONSULTA = 2; // CELULAR YA HICE UNA CONSULTA ANTERIOR
                        $this->MOSTRAR_RESULTADO($DATOS_CREDITO_, $ID_UNICO_TRANSACCION, $TIPO_CONSULTA);
                    }
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {

            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    //*** PONE EN 0 LOS CODIGOS ANTERIORES PARA PODER VALIDAR EL NUEVO
    function Anular_Codigos($param)
    {
        try {
            $celular = trim($param["celular"]);
            $query = $this->db->connect_dobra()->prepare('UPDATE solo_telefonos
            SET
                estado = 0
            WHERE numero = :numero
            ');
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);
            if ($query->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {

            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function Validar_Codigo($CODIGO_JUNTO, $celular)
    {
        try {
            $query = $this->db->connect_dobra()->prepare('SELECT ID from solo_telefonos
            where numero = :numero and codigo = :codigo and estado = 1');
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);
            $query->bindParam(":codigo", $CODIGO_JUNTO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $cel = base64_encode($celular);
                $html = '
             
                    <div id="SECCION_INGRESO_DATOS" class="">
                        <div class="fv-row mb-10">
                    
                            <label class="form-label d-flex align-items-center">
                                <span class="required fw-bold fs-2">Cédula</span>
                            </label>
                            <input type="hidden" id="CEL" value="' . $cel . '">
                            <input placeholder="xxxxxxxxxx" id="CEDULA" type="text" class="form-control form-control-solid" name="input1" placeholder="" value="" />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label d-flex align-items-center">
                                <span class="fw-bold fs-2">Número de teléfono</span><br>
                            </label>
                            <h6 class="text-muted">Ten en cuenta que este número se asociará a la cédula que ingrese para proximas consultas</h6>
                            <input readonly id="" type="text" class="form-control form-control-solid" name="input1" value="' . $celular . '" />
                        </div>
                        <div class="fv-row mb-10">
                            <label class="form-label d-flex align-items-center">
                                <span class="fw-bold fs-2">Correo </span>
                                <span class="text-muted fw-bold fs-5">(opcional)</span>
                            </label>
                            <h6 class="text-muted">Aquí tambien enviaremos el resultado de tu consulta</h6>
                            <input placeholder="xxxxxxx@mail.com" id="CORREO" type="text" class="form-control form-control-solid" name="input1" placeholder="" value="" />
                        </div>
                      
                    </div>
                ';
                if (count($result) > 0) {
                    echo json_encode([1, $celular, $html, $result]);
                    exit();
                } else {
                    echo json_encode([0, "El codigo ingresado no es el correcto", "error"]);
                    exit();
                }
            } else {
                $err = $query->errorInfo();
                echo json_encode([0, "Error al generar solicitud, intentelo de nuevo", "error", $err]);
                exit();
            }
        } catch (PDOException $e) {

            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    ///************************** */
    ///************************** */
    ///************************** */
    ///************************** */
    //********** CEDULA *********/

    function Validar_Cedula($param)
    {
        try {
            date_default_timezone_set('America/Guayaquil');
            $link = constant("URL") . "/public/img/SV24 - Mensajes LC_Proceso.png";
            $RUTA_ARCHIVO = trim($param["cedula"]) . "_" . date("YmdHis") . ".pdf";
            $tipo = $param["tipo"];
            $VAL_CONSULTA = $this->VALIDAR_CEDULA_ASOCIADA_OTRO_NUMERO($param);
            $CEDULA_ = trim($param["cedula"]);
            $celular = base64_decode(trim($param["celular"]));
            $SMS = $param["tipo"];

            // echo json_encode([$VAL_CONSULTA]);
            // exit();
            if ($param["IMAGEN"] != null) {
                echo json_encode([0, "", "Debe tomarse una foto valida", "error"]);
                exit();
            } else {
                $IMAGEN = explode("base64,", $param["IMAGEN"]);
                $IMAGEN = "";
                // $IMAGEN = $IMAGEN[1];
                if ($VAL_CONSULTA[0] == 1) {
                    //* INSERTA SOLO CEDULA EN TABLA
                    $VAL_CEDULA_ = $this->INSERTAR_CEDULA_($param);
                    // echo json_encode($VAL_CEDULA_);
                    // exit();
                    if ($VAL_CEDULA_[0] == 1) {
                        $ID_UNICO_TRANSACCION = $VAL_CEDULA_[2];
                        $DATOS_API_CEDULA = $this->DATOS_API_REGISTRO($ID_UNICO_TRANSACCION, $IMAGEN);

                        if ($DATOS_API_CEDULA[0] == 1) {
                            $GUARDAR_DATOS_API_REG = $this->GUARDAR_DATOS_API_REGISTRO($DATOS_API_CEDULA[1]["SOCIODEMOGRAFICO"][0], $ID_UNICO_TRANSACCION);
                            if ($GUARDAR_DATOS_API_REG[0] == 1) {
                                $FECHA_NACIM = trim($DATOS_API_CEDULA[1]["SOCIODEMOGRAFICO"][0]["FECH_NAC"]);
                                $DATOS_CRE = $this->Obtener_Datos_Credito($CEDULA_, $FECHA_NACIM, $celular, $ID_UNICO_TRANSACCION);
                                if ($DATOS_CRE[0] == 1) {
                                    $DATOS_API_CREDITO = $this->DATOS_API_CREDITO($ID_UNICO_TRANSACCION);
                                    if ($DATOS_API_CREDITO[0] == 1) {
                                        $DATOS_CREDITO_ = $DATOS_API_CREDITO[1][0];
                                        $TIPO_CONSULTA = $tipo;
                                        $this->MOSTRAR_RESULTADO($DATOS_CREDITO_, $ID_UNICO_TRANSACCION, $TIPO_CONSULTA);
                                        // echo json_encode($DATOS_API_CREDITO);
                                        // exit();
                                    }
                                } else if ($DATOS_CRE[0] == 2) {
                                    $_inci = array(
                                        "ERROR_TYPE" => "API SOL 2",
                                        "ERROR_CODE" => json_encode($DATOS_CRE[1]),
                                        "ERROR_TEXT" => json_encode($DATOS_CRE[2]),
                                    );
                                    $INC = $this->INCIDENCIAS($_inci);
                                    $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                                    echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $DATOS_CRE]);
                                    exit();
                                } else if ($DATOS_CRE[0] == 3) {
                                    $_inci = array(
                                        "ERROR_TYPE" => "API SOL 3",
                                        "ERROR_CODE" => json_encode($DATOS_CRE[1]),
                                        "ERROR_TEXT" => json_encode($DATOS_CRE[2]),
                                    );
                                    $INC = $this->INCIDENCIAS($_inci);
                                    $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                                    echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $_inci]);
                                    exit();
                                } else {
                                    $_inci = array(
                                        "ERROR_TYPE" => "API SOL",
                                        "ERROR_CODE" => $DATOS_CRE[1],
                                        "ERROR_TEXT" => $DATOS_CRE[2] . "-" . $DATOS_CRE[3],
                                    );
                                    $INC = $this->INCIDENCIAS($_inci);
                                    $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                                    echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $DATOS_CRE]);
                                    exit();
                                }
                            } else {
                                $_inci = array(
                                    "ERROR_TYPE" => "ERROR GUARDAR_DATOS_API_REG",
                                    "ERROR_CODE" => $GUARDAR_DATOS_API_REG[1],
                                    "ERROR_TEXT" => $GUARDAR_DATOS_API_REG[2],
                                );
                                $INC = $this->INCIDENCIAS($_inci);
                                $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                                echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $_inci]);
                                exit();
                            }
                        } else if ($DATOS_API_CEDULA[0] == 2) {
                            $_inci = array(
                                "ERROR_TYPE" => "ENCRIP",
                                "ERROR_CODE" => ($DATOS_API_CEDULA[1]),
                                "ERROR_TEXT" => "ERROR AL OBTENER CEDULA ENCRIPTADA",
                            );
                            $INC = $this->INCIDENCIAS($_inci);
                            $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                            echo json_encode([0, "Error al realizar la consulta", $DATOS_API_CEDULA[1], $_inci]);
                            exit();
                        } else if ($DATOS_API_CEDULA[0] == 3) {
                            $_inci = array(
                                "ERROR_TYPE" => "ERROR API REG",
                                "ERROR_CODE" => $DATOS_API_CEDULA[1] . "-" . $DATOS_API_CEDULA[2],
                                "ERROR_TEXT" => "API NO TIENE RESPUESTA",
                            );
                            $INC = $this->INCIDENCIAS($_inci);
                            $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                            echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $_inci]);
                            exit();
                        } else {
                            $_inci = array(
                                "ERROR_TYPE" => "ERROR DATOS_API_REGISTRO",
                                "ERROR_CODE" => "DATOS_API_REGISTRO",
                                "ERROR_TEXT" => "ERROR EN RESPUESTA",
                            );
                            $INC = $this->INCIDENCIAS($_inci);
                            $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                            echo json_encode([0, "Error al realizar la consulta", "Por favor intentelo en un momento", "error", $_inci]);
                            exit();
                        }
                    } else {
                        echo json_encode([0, $VAL_CEDULA_[1], "Asegurese que la cédula ingresada sea la correcta", "error"]);
                        exit();
                    }
                } else {
                    echo json_encode([0, $VAL_CONSULTA[1], "Asegurese que la cédula ingresada sea la correcta", "error"]);
                    exit();
                }
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode([0, "No se pudo realizar la verificaciolln", "Intentelo de nuevo", $e]);
            exit();
        }
    }

    //******************************************** */
    //*** VALIDAR SI CEDULA ESTA ASOCIADA A OTRO NUMERO */

    function VALIDAR_CEDULA_ASOCIADA_OTRO_NUMERO($param)
    {
        try {
            $cedula = trim($param["cedula"]);
            $celular = base64_decode(trim($param["celular"]));
            $query = $this->db->connect_dobra()->prepare('SELECT * from
                creditos_solicitados
                WHERE cedula = :cedula
                and estado = 1
                order by fecha_creado desc
                limit 1
            ');
            $query->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    if ($result[0]["numero"] != $celular) {
                        return [0, "Esta cédula esta asociado a otro número que ya realizo una consulta", $result];
                    } else {
                        return [1, "", $result];
                    }
                } else {
                    return [1, "", $result];
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    //******************************************** */
    //** CREA LA LINEA DE LA CEDULA CON LOS DATOS PRINCIPALES */
    function INSERTAR_CEDULA_($param)
    {
        try {
            $cedula = trim($param["cedula"]);
            $celular = base64_decode(trim($param["celular"]));
            $correo = (trim($param["email"]));
            $ID_UNICO = date("Ymdhms") . $cedula;
            $ip = $this->getRealIP();
            $dispositivo = $_SERVER['HTTP_USER_AGENT'];

            $query = $this->db->connect_dobra()->prepare('INSERT INTO 
                creditos_solicitados
                (
                    cedula,
                    numero,
                    correo,
                    ID_UNICO,
                    ip,
                    dispositivo
                )
            VALUES
                (
                    :cedula,
                    :numero,
                    :correo,
                    :ID_UNICO,
                    :ip,
                    :dispositivo
                );
            ');
            $query->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);
            $query->bindParam(":correo", $correo, PDO::PARAM_STR);
            $query->bindParam(":ip", $ip, PDO::PARAM_STR);
            $query->bindParam(":dispositivo", $dispositivo, PDO::PARAM_STR);
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);

            if ($query->execute()) {
                $query2 = $this->db->connect_dobra()->prepare('SELECT * FROM creditos_solicitados
                WHERE 
                    ID_UNICO = :ID_UNICO
                ');
                $query2->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
                if ($query2->execute()) {
                    $result = $query2->fetchAll(PDO::FETCH_ASSOC);
                    return [1, "INSERTAR_CEDULA_", $result[0]["ID_UNICO"]];
                } else {
                    return [0, "Error al realizar la consulta, por favor intentelo de nuevo"];
                }
            } else {
                return [0, "Error al realizar la consulta, por favor intentelo de nuevo"];
            }
            // $query = $this->db->connect_dobra()->prepare('SELECT * from
            //     creditos_solicitados
            //     WHERE cedula = :cedula
            //     and estado = 1
            // ');
            // $query->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            // if ($query->execute()) {
            //     $result = $query->fetchAll(PDO::FETCH_ASSOC);
            //     if (count($result) > 0) {
            //         return [1, $result];
            //     } else {

            //     }
            // } else {
            //     return 0;
            // }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    //******************************************** */
    //** OBTIENE DATOS API REGISTRO */

    function CONSULTA_API_REG($cedula_encr, $ID_UNICO_TRANSACCION, $IMAGEN,$encry2)
    {

        $CONSULTA_API_REG_BIO = $this->CONSULTA_API_REG_BIO($cedula_encr, $IMAGEN);

        if ($CONSULTA_API_REG_BIO[0] == 1) {
            $ERROR_FOTO = isset($CONSULTA_API_REG_BIO[1]["RECONOCIMIENTO"][0]["Error"]);
            if ($ERROR_FOTO == "No") {
                $SIMILITUD = $CONSULTA_API_REG_BIO[1]["RECONOCIMIENTO"][0]["Similitud"];
                if (intval($SIMILITUD )>= 95) {
                    $GUARDAR_DATOS_API_REG_BIO = $this->GUARDAR_DATOS_API_REG_BIO($ID_UNICO_TRANSACCION, $CONSULTA_API_REG_BIO[1], $IMAGEN);
                    if ($GUARDAR_DATOS_API_REG_BIO[0] == 1) {
                        $CONSULTA_API_REG_DEMOGRAFICO = $this->CONSULTA_API_REG_DEMOGRAFICO($encry2);
                        // echo json_encode($CONSULTA_API_REG_DEMOGRAFICO);
                        // exit();
                        if ($CONSULTA_API_REG_DEMOGRAFICO[0] == 1) {

                            $GUARDAR_DATOS_API_REG_DEMOGRAFICO = $this->GUARDAR_DATOS_API_REG_DEMOGRAFICO($ID_UNICO_TRANSACCION, $CONSULTA_API_REG_DEMOGRAFICO[1]);
                            if ($GUARDAR_DATOS_API_REG_DEMOGRAFICO[0] == 1) {
                                //$CONSULTA_API_REG_SENCILLA = $this->CONSULTA_API_REG_SENCILLA($cedula_encr);
                                // echo json_encode($CONSULTA_API_REG_SENCILLA);
                                // exit();
                                return $CONSULTA_API_REG_DEMOGRAFICO;
                            } else {
                                return [0, "Error al procesar la informacion, intentelo de nuevo", $GUARDAR_DATOS_API_REG_DEMOGRAFICO];
                            }
                        } else {
                            return [0, "Error al procesar la informacion, intentelo de nuevo", $CONSULTA_API_REG_DEMOGRAFICO];
                        }
                    } else {
                        return [0, "Error al procesar la informacion, intentelo de nuevo", $GUARDAR_DATOS_API_REG_BIO];
                    }
                } else {
                    $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                    return [2, "La foto no es valida, por favor tomela nuevamente", $SIMILITUD];
                }
            } else {
                $this->ELIMINAR_LINEA_ERROR($ID_UNICO_TRANSACCION);
                return [2, "Error al procesar la informacion, la foto no es valida o la cedula es incorrecta", $CONSULTA_API_REG_BIO, $ERROR_FOTO];
            }
        } else {
            return [0, "Error al procesar la informacion, intentelo de nuevo", $CONSULTA_API_REG_BIO];
        }


        // return $SIMILITUD;
    }

    function CONSULTA_API_REG_SENCILLA($cedula_encr)
    {
        // $cedula_encr = "yt3TIGS4cvQQt3+q6iQ2InVubHr4hm4V7cxn1V3jFC0=";
        $old_error_reporting = error_reporting();
        // Desactivar los mensajes de advertencia
        error_reporting($old_error_reporting & ~E_WARNING);
        // Realizar la solicitud
        // Restaurar el nivel de informe de errores original

        try {
            $url = 'https://consultadatos-dataconsulting.ngrok.app/api/GetDataBasica?code=Hp37f_WfqrsgpDyl8rP9zM1y-JRSJTMB0p8xjQDSEDszAzFu7yW3XA==&id=' . $cedula_encr . '&emp=SALVACERO&subp=DATOSCEDULA';

            // $url = 'https://consultadatosapi.azurewebsites.net/api/GetDataBasica?code=Hp37f_WfqrsgpDyl8rP9zM1y-JRSJTMB0p8xjQDSEDszAzFu7yW3XA==&id=' . $cedula_encr . '&emp=SALVACERO&subp=DATOSCEDULA';
            // $url = 'https://apidatoscedula20240216081841.azurewebsites.net/api/GetData?code=FXs4nBycLJmBacJWuk_olF_7thXybtYRFDDyaRGKbnphAzFuQulUlA==&id=' . $cedula_encr . '&emp=SALVACERO&subp=DATOSCEDULA';
            try {
                // $curl = curl_init($url);
                // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                // $response = curl_exec($curl);





                // Realizar la solicitud
                $response = file_get_contents($url);
                $http_status = substr($http_response_header[0], 9, 3);
                // echo json_encode($http_status);
                // exit();
                error_reporting($old_error_reporting);
                if ($http_status === "200") {
                    if ($response === false) {
                        // $data = json_decode($response);
                        return [2, []];
                    } else {
                        $data = json_decode($response);
                        if (isset($data->error)) {
                            return [0, $data->error, $cedula_encr];
                        } else {
                            if (count(($data->DATOS)) > 0) {
                                return [1, $data->DATOS];
                            } else {
                                return [0, $data->DATOS];
                            }
                        }
                    }
                } else {
                    return [3, $http_status, $url];
                }
            } catch (Exception $e) {
                // Capturar y manejar la excepción
                echo json_encode([0, "ssssss"]);
                exit();
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    ///*************** API RECONOCIMIENTO ***************************************/

    function CONSULTA_API_REG_BIO($cedula_encr, $imagen)
    {
        // $cedula_encr = "yt3TIGS4cvQQt3+q6iQ2InVubHr4hm4V7cxn1V3jFC0=";
        $old_error_reporting = error_reporting();
        // Desactivar los mensajes de advertencia
        error_reporting($old_error_reporting & ~E_WARNING);
        // Realizar la solicitud
        // Restaurar el nivel de informe de errores original

        try {

            $url = "https://reconocimiento-dataconsulting.ngrok.app/api/Reconocimiento?code=1LbmHAOC5xcBDW2Lw2eZrGDSQ-9nmBMFZ_sqbHHd7TVaAzFutMbWVQ==";

            // Datos a enviar en la solicitud POST
            $data = [
                "id" => $cedula_encr,
                "emp" => "SALVACERO",
                "selfie" => "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",
            ];

            // Codificar los datos en formato JSON
            $jsonData = json_encode($data);

            // Inicializar cURL
            $ch = curl_init($url);

            // Configurar opciones de cURL
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta como una cadena de texto
            curl_setopt($ch, CURLOPT_POST, true); // Enviar una solicitud POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Datos a enviar en la solicitud POST
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData),
                'apiKey: DNkAgQHRnuMIwJFY3pVCrwDtmyuJajmQEMlE' // Agregar la API key en el encabezado
            ]);

            // Ejecutar la solicitud
            $response = curl_exec($ch);

            // Manejar errores
            if (curl_errno($ch)) {
                // echo 'Error:' . curl_error($ch);
                return [0, curl_error($ch)];
            } else {
                $data = json_decode($response, true);
                return [1, $data];
            }
            // Cerrar cURL
            curl_close($ch);
        } catch (Exception $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function GUARDAR_DATOS_API_REG_BIO($ID_UNICO_TRANSACCION, $datos, $IMAGEN)
    {
        try {
            $data = $datos["DATOS"][0];
            // echo json_encode($datos);
            // exit();
            // Conectar a la base de datos
            // Definir los parámetros
            $id_unico = $ID_UNICO_TRANSACCION;
            $IMG = $datos["FOTOGRAFIA"][0]["Fotografia"];
            $SIMILITUD = $datos["RECONOCIMIENTO"][0]["Similitud"];

            $fileName = $ID_UNICO_TRANSACCION . "_1.jpeg";
            $fileName2 = $ID_UNICO_TRANSACCION . "_2.jpeg";


            // Preparar la consulta
            $query = $this->db->connect_dobra()->prepare("INSERT INTO Datos_Reconocimiento(
                ID_UNICO, CEDULA, NOMBRES, DES_SEXO, DES_CIUDADANIA, FECHA_NACIM,
                PROV_NAC, CANT_NAC, PARR_NAC, DES_NACIONALIDAD, ESTADO_CIVIL,
                DES_NIV_ESTUD, DES_PROFESION, NOMBRE_CONYUG, CEDULA_CONYUG,
                FECHA_MATRIM, LUG_MATRIM, NOM_PADRE, NAC_PADRE, CED_PADRE,
                NOM_MADRE, NAC_MADRE, CED_MADRE, FECHA_DEFUNC, PROV_DOM,
                CANT_DOM, PARR_DOM, DIRECCION, INDIVIDUAL_DACTILAR,
                IMAGEN,
                IMAGEN_NOMBRE,
                IMAGEN_2,
                IMAGEN_2_NOMBRE,
                SIMILITUD
            ) VALUES (
                :ID_UNICO, :CEDULA, :NOMBRES, :DES_SEXO, :DES_CIUDADANIA, :FECHA_NAC,
                :PROV_NAC, :CANT_NAC, :PARR_NAC, :DES_NACIONALIDAD, :ESTADO_CIVIL,
                :DES_NIV_ESTUD, :DES_PROFESION, :NOMBRE_CONYUG, :CEDULA_CONYUG,
                :FECHA_MATRIM, :LUG_MATRIM, :NOM_PADRE, :NAC_PADRE, :CED_PADRE,
                :NOM_MADRE, :NAC_MADRE, :CED_MADRE, :FECHA_DEFUNC, :PROV_DOM,
                :CANT_DOM, :PARR_DOM, :DIRECCION, :INDIVIDUAL_DACTILAR,
                :IMAGEN,
                :IMAGEN_NOMBRE,
                :IMAGEN_2,
                :IMAGEN_2_NOMBRE,
                :SIMILITUD
            )");


            // Vincular los parámetros
            $query->bindParam(':ID_UNICO', $id_unico, PDO::PARAM_STR);
            $query->bindParam(':CEDULA', $data['CEDULA'], PDO::PARAM_STR);
            $query->bindParam(':NOMBRES', $data['NOMBRES'], PDO::PARAM_STR);
            $query->bindParam(':DES_SEXO', $data['DES_SEXO'], PDO::PARAM_STR);
            $query->bindParam(':DES_CIUDADANIA', $data['DES_CIUDADANIA'], PDO::PARAM_STR);
            $query->bindParam(':FECHA_NAC', $data['FECHA_NACIM'], PDO::PARAM_STR);
            $query->bindParam(':PROV_NAC', $data['PROV_NAC'], PDO::PARAM_STR);
            $query->bindParam(':CANT_NAC', $data['CANT_NAC'], PDO::PARAM_STR);
            $query->bindParam(':PARR_NAC', $data['PARR_NAC'], PDO::PARAM_STR);
            $query->bindParam(':DES_NACIONALIDAD', $data['DES_NACIONALIDAD'], PDO::PARAM_STR);
            $query->bindParam(':ESTADO_CIVIL', $data['ESTADO_CIVIL'], PDO::PARAM_STR);
            $query->bindParam(':DES_NIV_ESTUD', $data['DES_NIV_ESTUD'], PDO::PARAM_STR);
            $query->bindParam(':DES_PROFESION', $data['DES_PROFESION'], PDO::PARAM_STR);
            $query->bindParam(':NOMBRE_CONYUG', $data['NOMBRE_CONYUG'], PDO::PARAM_STR);
            $query->bindParam(':CEDULA_CONYUG', $data['CEDULA_CONYUG'], PDO::PARAM_STR);
            $query->bindParam(':FECHA_MATRIM', $data['FECHA_MATRIM'], PDO::PARAM_STR);
            $query->bindParam(':LUG_MATRIM', $data['LUG_MATRIM'], PDO::PARAM_STR);
            $query->bindParam(':NOM_PADRE', $data['NOM_PADRE'], PDO::PARAM_STR);
            $query->bindParam(':NAC_PADRE', $data['NAC_PADRE'], PDO::PARAM_STR);
            $query->bindParam(':CED_PADRE', $data['CED_PADRE'], PDO::PARAM_STR);
            $query->bindParam(':NOM_MADRE', $data['NOM_MADRE'], PDO::PARAM_STR);
            $query->bindParam(':NAC_MADRE', $data['NAC_MADRE'], PDO::PARAM_STR);
            $query->bindParam(':CED_MADRE', $data['CED_MADRE'], PDO::PARAM_STR);
            $query->bindParam(':FECHA_DEFUNC', $data['FECHA_DEFUNC'], PDO::PARAM_STR);
            $query->bindParam(':PROV_DOM', $data['PROV_DOM'], PDO::PARAM_STR);
            $query->bindParam(':CANT_DOM', $data['CANT_DOM'], PDO::PARAM_STR);
            $query->bindParam(':PARR_DOM', $data['PARR_DOM'], PDO::PARAM_STR);
            $query->bindParam(':DIRECCION', $data['DIRECCION'], PDO::PARAM_STR);
            $query->bindParam(':INDIVIDUAL_DACTILAR', $data['INDIVIDUAL_DACTILAR'], PDO::PARAM_STR);
            $query->bindParam(':IMAGEN', $IMG, PDO::PARAM_STR);
            $query->bindParam(':IMAGEN_NOMBRE', $fileName, PDO::PARAM_STR);
            $query->bindParam(':IMAGEN_2', $IMAGEN, PDO::PARAM_STR);
            $query->bindParam(':IMAGEN_2_NOMBRE', $fileName2, PDO::PARAM_STR);
            $query->bindParam(':SIMILITUD', $SIMILITUD, PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);


                $data = base64_decode($IMG);
                $dat2a = base64_decode($IMAGEN);
                $uploadDir = 'recursos/img_bio/';
                $filePath = $uploadDir . $fileName;
                $filePath2 = $uploadDir . $fileName2;

                $permisos = 0777;
                if (chmod($uploadDir, $permisos)) {
                }
                // Guardar la imagen en la carpeta
                if (file_put_contents($filePath, $data)) {
                }

                if (file_put_contents($filePath2, $dat2a)) {
                }
                return [1, $uploadDir];
            } else {
                $err = $query->errorInfo();
                return [0, $err];
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO: " . $e];
        }
    }

    ///*************** API DEMOGRAFICO ***************************************/

    function CONSULTA_API_REG_DEMOGRAFICO($cedula_encr)
    {
        // $cedula_encr = "yt3TIGS4cvQQt3+q6iQ2InVubHr4hm4V7cxn1V3jFC0=";
        $old_error_reporting = error_reporting();
        // Desactivar los mensajes de advertencia
        error_reporting($old_error_reporting & ~E_WARNING);
        // Realizar la solicitud
        // Restaurar el nivel de informe de errores original

        try {

            $url = "https://consultadatos-dataconsulting.ngrok.app/api/ServicioMFC?clientId=".$cedula_encr;

            // Datos a enviar en la solicitud POST
            $data = [
                "id" => $cedula_encr,
                "emp" => "SALVACERO",
                "img" => ""
            ];

            // Codificar los datos en formato JSON
            $jsonData = json_encode($data);

            // Inicializar cURL
            $ch = curl_init($url);

            // Configurar opciones de cURL
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Recibir la respuesta como una cadena de texto
            curl_setopt($ch, CURLOPT_POST, true); // Enviar una solicitud POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Datos a enviar en la solicitud POST
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData),
                'apiKey: DNkAgQHRnuMIwJFY3pVCrwDtmyuJajmQEMlE' // Agregar la API key en el encabezado
            ]);

            // Ejecutar la solicitud
            $response = curl_exec($ch);

            // Manejar errores
            if (curl_errno($ch)) {
                // echo 'Error:' . curl_error($ch);
                return [0, curl_error($ch)];
            } else {
                $data = json_decode($response, true);
                return [1, $data];
            }
            // Cerrar cURL
            curl_close($ch);
        } catch (Exception $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function GUARDAR_DATOS_API_REG_DEMOGRAFICO($ID_UNICO_TRANSACCION, $datos)
    {
        try {
            $data = $datos["CALIFICACION"][0];
            // echo json_encode($data);
            // exit();
            // Conectar a la base de datos
            // Definir los parámetros
            $id_unico = $ID_UNICO_TRANSACCION;

            // Preparar la consulta
            $query = $this->db->connect_dobra()->prepare("INSERT INTO Datos_Empleo (
                DEPENDIENTE, INDEPENDIENTE, CALIFICACION_SD, CALIFICACION_CR, 
                CALIFICACION_TOT, RELACION_DEPENDENCIA, SALARIO, 
                SALARIO_DEPURADO, CUOTA_ESTIMADA, IDENTIFICACION,ID_UNICO
            ) VALUES (
                :DEPENDIENTE, :INDEPENDIENTE, :CALIFICACION_SD, :CALIFICACION_CR, 
                :CALIFICACION_TOT, :RELACION_DEPENDENCIA, :SALARIO, 
                :SALARIO_DEPURADO, :CUOTA_ESTIMADA, :IDENTIFICACION,:ID_UNICO
            )");


            // Vincular los parámetros
            $query->bindParam(':DEPENDIENTE', $data['DEPENDIENTE'], PDO::PARAM_STR);
            $query->bindParam(':INDEPENDIENTE', $data['INDEPENDIENTE'], PDO::PARAM_STR);
            $query->bindParam(':CALIFICACION_SD', $data['CALIFICACION_SD'], PDO::PARAM_STR);
            $query->bindParam(':CALIFICACION_CR', $data['CALIFICACION_CR'], PDO::PARAM_STR);
            $query->bindParam(':CALIFICACION_TOT', $data['CALIFICACION_TOT'], PDO::PARAM_STR);
            $query->bindParam(':RELACION_DEPENDENCIA', $data['RELACION_DEPENDENCIA'], PDO::PARAM_STR);
            $query->bindParam(':SALARIO', $data['SALARIO'], PDO::PARAM_STR);
            $query->bindParam(':SALARIO_DEPURADO', $data['SALARIO_DEPURADO'], PDO::PARAM_STR);
            $query->bindParam(':CUOTA_ESTIMADA', $data['CUOTA_ESTIMADA'], PDO::PARAM_STR);
            $query->bindParam(':IDENTIFICACION', $data['IDENTIFICACION'], PDO::PARAM_STR);
            $query->bindParam(':ID_UNICO', $id_unico, PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return [1];
            } else {
                $err = $query->errorInfo();
                return [0, $err];
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO: " . $e];
        }
    }
    //************************************************************************* */



    function DATOS_API_REGISTRO($ID_UNICO_TRANSACCION, $IMAGEN)
    {
        try {
            set_time_limit(180);
            $start_time = microtime(true);

            // sleep(4);
            $ID_UNICO = trim($ID_UNICO_TRANSACCION);
            $arr = "";
            while (true) {
                $current_time = microtime(true);
                $elapsed_time = $current_time - $start_time;
                // Verificar si el tiempo transcurrido excede el límite de tiempo máximo permitido (por ejemplo, 120 segundos)
                if (round($elapsed_time, 0) >= 180) {
                    $_inci = array(
                        "ERROR_TYPE" => "API SOL 2",
                        "ERROR_CODE" => "API SOL MAX EXCECUTIN TIME",
                        "ERROR_TEXT" => $ID_UNICO_TRANSACCION,
                    );
                    $INC = $this->INCIDENCIAS($_inci);
                    return [2, "La consulta excedió el tiempo máximo permitido"];
                }
                // echo json_encode("Tiempo transcurrido: " . $elapsed_time . " segundos\n");

                $query = $this->db->connect_dobra()->prepare("SELECT 
                *
                FROM creditos_solicitados
                WHERE ID_UNICO = :ID_UNICO
                and estado = 1");
                $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
                if ($query->execute()) {
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) > 0) {
                        $encry = trim($result[0]["cedula_encr"]);
                        $encry2 = trim($result[0]["cedula_encr2"]);
                        if ($encry != null && $encry2 != null) {
                            $en = $this->CONSULTA_API_REG($encry, $ID_UNICO_TRANSACCION, $IMAGEN,$encry2);
                            return $en;
                        } else {
                            continue;
                        }
                    }
                } else {
                    $_inci = array(
                        "ERROR_TYPE" => "API SOL 2",
                        "ERROR_CODE" => "API ERROR SELECT",
                        "ERROR_TEXT" => $ID_UNICO_TRANSACCION,
                    );
                    $INC = $this->INCIDENCIAS($_inci);
                    return [0, "INTENTE DE NUEVO"];
                }
                return [0, "INTENTE DE NUEVO"];
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO"];
        }
    }

    function GUARDAR_DATOS_API_REGISTRO($param, $ID_UNICO)
    {
        try {
            // echo json_encode($param);
            // exit();
            $CANT_DOM = trim($param["LUGAR_DOM"]);
            $CEDULA = trim($param["IDENTIFICACION"]);
            $ESTADO_CIVIL = trim($param["DES_ESTADO_CIVIL"]);
            $FECHA_NACIM = trim($param["FECH_NAC"]);
            $INDIVIDUAL_DACTILAR = trim($param["INDIVIDUAL_DACTILAR"]);
            $NOMBRES = trim($param["NOMBRE"]);
            $query = $this->db->connect_dobra()->prepare('UPDATE creditos_solicitados
            SET 
                nombre_cliente = :nombre_cliente,
                fecha_nacimiento = :fecha_nacimiento,
                codigo_dactilar = :codigo_dactilar,
                estado_civil = :estado_civil,
                localidad = :localidad,
                EST_REGISTRO = 1
            where ID_UNICO = :ID_UNICO
            ');
            $query->bindParam(":nombre_cliente", $NOMBRES, PDO::PARAM_STR);
            $query->bindParam(":fecha_nacimiento", $FECHA_NACIM, PDO::PARAM_STR);
            $query->bindParam(":codigo_dactilar", $INDIVIDUAL_DACTILAR, PDO::PARAM_STR);
            $query->bindParam(":estado_civil", $ESTADO_CIVIL, PDO::PARAM_STR);
            $query->bindParam(":localidad", $CANT_DOM, PDO::PARAM_STR);
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return [1, "Datos Api reg guardados"];
            } else {
                $err = $query->errorInfo();
                return [0, "Error al guardar datos api GUARDAR_DATOS_API_REGISTRO", $err];
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "Error al guardar datos api", $e];
        }
    }

    //******************************************** */
    //** DATOS API CREDITO */

    function DATOS_API_CREDITO($ID_UNICO_TRANSACCION)
    {
        try {
            set_time_limit(180);
            $start_time = microtime(true);

            // sleep(4);
            $ID_UNICO = trim($ID_UNICO_TRANSACCION);
            $arr = "";
            while (true) {
                $current_time = microtime(true);
                $elapsed_time = $current_time - $start_time;
                // Verificar si el tiempo transcurrido excede el límite de tiempo máximo permitido (por ejemplo, 120 segundos)
                if (round($elapsed_time, 0) >= 180) {
                    return [2, "La consulta excedió el tiempo máximo permitido"];
                }
                // echo json_encode("Tiempo transcurrido: " . $elapsed_time . " segundos\n");

                $query = $this->db->connect_dobra()->prepare("SELECT *
                FROM creditos_solicitados
                WHERE ID_UNICO = :ID_UNICO
                and estado = 1");
                $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
                if ($query->execute()) {
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) > 0) {
                        $encry = trim($result[0]["EST_REGISTRO"]);
                        if ($encry == 0) {
                            return [1, $result];
                        } else {
                            continue;
                        }
                    }
                } else {
                    return [0, "INTENTE DE NUEVO"];
                }
                return [0, "INTENTE DE NUEVO"];
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO"];
        }
    }

    function MOSTRAR_RESULTADO($DATOS, $ID_UNICO, $TIPO_CONSULTA)
    {
        $link = constant("URL") . "/public/img/SV24 - Mensajes LC_Proceso.png";
        $ESTADO_CREDITO = $DATOS["API_SOL_ESTADO"];
        $ESTADO_CREDITO_MONTO = $DATOS["credito_aprobado"];
        $MONTO = $DATOS["API_SOL_montoMaximo"];
        $PLAZO = $DATOS["API_SOL_plazoMaximo"];
        $API_SOL_descripcion = $DATOS["API_SOL_descripcion"];
        $CELULAR = $DATOS["numero"];

        $this->GUARDAR_CANTIDAD_DE_CONSULTAS($CELULAR);

        if ($ESTADO_CREDITO == 1) {

            if ($ESTADO_CREDITO_MONTO == 1) {
                $html = '
                <div class="text-center mt-3">
                    <h1 style="font-size:60px" class="text-primary">Felicidades! </h1>
                    <h2>Tienes credito disponible</h2>
                    <img style="width: 100%;" src="' . $link . '" alt="">
                    <button onclick="window.location.reload()" class="btn btn-success">Realizar nueva consulta</button>
                </div>';
            } else {
                $html = '  
                <div class="text-center">
                    <h1 class="text-danger">Lamentablemente el perfil con la cédula entregada no aplica para el crédito, no cumple con las políticas del banco.</h1>
                    <h3><i class="bi bi-tv fs-1"></i> Mire el siguiente video ➡️ </h3>
                    <a class="fs-3" href="https://youtu.be/EMaHXoCefic">https://youtu.be/EMaHXoCefic ��</a>
                    <h3 class="mt-3">Le invitamos a llenar la siguiente encuesta ➡️ </h3>
                    <a class="fs-3" href="https://forms.gle/s3GwuwoViF4Z2Jpt6">https://forms.gle/s3GwuwoViF4Z2Jpt6</a>
                    <h3></h3>
                    <button onclick="window.location.reload()" class="btn btn-success">Realizar nueva consulta</button>
                </div>';
            }
            echo json_encode([$TIPO_CONSULTA, [], $DATOS, $html]);
            exit();
        } else if ($ESTADO_CREDITO == 2) {
            // $this->ELIMINAR_LINEA_ERROR($ID_UNICO);
            echo json_encode([0, "No se pudo realizar la verificacion", "Este número de cédula ha excedido la cantidad de consultas diarias, intentelo luego"]);
            exit();
        } else if ($ESTADO_CREDITO == 3 || $ESTADO_CREDITO == null) {
            $html = '
            <div class="text-center mt-3">
                <h2 class="text-danger">Por el momento no podemos realizar tu consulta</h2>
                <h3>El horario de consultas es de 8:00 a 21:00</h3>
                <h3>Regresa aquí en ese horario, tu consulta sera realizada automaticamente</h3>
                <img style="width: 100%;" src="' . $link . '" alt="">
                <button onclick="windows.location.reload()" class="btn btn-success">Realizar nueva consulta</button>
            </div>';
            // $this->ELIMINAR_LINEA_ERROR($ID_UNICO);
            echo json_encode([$TIPO_CONSULTA, [], $DATOS, $html]);
            exit();
        } else {
            echo json_encode([0, "No se pudo realizar la verificacion", "Por favor intentelo en un momento", $API_SOL_descripcion]);
            exit();
        }
    }



    function GUARDAR_CANTIDAD_DE_CONSULTAS($celular)
    {
        try {
            // sleep(4);
            // $cedula = trim($param["cedula"]);
            $query = $this->db->connect_dobra()->prepare("INSERT INTO cantidad_consultas
            (
                numero,
                cantidad
            )VALUES
            (
                :numero,
                1
            )");
            $query->bindParam(":numero", $celular, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO"];
        }
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

    function Obtener_Datos_Credito($cedula, $fecha, $celular, $ID_UNICO)
    {
        try {

            $fecha_formateada = $fecha;
            $ingresos = "500";
            $Instruccion = "SECU";
            $CELULAR = $celular;


            $SEC = $this->Get_Secuencial_Api_Banco();
            $SEC = intval($SEC[0]["valor"]) + 1;
            $this->Update_Secuencial_Api_Banco($SEC);

            $cedula_ECrip = $this->encryptCedula($cedula);
            if ($cedula_ECrip[0] == 0) {
                return [0, $cedula_ECrip, [], []];
            } else {
                $cedula_ECrip = $cedula_ECrip[1];
            }

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



            // if (extension_loaded('curl')) {
            //     echo "cURL está habilitado en este servidor.";
            // } else {
            //     echo "cURL no está habilitado en este servidor.";
            // }

            // Verificar si hay un error en la respuesta
            if ($response_array == "NULL") {
                return [3, $response_array, $error];
            } else {
                if (isset($response_array['esError'])) {
                    $GUARDAR = $this->Guardar_Datos_Banco($response_array, $ID_UNICO);
                    return $GUARDAR;
                } else {
                    // $INC = $this->INCIDENCIAS($_inci);
                    return [2, $response_array, $error, $data, $verboseLog, extension_loaded('curl')];
                }
            }
        } catch (Exception $e) {
            // Captura la excepción y maneja el error
            // echo "Error: " . $e->getMessage();
            $param = array(
                "ERROR_TYPE" => "API_SOL_FUNCTION",
                "ERROR_CODE" => "",
                "ERROR_TEXT" => $e->getMessage(),
            );
            return [0, "Error al procesar la solictud banco", $e->getMessage()];
        }
    }

    function Get_Secuencial_Api_Banco()
    {
        try {
            // sleep(4);
            // $cedula = trim($param["cedula"]);
            $arr = "";
            $query = $this->db->connect_dobra()->prepare("SELECT * FROM parametros where id = 1");
            // $query->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO"];
        }
    }

    function Update_Secuencial_Api_Banco($SEC)
    {

        try {
            // sleep(4);
            // $cedula = trim($param["cedula"]);
            $arr = "";
            $query = $this->db->connect_dobra()->prepare("UPDATE parametros 
                SET valor = :valor
            where id = 1");
            $query->bindParam(":valor", $SEC, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return [0, "INTENTE DE NUEVO"];
        }
    }

    function Guardar_Datos_Banco($VAL_CREDITO, $ID_UNICO)
    {

        try {
            date_default_timezone_set('America/Guayaquil');

            $DATOS_CREDITO = $VAL_CREDITO;
            // echo json_encode($DATOS_CREDITO);
            // exit();

            $API_SOL_codigo = $DATOS_CREDITO["codigo"];
            $API_SOL_descripcion = $DATOS_CREDITO["descripcion"];
            $API_SOL_esError = $DATOS_CREDITO["esError"];
            $API_SOL_idSesion = $DATOS_CREDITO["idSesion"];
            $API_SOL_secuencial = $DATOS_CREDITO["secuencial"];
            $API_SOL_ESTADO =  0; // ERROR DESCONOCIDO

            if (isset($DATOS_CREDITO["mensaje"])) {
                $API_SOL_campania = $DATOS_CREDITO["mensaje"]["campania"];
                $API_SOL_identificacion = $DATOS_CREDITO["mensaje"]["identificacion"];
                $API_SOL_lote = $DATOS_CREDITO["mensaje"]["lote"];
                $API_SOL_montoMaximo = $DATOS_CREDITO["mensaje"]["montoMaximo"];
                $API_SOL_nombreCampania = $DATOS_CREDITO["mensaje"]["nombreCampania"];
                $API_SOL_plazoMaximo = $DATOS_CREDITO["mensaje"]["plazoMaximo"];
                $API_SOL_promocion = $DATOS_CREDITO["mensaje"]["promocion"];
                $API_SOL_segmentoRiesgo = $DATOS_CREDITO["mensaje"]["segmentoRiesgo"];
                $API_SOL_subLote = $DATOS_CREDITO["mensaje"]["subLote"];
                $credito_aprobado = floatval($DATOS_CREDITO["mensaje"]["montoMaximo"]) > 0 ? 1 : 0;
                $credito_aprobado_texto = floatval($DATOS_CREDITO["mensaje"]["montoMaximo"]) > 0 ? "APROBADO" : "RECHAZADO";
                $API_SOL_ESTADO =  1;

                $sql = "UPDATE creditos_solicitados
                SET
    
                    API_SOL_codigo = :API_SOL_codigo,
                    API_SOL_descripcion =:API_SOL_descripcion,
                    API_SOL_eserror = :API_SOL_eserror,
                    API_SOL_idSesion =:API_SOL_idSesion,
                    API_SOL_secuencial = :API_SOL_secuencial,
    
    
                    API_SOL_campania =:API_SOL_campania,
                    API_SOL_identificacion =:API_SOL_identificacion,
                    API_SOL_lote =:API_SOL_lote,
                    API_SOL_montoMaximo =:API_SOL_montoMaximo,
                    API_SOL_nombreCampania =:API_SOL_nombreCampania,
                    API_SOL_plazoMaximo =:API_SOL_plazoMaximo,
                    API_SOL_promocion =:API_SOL_promocion,
                    API_SOL_segmentoRiesgo =:API_SOL_segmentoRiesgo,
                    API_SOL_subLote =:API_SOL_subLote,
                    credito_aprobado = :credito_aprobado,
                    credito_aprobado_texto = :credito_aprobado_texto,
    
                    API_SOL_ESTADO = :API_SOL_ESTADO,
    
                    EST_REGISTRO = 0
                WHERE ID_UNICO = :ID_UNICO";
            } else {
                $hora_actual = date('G');

                if ($DATOS_CREDITO['descripcion'] == "No tiene oferta") {
                    $API_SOL_ESTADO =  2;
                }
                // if ($DATOS_CREDITO['descripcion'] == "Ha ocurrido un error" && $hora_actual >= 21) {
                //     $API_SOL_ESTADO =  3;
                // }
                if ($hora_actual >= 21) {
                    $API_SOL_ESTADO =  3;
                }

                $sql = "UPDATE creditos_solicitados
                SET
                    API_SOL_codigo = :API_SOL_codigo,
                    API_SOL_descripcion =:API_SOL_descripcion,
                    API_SOL_eserror = :API_SOL_eserror,
                    API_SOL_idSesion =:API_SOL_idSesion,
                    API_SOL_secuencial = :API_SOL_secuencial,
                    API_SOL_ESTADO = :API_SOL_ESTADO,
    
                    EST_REGISTRO = 0
                WHERE ID_UNICO = :ID_UNICO";
            }
            $query = $this->db->connect_dobra()->prepare($sql);
            $query->bindParam(":API_SOL_codigo", $API_SOL_codigo, PDO::PARAM_STR);
            $query->bindParam(":API_SOL_descripcion", $API_SOL_descripcion, PDO::PARAM_STR);
            $query->bindParam(":API_SOL_eserror", $API_SOL_esError, PDO::PARAM_STR);
            $query->bindParam(":API_SOL_idSesion", $API_SOL_idSesion, PDO::PARAM_STR);
            $query->bindParam(":API_SOL_secuencial", $API_SOL_secuencial, PDO::PARAM_STR);

            $query->bindParam(":API_SOL_ESTADO", $API_SOL_ESTADO, PDO::PARAM_STR);

            if ($API_SOL_esError == false) {
                $query->bindParam(":API_SOL_campania", $API_SOL_campania, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_identificacion", $API_SOL_identificacion, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_lote", $API_SOL_lote, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_montoMaximo", $API_SOL_montoMaximo, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_nombreCampania", $API_SOL_nombreCampania, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_plazoMaximo", $API_SOL_plazoMaximo, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_promocion", $API_SOL_promocion, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_segmentoRiesgo", $API_SOL_segmentoRiesgo, PDO::PARAM_STR);
                $query->bindParam(":API_SOL_subLote", $API_SOL_subLote, PDO::PARAM_STR);
                $query->bindParam(":credito_aprobado", $credito_aprobado, PDO::PARAM_STR);
                $query->bindParam(":credito_aprobado_texto", $credito_aprobado_texto, PDO::PARAM_STR);
            }
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);

            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if ($API_SOL_ESTADO == 1) {
                    $d = $this->Get_Email($ID_UNICO);
                    if ($d != 0 && $API_SOL_ESTADO == 1) {
                        $this->ENVIAR_CORREO_CREDITO($credito_aprobado, $d);
                    }
                }
                return ([1, "DATOS_API_GUARDARDOS", $ID_UNICO]);
            } else {
                $err = $query->errorInfo();
                return ([0, "ERROR AL GUARDAR", $ID_UNICO, $err]);
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode([0, "ERROR AL GUARDAR", $e]);
            exit();
        }
    }

    function ENVIAR_CORREO_CREDITO($credito_aprobado, $datos)
    {

        try {

            $email = $datos[0]["correo"];
            $numero_salv = "093 989 7277";
            $nombre_cliente = $datos[0]["nombre_cliente"];
            $img = "C:\xampp\htdocs\credito_express_api\SV24-LogosLC_Credito.png";

            if ($credito_aprobado == 1) {
                $html = "  
            <h1 style='text-align: center; color: #007bff;'>Felicidades!</h1>
            <p style='text-align: justify;'>Estimado/a " . $nombre_cliente . ",</p>
            <p style='text-align: justify;'>Nos complace informarte que tienes un <strong>crédito disponible</strong> con Salvacero.</p>
            <p style='text-align: justify;'>Nuestro equipo está comprometido en brindarte el mejor servicio y apoyo en todo momento. Estamos listos para guiarte a través del proceso y responder a todas tus preguntas para que puedas acceder a los fondos que necesitas de manera rápida y sencilla.</p>
            <p style='text-align: justify;'>Para obtener más información sobre tu crédito disponible y cómo puedes acceder a él, no dudes en ponerte en contacto con nosotros llamando al siguiente número: " . $numero_salv . ". Alternativamente, nuestro equipo se pondrá en contacto contigo para brindarte más detalles y asistencia.</p>
            <p style='text-align: justify;'>¡Gracias por utilizar este servicio!</p>
            <p style='text-align: justify;'>Saludos cordiales,<br>Equipo de Salvacero</p>";
            } else {
                $html = " 
            <h1 style='text-align: center; color: #e74c3c;'>¡Lo sentimos!</h1>
            <p style='text-align: justify;'>Estimado/a " . $nombre_cliente . ",</p>
            <p style='text-align: justify;'>Lamentablemente, en este momento no tienes un crédito disponible con Salvacero.</p>
            <p style='text-align: justify;'>No te desanimes, estamos aquí para ayudarte en todo lo que podamos. Si tienes alguna pregunta o necesitas asistencia adicional, no dudes en ponerte en contacto con nosotros. Nuestro equipo estará encantado de ayudarte en lo que necesites.</p>
            <p style='text-align: justify;'>Te agradecemos por confiar en Salvacero y esperamos poder brindarte nuestro apoyo en el futuro.</p>
            <p style='text-align: justify;'>Saludos cordiales,<br>Equipo de Salvacero</p>";
            }

            $msg = "
            <!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Correo Electrónico de Ejemplo</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-image: url('SV24-LogosLC_Credito.png');
                        background-repeat: no-repeat;
                        background-size: cover;
                        padding: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #fff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    h1 {
                        text-align: center;
                        color: #007bff;
                    }
                    p {
                        text-align: justify;
                    }
                </style>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #2471A3; color: #333; padding: 20px;'>

            <div style='max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);'>
                <img src='https://salvacerohomecenter.com/img/cms/SV23%20-%20Logo%20Web_3.png' alt='Logo Salvacero' style='display: block; margin: 0 auto; max-width: 200px;'>
                    " . $html . "
            </div>

            </body>
            </html>
            ";

            $m = new PHPMailer(true);
            $m->CharSet = 'UTF-8';
            $m->isSMTP();
            $m->SMTPAuth = true;
            $m->Host = 'mail.creditoexpres.com';
            $m->Username = 'info@creditoexpres.com';
            // $m->Password = 'izfq lqiv kbrc etsx';
            $m->Password = 'S@lvacero2024*';
            $m->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $m->Port = 465;
            $m->setFrom('info@creditoexpres.com', 'Credito Salvacero');
            // $m->addAddress('jalvaradoe3@gmail.com');
            $m->addAddress($email);
            $m->isHTML(true);
            $titulo = strtoupper('Estado del credito solicitado');
            $m->Subject = $titulo;
            $m->Body = $msg;
            //$m->addAttachment($atta);
            // $m->send();
            if ($m->send()) {
                // echo "<pre>";
                // $mensaje = ("Correo enviado ");
                // echo "</pre>";
                // echo $mensaje;
                return 1;
            } else {
                // echo "Ha ocurrido un error al enviar el correo electrónico.";
                return 0;
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            return $e;
        }
    }

    function Get_Email($ID_UNICO)
    {

        try {
            $query = $this->db->connect_dobra()->prepare("SELECT ifnull(correo,'')as correo, nombre_cliente FROM creditos_solicitados
        WHERE ID_UNICO = :ID_UNICO");
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                if (count($result) > 0) {
                    $co = $result[0]["correo"];
                    if ($co == "") {
                        return 0;
                    } else {
                        return $result;
                    }
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            return 0;
        }
    }


    //********************* */
    //***** INCIDENCIAS *****/
    //********************* */

    function INCIDENCIAS($param)
    {
        try {
            $ERROR_TYPE = ($param["ERROR_TYPE"]);
            $ERROR_CODE = json_encode($param["ERROR_CODE"]);
            $ERROR_TEXT = json_encode($param["ERROR_TEXT"]);

            $query = $this->db->connect_dobra()->prepare('INSERT INTO incidencias 
            (
                ERROR_TYPE, 
                ERROR_CODE, 
                ERROR_TEXT
            ) 
            VALUES
            (
                :ERROR_TYPE, 
                :ERROR_CODE, 
                :ERROR_TEXT
            )
            ');
            $query->bindParam(":ERROR_TYPE", $ERROR_TYPE, PDO::PARAM_STR);
            $query->bindParam(":ERROR_CODE", $ERROR_CODE, PDO::PARAM_STR);
            $query->bindParam(":ERROR_TEXT", $ERROR_TEXT, PDO::PARAM_STR);

            if ($query->execute()) {
                // $result = $query->fetchAll(PDO::FETCH_ASSOC);
                $CORREO = $this->Enviar_correo_incidencias($param);
                return [1];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function Enviar_correo_incidencias($DATOS_INCIDENCIA)
    {

        try {
            $msg = "<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;'>";
            $msg .= "<h1 style='text-align:center; color: #24448c;'>ERROR CREDITO EXPRESS INCIDENCIA</h1><br><br>";
            $msg .= "<p>Fecha y hora de envío: " . date('d/m/Y H:i:s') . "</p>";
            $msg .= "<p>ERROR_TYPE: " . $DATOS_INCIDENCIA["ERROR_TYPE"] . "</p>";
            $msg .= "<p>ERROR_CODE: " . $DATOS_INCIDENCIA["ERROR_CODE"] . "</p>";
            $msg .= "<p>ERROR_TEXT: " . $DATOS_INCIDENCIA["ERROR_TEXT"] . "</p>";
            $msg .= "<div style='text-align:center;'>";
            $msg .= "</div>";

            $m = new PHPMailer(true);
            $m->CharSet = 'UTF-8';
            $m->isSMTP();
            $m->SMTPAuth = true;
            $m->Host = 'mail.creditoexpres.com';
            $m->Username = 'info@creditoexpres.com';
            // $m->Password = 'izfq lqiv kbrc etsx';
            $m->Password = 'S@lvacero2024*';
            $m->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $m->Port = 465;
            $m->setFrom('info@creditoexpres.com', 'INCIDENCIAS');
            $m->addAddress('jalvaradoe3@gmail.com');
            // $m->addAddress($email);
            $m->isHTML(true);
            $titulo = strtoupper('INCIDENCIAS');
            $m->Subject = $titulo;
            $m->Body = $msg;

            if ($m->send()) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            $e = $e->getMessage();
            return $e;
        }
    }

    function ELIMINAR_LINEA_ERROR($ID_UNICO)
    {
        try {
            $query = $this->db->connect_dobra()->prepare('DELETE FROM Datos_Reconocimiento
            where ID_UNICO = :ID_UNICO
            ');
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                // return 1;
            } else {
                //return 0;
            }

            $query = $this->db->connect_dobra()->prepare('DELETE FROM Datos_Empleo
            where ID_UNICO = :ID_UNICO
            ');
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                // return 1;
            } else {
                //return 0;
            }


            $query = $this->db->connect_dobra()->prepare('DELETE FROM creditos_solicitados
            where ID_UNICO = :ID_UNICO
            ');
            $query->bindParam(":ID_UNICO", $ID_UNICO, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function Generar_Documento($RUTA_ARCHIVO, $nombre, $cedula)
    {

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Título
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, utf8_decode('AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES'), 0, 1, 'C');
        $pdf->Cell(0, 2, utf8_decode('SALVACERO CIA. LTDA.'), 0, 1, 'C');
        $pdf->Ln(3);

        // Contenido
        $pdf->SetFont('Arial', '', 9);
        $contenido = utf8_decode("
        Declaración de Capacidad legal y sobre la Aceptación:\n
        Por medio de la presente autorizo de manera libre, voluntaria, previa, informada e inequívoca a SALVACERO CIA. LTDA.
        para que en los términos legalmente establecidos realice el tratamiento de mis datos personales como parte de la relación
        precontractual, contractual y post contractual para:\n
        El procesamiento, análisis, investigación, estadísticas, referencias y demás trámites para facilitar, promover, permitir o
        mantener las relaciones con SALVACERO CIA. LTDA.\n
        Cuantas veces sean necesarias, gestione, obtenga y valide de cualquier entidad pública y/o privada que se encuentre
        facultada en el país, de forma expresa a la Dirección General de Registro Civil, Identificación y Cedulación, a la Dirección
        Nacional de Registros Públicos, al Servicio de Referencias Crediticias, a los burós de información crediticia, instituciones
        financieras de crédito, de cobranza, compañías emisoras o administradoras de tarjetas de crédito, personas naturales y los
        establecimientos de comercio, personas señaladas como referencias, empleador o cualquier otra entidad y demás fuentes
        legales de información autorizadas para operar en el país, información y/o documentación relacionada con mi perfil, capacidad
        de pago y/o cumplimiento de obligaciones, para validar los datos que he proporcionado, y luego de mi aceptación sean
        registrados para el desarrollo legítimo de la relación jurídica o comercial, así como para realizar actividades de tratamiento
        sobre mi comportamiento crediticio, manejo y movimiento de cuentas bancarias, tarjetas de crédito, activos, pasivos,
        datos/referencias personales y/o patrimoniales del pasado, del presente y las que se generen en el futuro, sea como deudor
        principal, codeudor o garante, y en general, sobre el cumplimiento de mis obligaciones. Faculto expresamente a SALVACERO
        CIA. LTDA. para transferir o entregar a las mismas personas o entidades, la información relacionada con mi comportamiento
        crediticio.\n
        Tratar, transferir y/o entregar la información que se obtenga en virtud de esta solicitud incluida la relacionada con mi
        comportamiento crediticio y la que se genere durante la relación jurídica y/o comercial a autoridades competentes, terceros,
        socios comerciales y/o adquirientes de cartera, para el tratamiento de mis datos personales conforme los fines detallados en
        esta autorización o que me contacten por cualquier medio para ofrecerme los distintos servicios y productos que integran su
        portafolio y su gestión, relacionados o no con los servicios financieros. En caso de que el SALVACERO CIA. LTDA. ceda o
        transfiera cartera adeudada por mí, el cesionario o adquiriente de dicha cartera queda desde ahora expresamente facultado
        para realizar las mismas actividades establecidas en esta autorización.\n
        Fines informativos, marketing, publicitarios y comerciales a través del servicio de telefonía, correo electrónico, mensajería
        SMS, WhatsApp, redes sociales y/o cualquier otro medio de comunicación electrónica.\n
        Entiendo y acepto que mi información personal podrá ser almacenada de manera digital, y accederán a ella los funcionarios
        de SALVACERO CIA. LTDA., estando obligados a cumplir con la legislación aplicable a las políticas de confidencialidad,
        protección de datos y sigilo bancario. En caso de que exista una negativa u oposición para el tratamiento de estos datos, no
        podré disfrutar de los servicios o funcionalidades que SALVACERO CIA. LTDA. ofrece y no podrá suministrarme productos,
        ni proveerme sus servicios o contactarme y en general cumplir con varias de las finalidades descritas en la Política.\n
        SALVACERO CIA. LTDA. conservará la información personal al menos durante el tiempo que dure la relación comercial y el
        que sea necesario para cumplir con la normativa respectiva del sector relativa a la conservación de archivos.\n
        Declaro conocer que para el desarrollo de los propósitos previstos en el presente documento y para fines precontractuales,
        contractuales y post contractuales es indispensable el tratamiento de mis datos personales conforme a la Política disponible
        en la página web de SALVACERO CIA. LTDA.\n
        Asimismo, declaro haber sido informado por el SALVACERO CIA. LTDA. de los derechos con que cuento para conocer,
        actualizar y rectificar mi información personal; así como, si no deseo continuar recibiendo información comercial y/o
        publicidad, deberé remitir mi requerimiento a través del proceso de atención de derechos ARSO+ en cualquier momento y
        sin costo alguno, utilizando la página web https://www.salvacero.com/terminos o comunicado escrito a Srs. Salvacero y
        enviando un correo electrónico a la dirección marketing@salvacero.com\n
        En virtud de que, para ciertos productos y servicios SALVACERO CIA. LTDA. requiere o solicita el tratamiento de datos
        personales de un tercero que como cliente podré facilitar, como por ejemplo referencias comerciales o de contacto, garantizo
        que, si proporciono datos personales de terceras personas, les he solicitado su aceptación e informado acerca de las
        finalidades y la forma en la que SALVACERO CIA. LTDA. necesita tratar sus datos personales.\n
        Para la comunicación de sus datos personales se tomarán las medidas de seguridad adecuadas conforme la normativa
        vigente. 
        ");
        $pdf->MultiCell(0, 4, $contenido);
        $pdf->Ln(3);

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, utf8_decode('AUTORIZACIÓN EXPLÍCITA DE TRATAMIENTO DE DATOS PERSONALES'), 0, 1, 'C');
        $pdf->Cell(0, 2, utf8_decode('SALVACERO CIA. LTDA.'), 0, 1, 'C');
        $pdf->Ln(3);

        $pdf->SetFont('Arial', '', 9);
        $contenido = utf8_decode("
        Declaro que soy el titular de la información reportada, y que la he suministrado de forma voluntaria, completa, confiable,
        veraz, exacta y verídica:\n
        Como titular de los datos personales, particularmente el código dactilar, no me encuentro obligado a otorgar mi autorización
        de tratamiento a menos que requiera consultar y/o aplicar a un producto y/o servicio financiero. A través de la siguiente
        autorización libre, especifica, previa, informada, inequívoca y explícita, faculto al tratamiento (recopilación, acceso, consulta,
        registro, almacenamiento, procesamiento, análisis, elaboración de perfiles, comunicación o transferencia y eliminación) de
        mis datos personales incluido el código dactilar con la finalidad de: consultar y/o aplicar a un producto y/o servicio financiero
        y ser sujeto de decisiones basadas única o parcialmente en valoraciones que sean producto de procesos automatizados,
        incluida la elaboración de perfiles. Esta información será conservada por el plazo estipulado en la normativa aplicable.\n
        Así mismo, declaro haber sido informado por SALVACERO CIA. LTDA. de los derechos con que cuento para conocer,
        actualizar y rectificar mi información personal, así como, los establecidos en el artículo 20 de la LOPDP y remitir mi
        requerimiento a través del proceso de atención de derechos ARSO+; en cualquier momento y sin costo alguno, utilizando la
        página web https://www.salvacero.com/terminos, comunicado escrito o en cualquiera de las agencias de SALVACERO CIA.
        LTDA.\n
        Para proteger esta información tenemos medidas técnicas y organizativas de seguridad adaptadas a los riesgos como, por
        ejemplo: anonimización, cifrado, enmascarado y seudonimización.\n
        Con la lectura de este documento manifiesto que he sido informado sobre el Tratamiento de mis Datos Personales, y otorgo
        mi autorización y aceptación de forma voluntaria y verídica, tanto para la SALVACERO CIA. LTDA. y para cualquier cesionario
        o endosatario, especialmente Banco Solidario S.A. En señal de aceptación suscribo el presente documento.
        ");

        $pdf->MultiCell(0, 4, $contenido);
        $pdf->Ln(3);
        date_default_timezone_set('America/Guayaquil');
        // Información del cliente
        $pdf->SetFont('Arial', 'I', 11);
        $nombreCliente = $nombre; // Aquí debes poner el nombre del cliente
        $fechaConsulta = date("Y-m-d h:i A"); // Fecha de la consulta
        $direccionIP = $this->getRealIP(); // Dirección IP del cliente


        // $fecha = DateTime::createFromFormat('YmdHis', $fechaConsulta);
        // $fechaFormateada = $fecha->format('Y-m-d H:i A');
        // Información del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, '      CLIENTE: ', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "      " . utf8_decode($nombreCliente) . " - " . $cedula, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, "      " . utf8_decode('ACEPTÓ TERMINOS Y CONDICIONES: '), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "      " . $fechaConsulta, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('      DIRECCIÓN IP: '), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6,  "      " . $direccionIP, 0, 1, 'L');


        $nombreArchivo = $RUTA_ARCHIVO; // Nombre del archivo PDF
        $rutaCarpeta = dirname(__DIR__) . '/recursos/docs/'; // Ruta de la carpeta donde se guardará el archivo (debes cambiar esto)

        if (chmod($rutaCarpeta, 0777)) {
            // echo "Permisos cambiados exitosamente.";
        }

        $pdf->Output($rutaCarpeta . $nombreArchivo, 'F');
    }

    function Generar_pdf($param)
    {
        $nombre = $param["nombre_cliente"];
        $cedula = $param["cedula"];
        $fechaConsulta = $param["fecha_creado"];
        $ip = $param["ip"];

        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Título
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, utf8_decode('AUTORIZACIÓN PARA EL TRATAMIENTO DE DATOS PERSONALES'), 0, 1, 'C');
        $pdf->Cell(0, 2, utf8_decode('BANCO SOLIDARIO S.A.'), 0, 1, 'C');
        $pdf->Ln(3);

        // Contenido
        $pdf->SetFont('Arial', '', 9);
        $contenido = utf8_decode("
        Declaración de Capacidad legal y sobre la Aceptación:\n
        Por medio de la presente autorizo de manera libre, voluntaria, previa, informada e inequívoca a BANCO SOLIDARIO
        S.A. para que en los términos legalmente establecidos realice el tratamiento de mis datos personales como parte de
        la relación precontractual, contractual y post contractual para: \n
        El procesamiento, análisis, investigación, estadísticas, referencias y demás trámites para facilitar, promover, permitir
        o mantener las relaciones con el BANCO. \n
        Cuantas veces sean necesarias, gestione, obtenga y valide de cualquier entidad pública y/o privada que se encuentre
        facultada en el país, de forma expresa a la Dirección General de Registro Civil, Identificación y Cedulación, a la Dirección
        Nacional de Registros Públicos, al Servicio de Referencias Crediticias, a los burós de información crediticia, instituciones
        financieras de crédito, de cobranza, compañías emisoras o administradoras de tarjetas de crédito, personas naturales
        y los establecimientos de comercio, personas señaladas como referencias, empleador o cualquier otra entidad y demás
        fuentes legales de información autorizadas para operar en el país, información y/o documentación relacionada con mi
        perfil, capacidad de pago y/o cumplimiento de obligaciones, para validar los datos que he proporcionado, y luego de
        mi aceptación sean registrados para el desarrollo legítimo de la relación jurídica o comercial, así como para realizar
        actividades de tratamiento sobre mi comportamiento crediticio, manejo y movimiento de cuentas bancarias, tarjetas
        de crédito, activos, pasivos, datos/referencias personales y/o patrimoniales del pasado, del presente y las que se
        generen en el futuro, sea como deudor principal, codeudor o garante, y en general, sobre el cumplimiento de mis
        obligaciones. Faculto expresamente al Banco para transferir o entregar a las mismas personas o entidades, la
        información relacionada con mi comportamiento crediticio. Esta expresa autorización la otorgo al Banco o a cualquier
        cesionario o endosatario. \n
        Tratar, transferir y/o entregar la información que se obtenga en virtud de esta solicitud incluida la relacionada con mi
        comportamiento crediticio y la que se genere durante la relación jurídica o comercial a autoridades competentes,
        terceros, socios comerciales y/o adquirientes de cartera, para el tratamiento de mis datos personales conforme los
        fines detallados en esta autorización o que me contacten por cualquier medio para ofrecerme los distintos servicios y
        productos que integran su portafolio y su gestión, relacionados o no con los servicios financieros del BANCO. En caso
        de que el BANCO ceda o transfiera cartera adeudada por mí, el cesionario o adquiriente de dicha cartera queda desde
        ahora expresamente facultado para realizar las mismas actividades establecidas en esta autorización.\n
        Entiendo y acepto que mi información personal podrá ser almacenada de manera impresa o digital, y accederán a ella
        los funcionarios de BANCO SOLIDARIO, estando obligados a cumplir con la legislación aplicable a las políticas de
        confidencialidad, protección de datos y sigilo bancario. En caso de que exista una negativa u oposición para el
        tratamiento de estos datos, no podré disfrutar de los servicios o funcionalidades que el BANCO ofrece y no podrá
        suministrarme productos, ni proveerme sus servicios o contactarme y en general cumplir con varias de las finalidades
        descritas en la Política. \n
        El BANCO conservará la información personal al menos durante el tiempo que dure la relación comercial y el que sea
        necesario para cumplir con la normativa respectiva del sector relativa a la conservación de archivos. \n
        Declaro conocer que para el desarrollo de los propósitos previstos en el presente documento y para fines
        precontractuales, contractuales y post contractuales es indispensable el tratamiento de mis datos personales
        conforme a la Política disponible en la página web del BANCO www.banco-solidario.com/transparencia Asimismo,
        declaro haber sido informado por el BANCO de los derechos con que cuento para conocer, actualizar y rectificar mi
        información personal; así como, si no deseo continuar recibiendo información comercial y/o publicidad, deberé remitir
        mi requerimiento a través del proceso de atención de derechos ARSO+ en cualquier momento y sin costo alguno,
        utilizando la página web (www.banco-solidario.com), teléfono: 1700 765 432, comunicado escrito o en cualquiera de
        las agencias del BANCO. \n
        En virtud de que, para ciertos productos y servicios el BANCO requiere o solicita el tratamiento de datos personales
        de un tercero que como cliente podré facilitar, como por ejemplo referencias comerciales o de contacto, garantizo
        que, si proporciono datos personales de terceras personas, les he solicitado su aceptación e informado acerca de las
        finalidades y la forma en la que el BANCO necesita tratar sus datos personales. \n
        Para la comunicación de sus datos personales se tomarán las medidas de seguridad adecuadas conforme la normativa
        vigente.\n
       
        ");
        $pdf->MultiCell(0, 4, $contenido);
        $pdf->Ln(3);

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, utf8_decode('AUTORIZACIÓN EXPLÍCITA DE TRATAMIENTO DE DATOS PERSONALES'), 0, 1, 'C');
        $pdf->Cell(0, 2, utf8_decode('BANCO SOLIDARIO S.A.'), 0, 1, 'C');
        $pdf->Ln(3);

        $pdf->SetFont('Arial', '', 9);
        $contenido = utf8_decode("
        Declaro que soy el titular de la información reportada, y que la he suministrado de forma voluntaria, completa,
        confiable, veraz, exacta y verídica:\n
        Como titular de los datos personales, particularmente el código dactilar, dato biométrico facial, no me encuentro
        obligado a otorgar mi autorización de tratamiento a menos que requiera consultar y/o aplicar a un producto y/o
        servicio financiero. A través de la siguiente autorización libre, especifica, previa, informada, inequívoca y explícita,
        faculto al tratamiento (recopilación, acceso, consulta, registro, almacenamiento, procesamiento, análisis, elaboración
        de perfiles, comunicación o transferencia y eliminación) de mis datos personales incluido el código dactilar con la
        finalidad de: consultar y/o aplicar a un producto y/o servicio financiero y ser sujeto de decisiones basadas única o
        parcialmente en valoraciones que sean producto de procesos automatizados, incluida la elaboración de perfiles. Esta
        información será conservada por el plazo estipulado en la normativa aplicable. \n
        Así mismo, declaro haber sido informado por el BANCO de los derechos con que cuento para conocer, actualizar y
        rectificar mi información personal, así como, los establecidos en el artículo 20 de la LOPDP y remitir mi requerimiento
        a través del proceso de atención de derechos ARSO+; en cualquier momento y sin costo alguno, utilizando la página
        web (www.banco-solidario.com), teléfono: 1700 765 432, comunicado escrito o en cualquiera de las agencias del
        BANCO. \n
        Para proteger esta información conozco que el Banco cuenta con medidas técnicas y organizativas de seguridad
        adaptadas a los riesgos como, por ejemplo: anonimización, cifrado, enmascarado y seudonimización. \n
        Con la lectura de este documento manifiesto que he sido informado sobre el Tratamiento de mis Datos Personales, y
        otorgo mi autorización y aceptación de forma voluntaria y verídica. En señal de aceptación suscribo el presente
        documento. 
        ");

        $pdf->MultiCell(0, 4, $contenido);
        $pdf->Ln(3);

        date_default_timezone_set('America/Guayaquil');

        $fecha = DateTime::createFromFormat('YmdHis', $fechaConsulta);
        $fechaFormateada = $fecha->format('Y-m-d H:i A');
        // Información del cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, '      CLIENTE: ', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "      " . utf8_decode($nombre) . " - " . $cedula, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, "      " . utf8_decode('ACEPTÓ TERMINOS Y CONDICIONES: '), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, "      " . $fechaFormateada, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 5, utf8_decode('      DIRECCIÓN IP: '), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6,  "      " . $ip, 0, 1, 'L');


        $nombreArchivo = $cedula . "_" . $fechaConsulta . ".pdf"; // Nombre del archivo PDF
        $rutaCarpeta = dirname(__DIR__) . '/recursos/docs/'; // Ruta de la carpeta donde se guardará el archivo (debes cambiar esto)

        if (chmod($rutaCarpeta, 0777)) {
            // echo "Permisos cambiados exitosamente.";
        }

        $pdf->Output($rutaCarpeta . $nombreArchivo, 'F');

        try {
            $cedula = trim($param["cedula"]);
            $query = $this->db->connect_dobra()->prepare('UPDATE creditos_solicitados
            set ruta_archivo = :ruta_archivo
            where cedula = :cedula
            ');
            $query->bindParam(":ruta_archivo", $nombreArchivo, PDO::PARAM_STR);
            $query->bindParam(":cedula", $cedula, PDO::PARAM_STR);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(1);
                exit();
                // return 1;
            } else {
                // return 0;
            }
        } catch (PDOException $e) {
            $e = $e->getMessage();
            echo json_encode($e);
            exit();
        }
    }

    function getRealIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];

        return $_SERVER['REMOTE_ADDR'];
    }
}
