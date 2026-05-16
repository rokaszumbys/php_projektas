<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../classes/Database.php";

$database = new Database();
$db = $database->connect();

$sql = "SELECT * FROM passwords WHERE user_id = :user_id ORDER BY created_at DESC";
$stmt = $db->prepare($sql);
$stmt->execute([":user_id" => $_SESSION["user_id"]]);

$passwords = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Valdymo puslapis</title>
</head>
<body>

<h2>Sveikas, <?php echo $_SESSION["username"]; ?></h2>

<a href="add_password.php">Pridėti slaptažodį</a> |
<a href="../logout.php">Atsijungti</a>

<h3>Išsaugoti slaptažodžiai</h3>

<table border="1" cellpadding="8">
    <tr>
        <th>Pavadinimas</th>
        <th>Užkoduotas slaptažodis</th>
        <th>Data</th>
    </tr>

    <?php foreach ($passwords as $pass): ?>
        <tr>
            <td><?php echo $pass["title"]; ?></td>
            <td><?php echo $pass["encrypted_password"]; ?></td>
            <td><?php echo $pass["created_at"]; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>