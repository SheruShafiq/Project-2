<?php
session_start();


$servername = "127.0.0.1";
$username = 'cryptostalkers';
$password = 'LWCGkjvBcGDtR2n@';

try {
    $conn = new PDO("mysql:host=localhost;dbname=cryptostalkers", $username, $password) or die('Unable to connect');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e . getMessage();   
}
function getMessage() 
{
    "fuck";
}


$author = $_POST["author"];
$title = $_POST["title"];
$language = $_POST["language"];
$code = $conn->quote(rtrim($_POST["code"]));
$link = $_SESSION['link'];

$sql = "
INSERT INTO pasteSpace (author, title, language, url, paste) VALUES
('$author', '$title', '$language', '$link', $code);";
$stmt = $conn->prepare($sql);
$stmt->execute();


var_dump(__DIR__);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="pushdata.css">
    <title>Result</title>
</head>
<body>
<h1>LINK CREATION SUCCESFUL</h1>
<a href="./result.php?<?php echo $link;?>"><?php echo __DIR__ . "/result.php?" . $link ?></a>
</body>
</html>