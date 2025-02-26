<?php
    if($_SERVER["REQUEST_METHOD"] == 'POST')
    {
        $userName = $_POST['username'];
        $comment = $_POST['comment'];
        $host = getenv('userHost');
        $sqlname = getenv('sqlName');
        $password = getenv('sqlPass');
        $database = "csc4220_cn_project";
        $db= new mysqli($host, $sqlname, $password, $database);
        $sql ="INSERT INTO comments (userName, comment) VALUES (?,?)";
        $statement = $db->prepare($sql);
        $statement->bind_param("ss", $userName, $comment);
        $statement->execute();
        $db->close();
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
            td{border: 5px solid black; padding:5px;}
            div{width:100%; height:100%;}
            table{ min-width: 80%; min-height:80%; display:block; margin-left:auto; margin-right:auto;}
            tr{width:80%;}
            td{height:100%; width:50%;}
            #username{width:200px; height:50px;}
            #comment{width:200px; height:200px;}
        </style>
    </head>
    <body>
        <p style="font-family: Arial">
            <a style="color:yellow; " href="https://docs.google.com/document/d/1o90Jns_h1BZpeGGXSSQIqtbhgEW3HwPUMOoVRHx8ch4/edit?usp=sharing">Computer Network Project Report</a>
            <br><br>
            <a style="color:yellow;" href="https://csc4220-computer-network-project-1.vercel.app">Back to main page</a>
		</p>
        <div>
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
                    <h2>Comment List:</h2>
                    <br><br>
                    <?php
                        $host = getenv('userHost');
                        $sqlname = getenv('sqlName');
                        $password = getenv('sqlPass');
                        $database = "csc4220_cn_project";
                        $db= new mysqli($host, $sqlname, $password, $database);
                        $sql ="SELECT userName, comment from comments";
                        $comments= $db->query($sql);
                        while($comment = $comments->fetch_assoc())
                        {
                            echo "<li>User:" . $comment['userName'] . "<br>\t" . $comment['comment'] . "</li><br>";
                        }
                    ?>
                </td>
            </tr>
        </table>
        </div>
    </body>
</html>