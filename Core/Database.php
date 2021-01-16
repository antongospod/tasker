<?php

namespace App\Core;

use PDO;
use PDOException;
use App\config\Config;

class Database {

    /** @var PDO */
    public $database;

    /** @var PDOException */
    public $errors;

    /** @var self */
    private static $dbInstance;

    /**
     * Set DB config params and make new connect to DB
     */
    private function __construct()
    {
        $dsn = Config::DB_DRIVER . ':host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';port=' . Config::DB_PORT . ';charset=UTF8';
        try {
            $this->database = new PDO(
                $dsn,
                Config::DB_USER,
                Config::DB_PASSWORD,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
            if (!$this->database) {
                throw new PDOException('Error connection to DB');
            }
        } catch(PDOException $ex) {
            $this->errors = $ex;
            echo $this->errors;
            exit;
        }
    }

    /**
     * Singleton instance of DB object connect.
     */
    public static function connect(): self
    {
        if (null === self::$dbInstance) {
            self::$dbInstance = new self();
        }

        return self::$dbInstance;
    }

    /**
     * @param PDO|null $connection
     *
     * @return void
     */
    public static function closeConnection(&$connection = null) {
        if ($connection) {
            $connection = null;
        } else {
            self::$dbInstance->database = null;
        }
    }

    private function __clone() {}
}
