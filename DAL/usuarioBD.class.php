<?php

require_once 'DAL/db.class.php';

require_once 'DAL/conf.class.php';

require 'Business/usuario.class.php';


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarioBD
 *
 * @author David
 */
class usuarioBD {

    public function insertar(Usuario $u) {
        $db = Db::getInstance();
        $rpta = false;
        try {
            $db->query("BEGIN");
            $sql = "INSERT INTO users (usuario,pass,nivelAdmin,email,sexo,fechaNac,fechaReg,activo,ipReg,idFarmacia) " .
            " VALUES('" . $u->getUsuario() . "','" . $u->getPass() . "','" . $u->nivelAdmin->getIdAdmin() . "','" . $u->getEmail() . "'," .
                "'" . $u->getSexo() . "','" . $u->getFechaNac() . "','" . $u->getFechaReg() . "','" . $u->getActivo() . "','" . $u->getIpReg() . "'," .
                "'" . $u->Farmacia->getIdFarmacia() . "')";
$result = $db->query($sql);
if (!$result) {
                //Niega la insercion
    $db->query("ROLLBACK");
} else {
                //Realiza el commit
    $db->query("COMMIT");
    $rpta = true;
}
} catch (exception $e) {
    try {
        $db->query("ROLLBACK");
    } catch (exception $e1) {

    }
}
return $rpta;
}

//ready

public function modifyPass($u) {
    $db = db::getInstance();
    $rpta = false;
    try {
        $db->query("BEGIN");
        $sql = "UPDATE users SET pass='" . $u->getPass() . "'"
        . "  WHERE idUser='" . $u->getIdUser() . "'";
        $result = $db->query($sql);
        if (!$result) {
                //Niega la actualizacion
            $db->query("ROLLBACK");
        } else {
                //Realiza el commit
            $db->query("COMMIT");
            $rpta = true;
        }
    } catch (exception $e) {

    }
    return $rpta;
}

public function modificar(Usuario $u) {
    $db = db::getInstance();
    $rpta = false;
    try {
        $db->query("BEGIN");
        $sql = "UPDATE users SET usuario='" . $u->getUsuario() . "',nivelAdmin='" . $u->nivelAdmin->getIdAdmin() . "',email='" . $u->getEmail() . "',"
        . "sexo='" . $u->getSexo() . "',fechaNac='" . $u->getFechaNac() . "',idFarmacia='" . $u->Farmacia->getIdFarmacia() . "' WHERE idUser='" . $u->getIdUser() . "'";
        $result = $db->query($sql);
        if (!$result) {
                //Niega la actualizacion
            $db->query("ROLLBACK");
        } else {
                //Realiza el commit
            $db->query("COMMIT");
            $rpta = true;
        }
    } catch (exception $e) {
        try {
            $db->query("ROLLBACK");
        } catch (exception $e1) {

        }
    }
    return $rpta;
}

public function modificar2(Usuario $u) {
    $db = db::getInstance();
    $rpta = false;
    try {
        $db->query("BEGIN");
        $sql = "UPDATE users SET usuario='" . $u->getUsuario() . "',email='" . $u->getEmail() . "',"
        . "sexo='" . $u->getSexo() . "',fechaNac='" . $u->getFechaNac() . "' WHERE idUser='" . $u->getIdUser() . "'";
        $result = $db->query($sql);
        if (!$result) {
                //Niega la actualizacion
            $db->query("ROLLBACK");
        } else {
                //Realiza el commit
            $db->query("COMMIT");
            $rpta = true;
        }
    } catch (exception $e) {
        try {
            $db->query("ROLLBACK");
        } catch (exception $e1) {

        }
    }
    return $rpta;
}

public function getUserByEmail($email) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select email from users where email = '" . $db->prepare($email) . "'";
        $consulta = $db->query($sql);
        return ($db->num_rows($consulta) > 0);
    }

    public function getUserByEmailObj($email) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select idUser from users where email = '" . $db->prepare($email) . "'";
        $consulta = $db->query($sql);
        $r = $db->fetch_array($consulta);
        $new = $this->getUserByIdObj($r['idUser']);
        return $new;
    }

    public function getUserByUser($usuario) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select usuario from users where usuario = '" . $db->prepare($usuario) . "'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getAuthentication($usuario, $pass) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "SELECT idUser,usuario,pass,nivelAdmin,email,sexo,fechaNac,fechaReg," .
        "loginKey,activo,ipLogin,ipReg,ultimaVisita,idFarmacia FROM users WHERE " .
        "usuario = '" . $db->prepare($usuario) . "' and pass = '" . $db->prepare($pass) . "'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            $u = $db->fetch_array($consulta);
            $newUser = new Usuario();
            $newUser->setIdUser($u['idUser']);
            $newUser->setUsuario($u['usuario']);
            $newUser->setPass($u['pass']);
            require_once 'Business/nivelAdmin.class.php';
            $n = new nivelAdmin();
            $n->setIdAdmin($u['nivelAdmin']);
            $newUser->setNivelAdmin($n);
            $newUser->setEmail($u['email']);
            $newUser->setSexo($u['sexo']);
            $newUser->setFechaNac($u['fechaNac']);
            $newUser->setFechaReg($u['fechaReg']);
            $newUser->setLoginKey($u['loginKey']);
            $newUser->setActivo($u['activo']);
            $newUser->setIpLogin($u['ipLogin']);
            $newUser->setIpReg($u['ipReg']);
            $newUser->setUltimaVisita($u['ultimaVisita']);
            require_once "DAL/farmaciaBD.class.php";
            $newUser->setFarmacia(farmaciaBD::getPharmacyById($u['idFarmacia']));
            return $newUser;
        }
    }

    public function setLoginKey($loginKey, $id) {
        $db = Db::getInstance();
        $loginKey = $db->prepare($loginKey);
        $id = $db->prepare($id);
        $sql = "UPDATE users SET loginKey = '$loginKey' WHERE idUser = $id ";
        $r = false;
        try {
            $consulta = $db->query($sql);
            $r = true;
        } catch (Exception $exc) {

        }
        return $r;
    }

    public function getUserByIdBool($id) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select idUser from users where idUser = '" . $db->prepare($id) . "'";
        $consulta = $db->query($sql);
        return ($db->num_rows($consulta) > 0);
    }

//ready

    public function getUserByIdObj($id) {
        $db = db::getInstance(); // finalmente tenemos visibilidad al objeto db (conexion)
        $sql = "select idUser,usuario,pass,nivelAdmin,email,sexo,loginKey,fechaNac,idFarmacia,ultimaVisita"
        . " from users where idUser = '" . $db->prepare($id) . "'";
        $consulta = $db->query($sql);
        if ($db->num_rows($consulta) > 0) {
            $u = $db->fetch_array($consulta);
            $newUser = new Usuario();
            $newUser->setIdUser($u['idUser']);
            $newUser->setUsuario($u['usuario']);
            $newUser->setPass($u['pass']);
            require_once 'DAL/nivelAdminBD.class.php';
            $newUser->setNivelAdmin(nivelAdminBD::getById($u['nivelAdmin']));
            $newUser->setEmail($u['email']);
            $newUser->setSexo($u['sexo']);
            $newUser->setFechaNac($u['fechaNac']);
            $newUser->setLoginKey($u['loginKey']);
            $newUser->setUltimaVisita($u['ultimaVisita']);
            require_once 'DAL/farmaciaBD.class.php';
            $newUser->setFarmacia(farmaciaBD::getPharmacyById($u['idFarmacia']));
            return $newUser;
        }
    }

//ready

    public function devolverAlgo() {
        return "Hola";
    }

    public function showUsers($criterio) {

        /* Creamos la instancia del objeto. Ya estamos conectados */
        $db = Db::getInstance();
        $cr = $db->prepare($criterio);
        try {
			//$db->query("SET NAMES 'utf8'");
            $consulta = $db->query("SELECT idUser FROM users ORDER BY $cr ");
            $lista = array();
            while ($r = $db->fetch_array($consulta)) {
                $newUser = self::getUserByIdObj($r['idUser']);
                $lista[] = $newUser;
            }
            $db->free_result($consulta);
        } catch (exception $e) {

        }
        return $lista;
    }

    public function showUsers2($criterio) {

        /* Creamos la instancia del objeto. Ya estamos conectados */
        $db = Db::getInstance();
        $cr = $db->prepare($criterio);
        $consulta = $db->query("SELECT  users.usuario,
                                        users.email,
                                        users.sexo,
                                        users.fechaNac,
                                        users.fechaReg,
                                        users.activo,
                                        users.ultimaVisita,
                                        niveladmin.descripcion,
                                        farmacias.fantasia,
                                        farmacias.razon
                                        FROM users
                                        INNER JOIN niveladmin
                                        ON users.nivelAdmin = niveladmin.idAdmin
                                        INNER JOIN farmacias
                                        ON users.idFarmacia = farmacias.codigo");
        $lista = array();
        while ($r = $db->fetch_array($consulta)) {
            $newUser = new Usuario();
            $newUser->setUsuario($r['usuario']);
            $newUser->setEmail($r['email']);
            $newUser->setSexo($r['sexo']);
            $newUser->setFechaNac($r['fechaNac']);
            $newUser->setFechaReg($r['fechaReg']);
            $newUser->setActivo($r['activo']);
            $newUser->setUltimaVisita($r['ultimaVisita']);
            $newUser->setNivelAdmin($r['descripcion']);
            $newUser->setFarmacia($r['fantasia']);

            $lista[] = $newUser;
        }
        $db->free_result($consulta);
        return $lista;
    }

    public function setValues($iplogin, $lastvisit, $key, $id) {
        $db = Db::getInstance();
        $sql = "UPDATE users SET ipLogin = '" . $db->prepare($iplogin) . "', loginKey = '" . $db->prepare($key) . "'," .
        " ultimaVisita = '" . $db->prepare($lastvisit) . "' WHERE idUser = '" . $db->prepare($id) . "'";
        $r = false;
        try {
            $consulta = $db->query($sql);
            $r = true;
        } catch (Exception $exc) {

        }
        return $r;
    }

}

?>
