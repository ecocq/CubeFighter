<html>
    <head>
        <title>Deconnexion</title>
        <meta charset="utf-8" />
    </head>
    <body>

        <?php
            session_start();
            session_destroy();
            header("location:index.php");
        ?>
    </body>
</html>
