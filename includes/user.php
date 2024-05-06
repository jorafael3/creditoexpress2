<?php
require_once 'libs/database.php';

//include_once 'models/usuario.php';
class User extends Model
{

    public $nombre;
    public $username;


    function uss($user, $contra)
    {
        $userVendedor = "empleado@computron.com";
        $userVendedorpass = "empleado123";
        $userVendedoracc = 7;

        $userAdmin = "admin@computron.com";
        $userAdminpass = "admin123";
        $userAdminacc = 2;

        $userMaster = "master@computron.com";
        $userMasterpass = "master123";
        $userMasteracc = 1;

        if (($user == $userVendedor && $userVendedorpass == $contra)) {
            $_SESSION['CompuRankSession'] = 1;
            $_SESSION['userAcces'] = $userVendedoracc;
            $_SESSION['userName'] = "Vendedor";
            return "ok";
        } else if (($user == $userAdmin && $userAdminpass == $contra)) {
            $_SESSION['CompuRankSession'] = 1;
            $_SESSION['userAcces'] = $userAdminacc;
            $_SESSION['userName'] = "Admin";
            return "ok";
        } else if (($user == $userMaster && $userMasterpass == $contra)) {
            $_SESSION['CompuRankSession'] = 1;
            $_SESSION['userAcces'] = $userMasteracc;
            $_SESSION['userName'] = "Master";
            return "ok";
        } else {
            return "err";
        }
    }

    function userExist($user, $pass)
    {

        //$items = [];
        $correo = $user;


        try {
            $usu = "";
            $tipo = "";
            $Nivel = "";
            $query = $this->db->connect()->prepare("select * from inv_users");
            $query->execute();
            $result = $query->fetchAll();
            if ($query->rowCount()) {
                try {
                    foreach ($result as $row) {
                        $usu   = $row['Usuario'];
                        $tipo = $row['Tipo'];
                        $nivel = $row['Nivel'];
                        $ID = $row['usuarioID'];
                    }
                    // echo ($usu);
                    //echo ($estado);
                    if ($usu == "ERROR" or $usu == null or $nivel == "ERROR") {
                        return  false;
                    } else {
                        $_SESSION['iniciosesion'] = true;
                        $_SESSION['Usuario'] = $usu;
                        $_SESSION['Email'] = $user;
                        $_SESSION['Tipo'] = $tipo;
                        $_SESSION['usuarioID'] = $ID;
                        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];


                        return true;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else {
                echo "error";
                return false;
                //exit();
            }
        } catch (PDOException $e) {
            // echo $e->getMessage();
        }
    }



    public function Intentos()
    {
        try {
            $usuarioId = "";
            $query = $this->db->connect()->prepare("{ CALL CSD_Login_user (?,?)}");
            $query->bindParam(1, $usuarioId, PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException $e) {
        }
    }



    function closeSession()
    {

        echo "adsdawdawd";
    }
}
