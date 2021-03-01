<!DOCTYPE html>
<html>
<head>
<title>Search | Поиск</title>
<meta charset="UTF-8">
</head>
<body>
<form action="" method="GET">
        <input type="text" name="query" />
		<input type="submit" name="submit" value="Search|Найти" />
</form>
<h2>Search | Поиск</h2>
<?php
$conn = new mysqli('localhost:3306', 'root', 'root', 'task_db');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = $_GET['query'];
$query = "%" . $query . "%";
if(strlen($query) >= 3){
	$stmt = $conn -> prepare("SELECT * FROM comment WHERE `body` LIKE ?");
	$stmt -> bind_param("s", $query);
	$stmt -> execute();
	$arr = $stmt -> get_result()->fetch_all(MYSQLI_ASSOC);
	$stmt -> close();
}

?>



</body>
</html>