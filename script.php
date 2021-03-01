<?php
$post_count = 0;
$comment_count = 0;

$conn = new mysqli('localhost:3306', 'root', 'root', 'task_db');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$jsonStringPosts = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$jsonArrayPosts = json_decode($jsonStringPosts, true);

$jsonStringComments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$jsonArrayComments = json_decode($jsonStringComments, true);

foreach ($jsonArrayPosts as $item) 
{	
	$stmt = $conn -> prepare("INSERT INTO post (userId, id, title, body) VALUES (?, ?, ?, ?)");
	$stmt -> bind_param("iiss", $item['userId'], $item['id'], $item['title'], $item['body']);	
	$stmt -> execute();
	$post_count +=1;
}

foreach ($jsonArrayComments as $item) 
{	
	$stmt = $conn -> prepare("INSERT INTO comment (postId, id, name, email, body) VALUES (?, ?, ?, ?, ?)");
	$stmt -> bind_param("iisss", $item['postId'], $item['id'], $item['name'], $item['email'], $item['body']);	
	$stmt -> execute();
	$comment_count +=1;
}

$conn -> close();

echo "Imported {$post_count} posts and {$comment_count} comments|Загружено {$post_count} записей и {$comment_count} комментариев";
?>