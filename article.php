<?php
    require_once("./connection.php");

    $id = "";
    $title = "";
    $content = "";
    $editing = false;

    if(isset($_POST["submit"]) && empty($_POST["id"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $date_created = date("Y-m-d H:i:s");

        $sql = "INSERT INTO articles (title, content, date_created)
            VALUES (?, ?, ?)";
        $st = $conn->prepare($sql);
        $st->execute(array($title, $content, $date_created));
    } else if(isset($_POST["submit"]) && !empty($_POST["id"])) {
        $editing = false;

        $id = $_POST["id"];
        $title = $_POST["title"];
        $content = $_POST["content"];
        
        $sql = "UPDATE articles SET title = ?, content = ? WHERE id = ?";
        $st = $conn->prepare($sql);
        if($st->execute(array($title, $content, $id))) {
            // echo "Success!!!";
        }
    } else {
        if(isset($_GET["id"])) {
            $editing = true;

            $id = $_GET["id"];
            
            $sql = "SELECT * FROM articles WHERE id = ?";
            $st = $conn->prepare($sql);
            if($st->execute(array($id))) {
                $row = $st->fetch();
                $id = $row["id"];
                $title = $row["title"];
                $content = $row["content"];
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?= !$editing ? "Create Article" : "Edit Article" ?></title>
</head>
<body>
    <form action="./article.php" method="post">
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?= $title ?>">
        </div>
        <div>
            <label for="title">Title</label>
            <textarea name="content" id="content" cols="30" rows="5"><?= $content ?></textarea>
        </div>
        <?php
            if($editing) {
        ?>
            <input type="hidden" name="id" value="<?= $id ?>">
        <?php
            }
        ?>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>
</html>