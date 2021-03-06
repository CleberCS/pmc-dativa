<?php

/**
 * Classe responsável pela conexão com o banco de dados (padrão SingleTon)
 * Retorna um objeto PDO pelo método estático getConn();
 * @author Cleber C. Santos
 */
class Conn {

    private static $Host = HOST;
    private static $User = USER;
    private static $Pass = PASS;
    private static $Dbsa = DBSA;

    /** @var PDO */
    private static $Connect = null;

    /** CONECTA COM O BANCO DE DADOS PATERN SINGLETON */
    private static function Conectar() {
        try {
            if (self::$Connect == NULL):
                $dsn = 'mysql:host=' . self::$Host . ';dbname=' . self::$Dbsa;
                $options = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'];
                self::$Connect = new PDO($dsn, self::$User, self::$Pass, $options);
            endif;
        } catch (PDOException $e) {
            PHPErro($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die;
        }
        self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$Connect;
    }

    /** Retorna um objeto PDO SingleTon Pattern */
    public static function getConn() {
        return self::Conectar();
    }

}
