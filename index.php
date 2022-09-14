<?php
session_start();
$servername = "localhost";
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
$sql = "
CREATE table IF NOT EXISTS `pasteSpace`
(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
author VARCHAR(50) NOT NULL,
title VARCHAR(50) NOT NULL,
language VARCHAR(20),
paste TEXT NOT NULL, 
url VARCHAR(100)
);";
$stmt = $conn->prepare($sql);
$stmt->execute();

function RandomURL($conn)
{
    $URL = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8);
    $stmt = $conn->prepare("SELECT * FROM pasteSpace WHERE url=?");
    $stmt->execute([$URL]);
    $fetchURL = $stmt->fetch();
    if ($fetchURL) {
        echo "URL Exists";
        RandomURL($conn);
    } else {
        echo "New URL! go to paste";
    }
    return $URL;
}

$link = RandomURL($conn);
$_SESSION['link'] = $link;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./codemirror/theme/dracula.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="./codemirror/lib/codemirror.css">
    <script src="./codemirror/mode/javascript/javascript.js"></script>
    <script src="./codemirror/mode/sql/sql.js"></script>
    <script src="./codemirror/mode/xml/xml.js"></script>
    <script src="./codemirror/mode/php/php.js"></script>
    <script src="./codemirror/mode/css/css.js"></script>
    <title>PasteSpace</title>
</head>

<body>
    <h1 style="color:white;
font-size: 10em;
font-family: monospace;"> PasteSpace</h1>

    <div class="mainWrapper">
        <form method="POST" action="push_data.php">
            <div class="infoFields">
                <div class="form__group field">
                    <input type="input" class="form__field" placeholder="Author" name="author" id='author' required />
                    <label for="author" class="form__label">Author</label>
                </div>
                <div class="form__group field">
                    <input type="input" class="form__field" placeholder="Title" name="title" id='name' required />
                    <label for="title" class="form__label">Title</label>
                </div>
                <div class="taalKeuze" onchange="getLanguage()">
                    <label><input type="radio" name="language" id="language" value="php"><span>PHP</span></label>
                    <label><input type="radio" name="language" id="language" value="sql"><span>SQL</span></label>
                    <label><input type="radio" name="language" id="language" value="css"><span>CSS</span></label>
                    <label><input type="radio" name="language" id="language" value="xml" checked><span>HTML</span></label>
                    <label><input type="radio" name="language" id="language" value="javascript"><span>JS</span></label>
                </div>
            </div>
            <div class="pasteContainer">
                <div class="pasteSpace">
                    <pre>
                        <textarea id="code" contenteditable="true" rows="10" name="code">Feel free to paste or type your code here after selection your language 😘</textarea>
                    </pre>
                </div>

            </div>

            <button type="submit" value="Submit">PASTE</button>


        </form>
    </div>
</body>
<script>
window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    mode: 'application/x-httpd-php',
    matchBrackets: true,
    styleActiveLine: true,
    theme: "dracula",
    lineNumbers: true,
    indentWithTabs: true,
    startOpen: true
});

function getLanguage() {
    var taal = document.querySelector('input[name="language"]:checked').value;
    console.log(taal);
    window.editor.setOption('mode', taal);
    console.log(window.editor)
}

var taal = getLanguage();
</script>

<script src="main.js"></script>

</html>