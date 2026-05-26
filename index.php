<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    if (isset($_GET['add_to_cart'])) {
        $add_to_cart = intval($_GET['add_to_cart']);
        $user_id = intval($_SESSION['log']);
        $check_cart = mysqli_query($connection,"SELECT book_id FROM cart WHERE user_id = $user_id AND book_id = $add_to_cart;");
        if (!$check_cart) {
            mysqli_query($connection, "INSERT INTO cart (book_id, user_id) VALUES ('$add_to_cart', '$user_id');");
        }
    }
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
                        $title = mysqli_fetch_array(mysqli_query($connection,"SELECT title FROM books WHERE id = $i"));
                        $author = mysqli_fetch_array(mysqli_query($connection,"SELECT author FROM books WHERE id = $i"));
                        $cover = mysqli_fetch_array(mysqli_query($connection,"SELECT cover FROM books WHERE id = $i"));
                        
                        echo ("<div>");
                        echo ("<a href='/bookshop/book?book_name=".$i."'>");
                        echo ("<figure><img src='".$cover['cover']."' alt='".$title['title']."'></figure>");
                        echo ("<strong>".$title['title']."</strong>");
                        echo ("<em>".$author['author']."</em>");
                        echo ("</a>");
                        if (isset($_SESSION["log"])) {
                            echo ("<form>");
                            echo ("<button type='submit' name='add_to_cart' class='book_site' value='$i'>Dodaj do koszyka</button>");
                            echo ("</form>");
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
        mysqli_close($connection);
    ?>
</body>
</html>