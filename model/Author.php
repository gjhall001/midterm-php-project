<?php
    class Author {
        // DB Stuff
        private $conn;
        private $table = 'authors';

        // Author Properties
        public $id;
        public $author;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Authors
        public function read() {
            $query = "SELECT * FROM {$this->table} ORDER BY id ASC";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }

        // Get Single Author
        public function read_single() {
            $query = "SELECT * FROM {$this->table}
                WHERE id = :id LIMIT 1";
            
            // Prepared Statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind ID
            $stmt->bindParam(":id", $this->id);

            // Execute statement
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $this->id = $row['id'];
                $this->author = $row['author'];
                return true;
            }

            return false;
        }

        // Create Author
        public function create() {
            $query = "INSERT INTO {$this->table} (author)
                VALUES (:author)
                RETURNING id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(":author", $this->author);

            // Execute query 
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if($result) {
                    $this->id = $result['id'];
                }                
                return true;
            }
            
            // Print error if something goes wrong        
            printf("Error: %s\n", $stmt->error);
            return false; 
        }

        // Update Author
        public function update() {
            $query = "UPDATE {$this->table}
                SET
                    author = :author
                WHERE
                    id = :id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(":author", $this->author);
            $stmt->bindParam(":id", $this->id);

            // Execute query 
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            
            printf("Error: %s\n", $stmt->error);
            return false; 
        }

        // Delete Author
        public function delete() {
            $query = "DELETE FROM {$this->table} WHERE id = :id
                RETURNING id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(":id", $this->id);

            // Execute query 
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }

            printf("Error: %s\n", $stmt->error);
            return false;            
        }

        // Helper function to determine if author exists in the database
        public function authorExists($id) {
            $query = "SELECT 1 FROM {$this->table}
                WHERE id = :id LIMIT 1";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(":id", $id);

            // Execute Statement
            $stmt->execute();

            return $stmt->rowCount() > 0;
        }        
    }