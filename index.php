<?php
    $servername = '127.0.0.1';
    $username = "root";
    $password = "";
    $dbname = "kup_book";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    <div>
        <main>
            <section id="bestselery">
                <header>
                    <h3>Bestselery</h3>
                </header>
                <?php
                    for ($i = 1 ; $i <= 3; $i++) {
                        $title = $conn->query("SELECT title FROM books WHERE id = $i")->fetch();
                        $author = $conn->query("SELECT author FROM books WHERE id = $i")->fetch();
                        $cover = $conn->query("SELECT cover FROM books WHERE id = $i")->fetch();
                        
                        echo ("<div>");
                        echo ("<a href='/bookshop/book?book_name=".$i."'>");
                        echo ("<figure><img src='".$cover['cover']."' alt='".$title['title']."'></figure>");
                        echo ("<strong>".$title['title']."</strong>");
                        echo ("<em>".$author['author']."</em>");
                        echo ("</a>");
                        if (isset($_SESSION["logged"])) {
                            echo ("<input type='submit' name='add_to_cart' class='book_site' value='Dodaj do koszyka'>");
                        } else {
                            echo ("<form action='/bookshop/login'>");
                            echo ("<input type='submit' class='book_site' value='Zaloguj się'>");
                            echo ("</form>");
                        }
                        echo ("</div>");
                    }
                ?>
            </section>
        </main>
    </div>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $conn = null;
    ?>
</body>
</html>