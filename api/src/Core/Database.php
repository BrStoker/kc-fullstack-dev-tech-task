<?php

namespace Core;

use PDO;
use PDOException;
class Database
{

    private static ?Database $instance = null;
    private PDO $pdo;

    public function __construct() {
        $this->loadEnv();
        $dsn = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME') . ";charset=utf8mb4";
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }

    private function loadEnv(): void
    {
        $envPath = dirname(__DIR__, 2) . '/.env';
        if (file_exists($envPath)) {
            $env = parse_ini_file($envPath);
            foreach ($env as $key => $value) {
                putenv("$key=$value");
            }
        }
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }

    public function migrate($dir = "/tmp/migrations"): void
    {
        $dataDir = "/data";
        if (!is_dir($dir)) {
            die("Migration directory not found: $dir");
        }

        $files = glob($dir . "/*.sql");

        foreach ($files as $file) {
            $this->executeSQLFile($file);
        }

        $dataFiles = glob($dir.$dataDir."/*.sql");
        foreach ($dataFiles as $file) {
            $this->executeSQLFile($file);
        }
    }

    private function executeSQLFile($filePath): void
    {
        $sql = file_get_contents($filePath);

        if ($sql === false) {
            echo "Failed to read SQL file: $filePath\n";
            return;
        }

        try {
            $this->pdo->exec($sql);
            echo "Executed: $filePath\n";
        } catch (PDOException $e) {
            echo "Error executing $filePath: " . $e->getMessage() . "\n";
        }
    }

}