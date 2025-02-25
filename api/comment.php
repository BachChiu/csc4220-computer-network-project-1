<?php
    if($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        $username = $_POST['username'];
        $comment = $_POST['comment'];
        $host = getenv('POSTGRES_HOST');
        $port = 6543;
        $database = getenv('POSTGRES_DATABASE');
        $user= getenv('POSTGRES_USER');
        $pass=  getenv('POSTGRES_PASSWORD');
        $sslmode = 'sslmode=require'; 
        $dsn = "pgsql:host=$host;port=$port;dbname=$database;$sslmode";
        try
        {
            $pdo = new PDO($dsn, $user, $pass,
            [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
        catch (PDOException $e)
        {
            die("Database connection failed: " . $e->getMessage());
        }
        $sql = "INSERT INTO comments(userName, comment) VALUES (:userName, :comment)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':userName', $username);
        $statement->bindParam(":comment", $comment);
        $statement->execute();
    }
?>
<html>
    <head>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-S304PTWPM6"></script>
        <script>
            function onSubmit(token) {
                document.getElementById("demo-form").submit();
            } 
        </script>
        <script src="https://www.google.com/recaptcha/enterprise.js?render=6Ld1Rd0qAAAAAIHevIPXL-5ZGODuUNGgOawpFlFn&badge=bottomright">
        </script>
	
        <meta charset="utf-8">
        <meta name="viewpoint" content="width=device-width, initial-scale=1">
        <title>Computer Network Project</title>
        <style>
            body {background-color:royalblue; display:block; margin-left:auto; margin-right:auto; width:100%;
			color:white;}
			h1 {text-align: center;}
			img {width:60%; display:block; margin-left:auto; margin-right:auto;}
			a:visited {color: yellow; margin:auto;}
			p {text-align:center; width:100%;}
            td{border: 1px solid black; padding:5 px;}
            table{ width: 100%; min-height:100%; display:block;}
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td>
                    <form id="commentForm" action="comment.php" method="POST">
                        <label for="username">Name:</label><br>
                        <input type="text" id="username" name="username"><br>
                        <label for="comment">Comments:</label><br>
                        <input type="text" id="comment" name="comment"><br>
                        <button type="submit">Submit</button>
                    </form>
                </td>
                <td>
                    <?php
                        $host = getenv('POSTGRES_HOST');
                        $database = getenv('POSTGRES_DATABASE');
                        $user= getenv('POSTGRES_USER');
                        $pass=  getenv('POSTGRES_PASSWORD');
                        $dsn = "pgsql:host={$host};dbname={$database};";
                        try
                        {
                            $pdo = new PDO($dsn, $user, $pass,
                            [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                            ]);
                        }
                        catch (PDOException $e)
                        {
                            die("Database connection failed: " . $e->getMessage());
                        }
                        $sql = "SELECT * FROM public.comments";
                        $statement = $pdo->prepare($sql);
                        $statement->execute();
                        $comments = $statement->fetchAll();
                        foreach($comments as $comment)
                        {
                            echo "<li>User:" . $comment['userName'] . "<br>\t" . $comment['comment'] . "</li><br>";
                        }
                    ?>
                </td>
            </tr>
        </table>
    </body>