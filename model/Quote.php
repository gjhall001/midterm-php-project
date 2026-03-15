<?php
    class Quote {
        // DB Stuff
        private $conn;
        private $table = "quotes";
        private $authorTable = "authors";
        private $categoryTable = "categories";

        // Quote Properties
        public $id;
        public $quote;
        public $author;
        public $category;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Quotes
        public function read() {
            $query = "SELECT q.id, q.quote, a.author, c.category FROM {$this->table} q
            JOIN {$this->authorTable} a ON q.author_id = a.id
            JOIN {$this->categoryTable} c ON q.category_id = c.id
            ORDER BY q.id ASC";

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }

        // Get Single Quote
        public function getQuoteById() {
            $query = "SELECT q.id, q.quote, a.author, c.category FROM {$this->table} q
                JOIN {$this->authorTable} a ON q.author_id = a.id
                JOIN {$this->categoryTable} c ON q.category_id = c.id
                WHERE q.id = :id LIMIT 1";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));            

            // Bind ID
            $stmt->bindParam(":id", $this->id);

            // Execute Statement
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($row) {
                $this->id = $row["id"];
                $this->quote = $row["quote"];
                $this->author = $row["author"];
                $this->category = $row["category"];
                return true;
            }

            return false;
        }

        // Get
        public function getQuotesByAuthor() {
            $query = "SELECT q.id, q.quote, a.author, c.category FROM {$this->table} q
                JOIN {$this->authorTable} a ON q.author_id = a.id
                JOIN {$this->categoryTable} c ON q.category_id = c.id
                WHERE q.author_id = :author_id
                ORDER BY q.id ASC";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind Author and Category
            $stmt->bindParam(":author_id", $this->author);

            // Execute Statement
            $stmt->execute();

            return $stmt;            
        }

        public function getQuotesByCategory() {
            $query = "SELECT q.id, q.quote, a.author, c.category FROM {$this->table} q
                JOIN {$this->authorTable} a ON q.author_id = a.id
                JOIN {$this->categoryTable} c ON q.category_id = c.id
                WHERE q.category_id = :category_id
                ORDER BY q.id ASC";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind Author and Category
            $stmt->bindParam(":category_id", $this->category);

            // Execute Statement
            $stmt->execute();

            return $stmt;
        }

        public function getQuotesByAuthorAndCategory() {
            $query = "SELECT q.id, q.quote, a.author, c.category FROM {$this->table} q
                JOIN {$this->authorTable} a ON q.author_id = a.id
                JOIN {$this->categoryTable} c ON q.category_id = c.id
                WHERE q.author_id = :author_id AND q.category_id = :category_id
                ORDER BY q.id ASC";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind Author and Category
            $stmt->bindParam(":author_id", $this->author);
            $stmt->bindParam(":category_id", $this->category);

            // Execute Statement
            $stmt->execute();

            return $stmt;
        }

        public function create() {
            $query = "INSERT INTO {$this->table} (quote, author_id, category_id)
                VALUES (:quote, :author_id, :category_id) RETURNING id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean Data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(":quote", $this->quote);
            $stmt->bindParam(":author_id", $this->author);
            $stmt->bindParam(":category_id", $this->category);

            // Execute query
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $this->id = $result['id'];
                }
                return true;
            }
        }

        // Helper function to determine if author exists in the database
        public function authorExists($id) {
            $query = "SELECT 1 FROM {$this->authorTable}
                WHERE id = :id LIMIT 1";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(":id", $id);

            // Execute Statement
            $stmt->execute();

            return $stmt->rowCount() > 0;
        }

        // Helper function to determine if category exists in the database
        public function categoryExists($id) {
            $query = "SELECT 1 FROM {$this->categoryTable}
                WHERE id = :id LIMIT 1";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(":id", $id);

            // Execute Statement
            $stmt->execute();

            return $stmt->rowCount() > 0;
        }
        
        public function update() {
            $query = "UPDATE {$this->table}
                SET
                    id = :id,
                    quote = :quote,
                    author_id = :author_id,
                    category_id = :category_id
                WHERE id = :id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":quote", $this->quote);
            $stmt->bindParam(":author_id", $this->author);
            $stmt->bindParam(":category_id", $this->category);

            // Execute query
            if ($stmt->execute()) {
                return $stmt->rowCount() > 0;
            }
            printf("Error: %s\n", $stmt->error);
            return false; 
        }

        public function delete() {
            $query = "DELETE FROM {$this->table}
                WHERE id = :id
                RETURNING id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

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