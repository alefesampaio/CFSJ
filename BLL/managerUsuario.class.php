<?php

require 'DAL/usuarioBD.class.php';
/*
 * 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManagerUsuario
 *
 * @author David
 */
class ManagerUsuario {

    public static function insertarUsuario(Usuario $user) {
        $udb = new usuarioBD();
        return $udb->insertar($user);
    }

    public static function modificarUsuario(Usuario $user) {
        $ubd = new UsuarioBD();
        return $ubd->modificar($user);
    }

    public static function modificarUsuario2(Usuario $user) {
        $ubd = new UsuarioBD();
        return $ubd->modificar2($user);
    }

    public static function obtenerTodos($criterio) {
        $udb = new usuarioBD();
        return $udb->showUsers2($criterio);
    }

    public static function obtenerUsuarioPorEmail($email) {
        $udb = new usuarioBD();
        return $udb->getUserByEmail($email);
    }

    public static function obtenerUsuarioPorEmailObj($email) {
        $udb = new usuarioBD();
        return $udb->getUserByEmailObj($email);
    }

    public static function obtenerUsuarioPorUser($usuario) {
        $udb = new usuarioBD();
        return $udb->getUserByUser($usuario);
    }

    public static function obtenerAutenticacion($usuario, $pass) {
        $udb = new usuarioBD();
        return $udb->getAuthentication($usuario, $pass);
    }

    public static function actualizarValores($iplogin, $lastvisit, $key, $id) {
        $udb = new usuarioBD();
        return $udb->setValues($iplogin, $lastvisit, $key, $id);
    }

    public static function obtenerUsuarioPorIdObj($id) {
        $udb = new usuarioBD();
        return $udb->getUserByIdObj($id);
    }

    public static function obtenerUsuarioPorIdBool($id) {
        $udb = new usuarioBD();
        return $udb->getUserByIdBool($id);
    }

    public static function modificarPass($user) {
        return usuarioBD::modifyPass($user);
    }

    public static function actualizarLoginKey($loginKey, $userId) {
        $udb = new usuarioBD();
        return $udb->setLoginKey($loginKey, $userId);
    }

}

?>
