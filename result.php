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


if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $url = "https://";
else
    $url = "http://";
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];
$url = ltrim(stristr($url, '?'), '?');
echo $url;



$query = "SELECT * FROM pasteSpace WHERE url='$url'";
$result = $conn->query($query);
$end = $conn->query($query);
while ($row = $result->fetch()) {
    $_SESSION['author'] = $row["author"];
    $_SESSION['title'] = $row["title"];
    $_SESSION['language'] = $row["language"];
    $_SESSION['paste'] = $row["paste"];
}


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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="result.css">
    <script src="./codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="./codemirror/lib/codemirror.css">
    <script src="./codemirror/mode/javascript/javascript.js"></script>
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

    <link rel="stylesheet" href="./codemirror/theme/dracula.css">


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
                    <input type="input" class="form__field" placeholder="Author" name="author" id='author' disabled>
                    <label for="author" class="form__label"> <?php echo $_SESSION['author'] ?></label>
                </div>
                <div class="form__group field">
                    <input type="input" class="form__field" placeholder="Title" name="title" id='name' disabled >
                    <label for="title" class="form__label"><?php echo $_SESSION['title'] ?></label>
                </div>
                <div class="taalKeuze" onchange="getLanguage()">
                <input name="language" id="language" value="<?php echo $_SESSION['language'] ?>">
                <label id="language"> <?php echo $_SESSION['language']; ?></label>
                </div>
            </div>
            <div class="pasteContainer">
                <div class="pasteSpace">
                    <pre>
                        <textarea id="code" contenteditable="true" rows="10" name="code">
                        <?php echo $_SESSION['paste'] ?>
                        </textarea>
                    </pre>
                </div>
            </div>




        </form>
    </div>
</body>
<script>
    window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
        mode: taal,
        matchBrackets: true,
        styleActiveLine: true,
        theme: "dracula",
        lineNumbers: true,
        indentWithTabs: true,
    });

    function getLanguage() {
        var taal = document.querySelector('input[name="language"]').value;
        console.log(taal);
        window.editor.setOption('mode', taal);
        console.log(window.editor)
    }

    var taal = getLanguage();
</script>

<script src="main.js"></script>

</html>