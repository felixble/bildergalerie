<?php

require_once(__DIR__ . '/../../config.php');

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;


abstract class DbTestCase extends TestCase
{
    use TestCaseTrait;static private $pdo = null;

    private $conn = null;

    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE;
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, DB_DATABASE);
        }

        return $this->conn;
    }

}