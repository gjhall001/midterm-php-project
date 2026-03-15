<?php
    class Database {
        private $host;
        private $port;
        private $dbname;
        private $username;
        private $password;
        private $conn;

        // Constructor
        public function __construct() {
            $this->host = getenv("HOST");
            $this->port = getenv("PORT");
            $this->username = getenv("USERNAME");
            $this->password = getenv("PASSWORD");
            $this->dbname = getenv("DBNAME");
        }

        // DB CONNECT
        public function connect() {
            // instead of $this->conn = null;
            if ($this->conn) {
                // connection already exists
                return $this->conn;
            } else {
                $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";

                try {
                    $this->conn = new PDO($dsn, $this->username, $this->password);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch (PDOException $e) {
                    echo "Connection error: {$e->getMessage()}";
                }
            }
        }
    }