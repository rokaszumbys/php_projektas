<?php

session_start();

require_once "../classes/Database.php";
require_once "../classes/User.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->connect();

    $userObj = new User($db);

    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = $userObj->login($username, $password);

    if ($user) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["plain_password"] = $password;

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Neteisingas vardas arba slaptažodis.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
</head>
<body>

<h2>Prisijungimas</h2>

<p><?php echo $message; ?></p>

<form method="POST">
    <label>Vartotojo vardas:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Prisijungti</button>
</form>

<br>
<a href="register.php">Neturi paskyros? Registruokis</a>

</body>
</html>