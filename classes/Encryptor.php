<?php

class Encryptor {
    private $method = "AES-256-CBC";

    public function encrypt($text, $key) {
        $iv = openssl_random_pseudo_bytes(16);
        $encrypted = openssl_encrypt($text, $this->method, $key, 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public function decrypt($encryptedText, $key) {
        $data = base64_decode($encryptedText);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);

        return openssl_decrypt($encrypted, $this->method, $key, 0, $iv);
    }
}