<?php
class Connection {
    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            try {
                // Ajusta seu usuario e senha aqui
                $host = 'localhost';
                $dbname = 'techfit';
                $user = 'root';
                $pass = '1976';

                // Conecta ao MySQL
                self::$instance = new PDO(
                    "mysql:host=$host;charset=utf8",
                    $user,
                    $pass
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Cria o banco de dados se não exista
                self::$instance->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                self::$instance->exec("USE $dbname");
            } catch (PDOException $e) {
                die("Erro ao conectar ao MySQL: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}