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

    <?php
        $id = $_GET['book_name'];
        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT title, author, description, price, cover FROM books WHERE id = $id;"));
    ?>

    <div id="the_book">
        
    </div>


    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>