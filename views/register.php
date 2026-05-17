<?php

require_once "../classes/Database.php";
require_once "../classes/User.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->connect();

    if ($db) {
        $user = new User($db);

        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($user->register($username, $password)) {
            $message = "Registracija sėkminga!";
        } else {
            $message = "Toks vartotojo vardas jau egzistuoja.";
        }
    } else {
        $message = "Nepavyko prisijungti prie duomenų bazės.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
</head>
<body>

<?php if (!empty($message)): ?>
    <script>
        alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>

<h2>Registracija</h2>

<p><?php echo $message; ?></p>

<form method="POST">
    <label>Vartotojo vardas:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Slaptažodis:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Registruotis</button>
</form>

<br>
<a href="login.php">Jau turi paskyrą? Prisijunk</a>

</body>
</html>