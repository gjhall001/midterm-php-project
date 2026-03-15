<?php
    class Category {
        // DB Stuff
        private $conn;
        private $table = 'categories';

        // Category Properties
        public $id;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        public function read() {
            $query = "SELECT * FROM {$this->table} ORDER BY id ASC";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }

        // Get Single Category
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
                $this->category = $row['category'];
                return true;
            }

            return false;
        }

        // Create Category
        public function create() {
            $query = "INSERT INTO {$this->table} (category)
                VALUES (:category)
                RETURNING id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(":category", $this->category);

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

        // Update Category
        public function update() {
            $query = "UPDATE {$this->table}
                SET
                    category = :category
                WHERE
                    id = :id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(":category", $this->category);
            $stmt->bindParam(":id", $this->id);

            // Execute query 
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            
            printf("Error: %s\n", $stmt->error);
            return false; 
        }

        // Delete Category
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
    }