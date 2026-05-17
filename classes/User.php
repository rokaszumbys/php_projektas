<?php

require_once "Encryptor.php";

class User {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

public function register($username, $password) {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $plainKey = bin2hex(random_bytes(16));

    $encryptor = new Encryptor();
    $encryptedKey = $encryptor->encrypt($plainKey, $password);

    $sql = "INSERT INTO users (username, password_hash, encrypted_key) 
            VALUES (:username, :password_hash, :encrypted_key)";

    $stmt = $this->conn->prepare($sql);

    try {
        return $stmt->execute([
            ":username" => $username,
            ":password_hash" => $passwordHash,
            ":encrypted_key" => $encryptedKey
        ]);
    } catch (PDOException $e) {
        return false;
    }
}

    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":username" => $username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password_hash"])) {
            return $user;
        }

        return false;
    }
}