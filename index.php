<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/ksiegarnia/style/style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/ksiegarnia/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/ksiegarnia/components/nav.php");
    ?>
    <main>
        <section id="bestselery">
            <header>
                <h3>Bestselery</h3>
            </header>
            <?php
                $servername = '127.0.0.1';
                $username = "root";
                $password = "";
                $dbname = "kup_book";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    for ($i = 1 ; $i <= 3; $i++) {
                        $title = $conn->query("SELECT title FROM books WHERE id = $i");
                        $title = $title->fetch();
                        $author = $conn->query("SELECT author FROM books WHERE id = $i");
                        $author = $author->fetch();
                        $cover = $conn->query("SELECT cover FROM books WHERE id = $i");
                        $cover = $cover->fetch();
                        
                        echo ("<div>");
                        echo ("<figure><img src='".$cover['cover']."' alt='".$title['title']."'></figure>");
                        echo ("<strong>".$title['title']."</strong>");
                        echo ("<em>".$author['author']."</em>");
                        echo ("<input type='button' class='book_site' value='Zobacz książkę'>");
                        echo ("</div>");
                    }
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            ?>
        </section>
    </main>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/ksiegarnia/components/footer.php");
    ?>
    <?php
        $conn = null;
    ?>
</body>
</html>