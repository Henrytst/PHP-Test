<?php

class Migration
{
    public function slqCreateSchema()
    {
        try {
            $pdo = new PDO("mysql:host=localhost", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $slqCreateSchema = 'CREATE SCHEMA banco_de_dados CHARACTER SET utf8 COLLATE utf8_unicode_ci';
            $stmt = $pdo->prepare($slqCreateSchema);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}

