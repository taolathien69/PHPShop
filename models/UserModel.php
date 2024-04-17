<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function registerUser($user) {
        $query = "INSERT INTO users (username, password, fullname, email, role) VALUES (:username, :password, :fullname, :email, :role)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $user['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $user['password'], PDO::PARAM_STR);
        $stmt->bindParam(':fullname', $user['fullname'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $user['email'], PDO::PARAM_STR);
        $stmt->bindParam(':role', $user['role'], PDO::PARAM_STR);
        return $stmt->execute();
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

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}