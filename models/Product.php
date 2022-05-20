<?php 
  class Product {
    // DB stuff
    private $conn;
    private $table = 'product';

    // product Properties
    public $sku;
    public $name;
    public $price;
    public $type;
    public $size;
    public $height;
    public $width;
    public $length;
    public $weight;
    public $created_at;
    public $is_active;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // List Products
    public function listProducts() {
      // Create query
      $query = 'SELECT sku, name, price, type, size, height, width, length, weight
                                FROM ' . $this->table . ' WHERE
                                  is_active = "t" ORDER BY created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    
    // add product
    public function addProduct() {
          // search for sku exxistence
          $searchSku = 'SELECT count(*) sku FROM ' . $this->table . ' WHERE sku = :sku AND is_active = "t"';     

          // Prepare statement
          $stmtSearchSku = $this->conn->prepare($searchSku);
          
          // Clean data
          $this->sku = htmlspecialchars(strip_tags($this->sku));

          // Bind data
          $stmtSearchSku->bindParam(':sku', $this->sku);

          // Execute query
          $stmtSearchSku->execute();
            $resultSku = implode(', ', $stmtSearchSku->fetch(PDO::FETCH_ASSOC));

          
          if($resultSku === '0') {
             // insert to t_contact and count rows
          $qryAddProduct = 'INSERT INTO ' . $this->table . ' SET sku = :sku, name = :name, price = :price, type = :type, size = :size, height = :height, width = :width, length = :length, weight = :weight, is_active = "t"';
          

          // Prepare statement
          $stmtAddProduct = $this->conn->prepare($qryAddProduct);
          
          // Clean data
          $this->sku = htmlspecialchars(strip_tags($this->sku));
          $this->name = htmlspecialchars(strip_tags($this->name));
          $this->price = htmlspecialchars(strip_tags($this->price));
          $this->type = htmlspecialchars(strip_tags($this->type));
          $this->size = htmlspecialchars(strip_tags($this->size));
          $this->height = htmlspecialchars(strip_tags($this->height));
          $this->width = htmlspecialchars(strip_tags($this->width));
          $this->length = htmlspecialchars(strip_tags($this->length));
          $this->weight = htmlspecialchars(strip_tags($this->weight));

          // Bind data
          $stmtAddProduct->bindParam(':sku', $this->sku);
          $stmtAddProduct->bindParam(':name', $this->name);
          $stmtAddProduct->bindParam(':price', $this->price);
          $stmtAddProduct->bindParam(':type', $this->type);
          $stmtAddProduct->bindParam(':size', $this->size);
          $stmtAddProduct->bindParam(':height', $this->height);
          $stmtAddProduct->bindParam(':width', $this->width);
          $stmtAddProduct->bindParam(':length', $this->length);
          $stmtAddProduct->bindParam(':weight', $this->weight);

          // Execute query
          $stmtAddProduct->execute();

          return true;
      } else {
          return false;
      }

    }   
    public function massDelete() {
    $qryAddProduct = 'UPDATE ' . $this->table . ' SET is_active = "f" WHERE sku = :sku';
          

    // Prepare statement
    $stmtAddProduct = $this->conn->prepare($qryAddProduct);
    
    // Clean data
    $this->sku = htmlspecialchars(strip_tags($this->sku));

    // Bind data
    $stmtAddProduct->bindParam(':sku', $this->sku);

    // Execute query
    $stmtAddProduct->execute();

    return true;
  }
  }