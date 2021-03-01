<!DOCTYPE html>
<html>
<head>
<title>Search | Поиск</title>
<meta charset="UTF-8">
<style>
table, th, td {border: 1px solid black;border-collapse: collapse;}
</style>
</head>
<body>
<form action="" method="GET">
        <input type="text" name="query" />
		<input type="submit" name="submit" value="Search|Найти" />
</form>

<?php
$conn = new mysqli('localhost:3306', 'root', 'root', 'task_db');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


if(isset($_GET['query'])) {
	$query = $_GET['query'];
	
	if(strlen($query) >= 3){
	$stmt = $conn -> prepare("SELECT DISTINCT p.title, p.id, c.body FROM post p INNER JOIN comment c ON c.postid = p.id WHERE c.body LIKE ?");
	$query = "%" . $query . "%";
	$stmt -> bind_param("s", $query);
	$stmt -> execute();
	$arr = $stmt -> get_result()->fetch_all(MYSQLI_ASSOC);
	//var_export($arr);
	$stmt -> close();
} else {echo "Min search length is 3 characters | Минимальная длинна запроса 3 символа";}

if (isset($arr)){
if (count($arr) > 0){
	echo "<h2>Search Results| Результаты Поиска</h2>";
	echo "<table style=\"width:80%\"><tr><th>ID</th><th>Post Title | Запись</th><th>Comment | Комментарий</th></tr>";
	foreach ($arr as $item) {
	echo("<tr><td>{$item['id']}</td><td>{$item['title']}</td><td>{$item['body']}</td></tr>");
}
} else {echo "No results found | Результаты не найдены";}
	echo "</table>";
}
}
?>

</body>
</html>