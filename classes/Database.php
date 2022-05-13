<?php

class Database
{
    protected static $host     = DATABASE['host'];
    protected static $dbname   = DATABASE['db_name'];
    protected static $username = DATABASE['username'];
    protected static $password = DATABASE['password'];

    protected static $pdo;

    protected static function connect() {
        try {
            self::$pdo = new PDO(
                'mysql:host=' . self::$host . ';dbname=' . self::$dbname,
                self::$username,
                self::$password,
            );

            self::$pdo->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );
        } catch (PDOException $e) {
            // TODO: redirect to error page -> Internal Server Error
            echo 'Error: ' . $e->getMessage() . '<br/>';
            die();
        }
    }
}