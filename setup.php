<?php
$host = 'localhost';
$user = 'root';
$pass = 'Ajay@111';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS thigazh_db");
    echo "Database created successfully\n";

    $pdo->exec("USE thigazh_db");

    $pdo->exec("DROP TABLE IF EXISTS registrations");
    $sql = file_get_contents('schema.sql');
    $pdo->exec($sql);
    echo "Tables created successfully\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
