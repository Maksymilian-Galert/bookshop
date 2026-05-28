<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    if (isset($_GET['add_to_cart'])) {
        $add_to_cart = intval($_GET['add_to_cart']);
        $user_id = intval($_SESSION['log']);
        $check_cart = mysqli_query($connection,"SELECT book_id FROM cart WHERE user_id = $user_id AND book_id = $add_to_cart;");
        if (!mysqli_num_rows($check_cart)) {
            $check_order = mysqli_query($connection, "SELECT order_items.book_id FROM order_items INNER JOIN orders ON orders.id = order_items.order_id WHERE orders.user_id = $user_id AND order_items.book_id = $add_to_cart;");
            if (!mysqli_num_rows($check_order)) {
                mysqli_query($connection, "INSERT INTO cart (book_id, user_id) VALUES ('$add_to_cart', '$user_id');");
            }
        }
        header("Refresh:0; url=/bookshop/cart");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
    <link rel="stylesheet" href="/bookshop/style/book_style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>

    <?php
        if (!isset($_GET['book_name'])) {
            exit();
        }
        $id = $_GET['book_name'];
        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT title, author, description, price, cover FROM books WHERE id = $id;"));
    ?>

    <div id="the_book">
        <figure>
            <?php
                echo ("<img src='$data[cover]' alt='$data[title]'>");
            ?>
        </figure>
        <div>
            <?php
                echo ("<h2>$data[title]</h2>");
                echo ("<em>Autor: $data[author]</em>");
            ?>
            <strong>Opis:</strong>
            <?php
                echo ("<p>$data[description]</p>");
                echo ("<em>Cena: $data[price] zł</em>");
                if (isset($_SESSION["log"])) {
                    echo ("<form>");
                    echo ("<button type='submit' name='add_to_cart' class='book_site' value='$id'>Dodaj do koszyka</button>");
                    echo ("</form>");
                } else {
                    echo ("<form action='/bookshop/login'>");
                    echo ("<input type='submit' class='book_site' value='Zaloguj się'>");
                    echo ("</form>");
                }
            ?>
        </div>
    </div>


    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>