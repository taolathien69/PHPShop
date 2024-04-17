<?php
class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $query = "SELECT * FROM Products";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($productId) {
        $query = "SELECT * FROM Products WHERE ProductID = :productId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price, $image) {
        $query = "INSERT INTO Products (Name, Description, Price, Image) VALUES (:name, :description, :price, :image)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function updateProduct($productId, $name, $description, $price, $image) {
        $query = "UPDATE Products SET Name = :name, Description = :description, Price = :price, Image = :image WHERE ProductID = :productId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':productId', $productId);
        return $stmt->execute();
    }
    
    public function deleteProduct($productId) {
        $query = "DELETE FROM Products WHERE ProductID = :productId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId);
        return $stmt->execute();
    }

    public function searchProducts($keyword) {
        $query = "SELECT * FROM Products WHERE Name LIKE :keyword OR Description LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $keyword = "%{$keyword}%"; // Thêm ký tự đại diện % để tìm kiếm tất cả các từ chứa từ khóa
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}