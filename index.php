<?php
    require_once("./connection.php");

    if(isset($_GET["method"]) && $_GET["method"] == "delete" &&
        isset($_GET["id"])) {
        $id = $_GET["id"];
        
        $sql = "DELETE FROM articles WHERE id = ?";
        $st = $conn->prepare($sql);
        if($st->execute(array($id))) {
            header("Location: index.php");
        }
    }

    $sql = "SELECT * FROM articles";
    $st = $conn->prepare($sql);
    if($st->execute()) {
        $articles = $st->fetchAll();
    } else $articles = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD</title>
</head>
<body>
    <a href="./article.php">Create a New Article</a>
    <table>
        <thead>
            <tr>
                <td>Title</td>
                <td>Content</td>
                <td>Date</td>
                <td>Operations</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($articles as $article) {
                    $id = $article["id"];
                    $title = $article["title"];
                    $content = $article["content"];
                    $date_created = $article["date_created"];
            ?>
                <tr>
                    <td><?= $title ?></td>
                    <td class="content"><?= $content ?></td>
                    <td><?= $date_created ?></td>
                    <td>
                        <a href="./article.php?id=<?= $id ?>">Edit</a>
                        <a href="./index.php?method=delete&id=<?= $id ?>">Delete</a>
                    </td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</body>
</html>