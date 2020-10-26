<?php
  class Post {
    // DB stuff
    private $conn;
    private $table = 'users';

    // Post Properties
    public $id;
    public $username;
    public $name;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT c.username as username,c.id, c.name FROM ' . $this->table . ' c';

      // Prepare statement
     $stmt = $this->conn->prepare($query);

     // Execute query
     $stmt->execute();

     return $stmt;
   }

   // Get Single Post
public function read_single() {
      // Create query
      $query = 'SELECT c.username as username,c.id, c.name FROM ' . $this->table . ' c
                                WHERE
                                  c.id = ?
                                LIMIT 0,1';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->username = $row['username'];
      $this->name = $row['name'];
}

// Create Post
public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table .
      ' SET id = :id, username = :username, name = :name';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->name = htmlspecialchars(strip_tags($this->name));


      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':name', $this->name);


      // Execute query
      if($stmt->execute()) {
        return true;
  }

  // Print error if something goes wrong
  printf("Error: %s.\n", $stmt->error);

  return false;
}

// Update Post
public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . '
                            SET id = :id, username = :username, name = :name
                            WHERE id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->username = htmlspecialchars(strip_tags($this->username));
      $this->name = htmlspecialchars(strip_tags($this->name));


      // Bind data
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':username', $this->username);
      $stmt->bindParam(':name', $this->name);



      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
}

// Delete Post
public function delete() {
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
}
}
?>
