<?php

class PasswordGenerator {
    public function generate($lower, $upper, $numbers, $specials) {
        $lowerChars = "abcdefghijklmnopqrstuvwxyz";
        $upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $numberChars = "0123456789";
        $specialChars = "!@#$%^&*";

        $password = "";

        for ($i = 0; $i < $lower; $i++) {
            $password .= $lowerChars[rand(0, strlen($lowerChars) - 1)];
        }

        for ($i = 0; $i < $upper; $i++) {
            $password .= $upperChars[rand(0, strlen($upperChars) - 1)];
        }

        for ($i = 0; $i < $numbers; $i++) {
            $password .= $numberChars[rand(0, strlen($numberChars) - 1)];
        }

        for ($i = 0; $i < $specials; $i++) {
            $password .= $specialChars[rand(0, strlen($specialChars) - 1)];
        }

        return str_shuffle($password);
    }
}