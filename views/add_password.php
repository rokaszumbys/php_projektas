<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../classes/Database.php";
require_once "../classes/PasswordGenerator.php";
require_once "../classes/Encryptor.php";

$database = new Database();
$db = $database->connect();

$generatedPassword = "";
$message = "";

if (isset($_POST["generate"])) {
    $generator = new PasswordGenerator();

    $lower = $_POST["lower"];
    $upper = $_POST["upper"];
    $numbers = $_POST["numbers"];
    $specials = $_POST["specials"];

    $generatedPassword = $generator->generate($lower, $upper, $numbers, $specials);
}

if (isset($_POST["save"])) {
    $title = $_POST["title"];
    $password = $_POST["password"];

    $encryptor = new Encryptor();
    $encryptedPassword = $encryptor->encrypt($password, $_SESSION["plain_password"]);

    $sql = "INSERT INTO passwords (user_id, title, encrypted_password) 
            VALUES (:user_id, :title, :encrypted_password)";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        ":user_id" => $_SESSION["user_id"],
        ":title" => $title,
        ":encrypted_password" => $encryptedPassword
    ]);

    $message = "Slaptažodis išsaugotas.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pridėti slaptažodį</title>
</head>
<body>

<h2>Pridėti slaptažodį</h2>

<p><?php echo $message; ?></p>

<h3>Generuoti slaptažodį</h3>

<form method="POST">
    <label>Mažųjų raidžių kiekis:</label><br>
    <input type="number" name="lower" value="2"><br><br>

    <label>Didžiųjų raidžių kiekis:</label><br>
    <input type="number" name="upper" value="2"><br><br>

    <label>Skaičių kiekis:</label><br>
    <input type="number" name="numbers" value="2"><br><br>

    <label>Specialių simbolių kiekis:</label><br>
    <input type="number" name="specials" value="2"><br><br>

    <button type="submit" name="generate">Generuoti</button>
</form>

<h3>Išsaugoti slaptažodį</h3>

<form method="POST">
    <label>Pavadinimas:</label><br>
    <input type="text" name="title" placeholder="Pvz. Gmail" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="text" name="password" value="<?php echo $generatedPassword; ?>" required><br><br>

    <button type="submit" name="save">Išsaugoti</button>
</form>

<br>
<a href="dashboard.php">Grįžti atgal</a>

</body>
</html>