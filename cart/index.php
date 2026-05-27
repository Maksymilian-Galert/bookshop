<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    if (!isset($_SESSION['log'])) {
        header("Refresh:0, url=/bookshop/login");
    } else {
        $user_id = $_SESSION['log'];
        if (isset($_GET['delete'])) {
            $book_id = $_GET['delete'];
            mysqli_query($connection, "DELETE FROM cart WHERE user_id = $user_id AND book_id = $book_id");
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
    <link rel="stylesheet" href="/bookshop/style/cart_style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    
    <div id="cart">
        <?php
            $query = mysqli_query($connection, "SELECT id, book_id FROM cart WHERE user_id = $user_id;");
            if (mysqli_num_rows($query) == 0){
                echo ("Brak przedmiotów w koszyku");
            } else {
                while ($row = mysqli_fetch_array($query)) {
                    echo ("<div>");
                        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT title, author, price, cover FROM books WHERE id = $row[book_id];"));
                        echo ("<figure><img src='$data[cover]' alt='$data[title]'></figure>");
                        echo ("<div>");
                        echo ("<div>");
                            echo ("<strong>$data[title]</strong><br>");
                            echo ("<em>$data[author]</em>");
                        echo ("</div>");
                        echo ("</div>");
                        echo ("<div>");
                            echo ("<em>$data[price] zł</em>");
                        echo ("</div>");
                        echo ("<form>");
                        echo ("<button type='submit' name='delete' value='$row[book_id]'>&#10006;USUŃ</button>");
                        echo ("</form>");
                    echo ("</div>");
                }
            }
        ?>
        <div>
            <div></div>
            <div><strong>Suma: </strong></div>
            <?php
                $query = mysqli_query($connection, "SELECT id, book_id FROM cart WHERE user_id = $user_id;");
                $suma = 0;
                if (mysqli_num_rows($query) == 0){
                    $suma = 0;
                } else {
                    while ($row = mysqli_fetch_array($query)) {
                        $data = mysqli_fetch_array(mysqli_query($connection,"SELECT price FROM books WHERE id = $row[book_id];"));
                        $suma += (float)$data['price'];
                    }
                }
                echo ("<div><em>$suma zł</em></div>");
            ?>
            <form action="/bookshop/components/buying.php">
                <button id="buy_every" name="buy_every">KUP WSZYSTKO</button>
            </form>
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