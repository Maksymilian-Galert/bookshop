<?php
    session_start();
    if (!isset($_SESSION['log'])) {
        header("Refresh: 0, url=/bookshop/profile");
    }

    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");

    $user_id = $_SESSION['log'];
    $role = mysqli_fetch_array(mysqli_query($connection, "SELECT role FROM users WHERE id = '$user_id';"))['role'];

    if ($role !== 'admin') {
        header("Refresh: 0, url=/bookshop/profile");
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
    <link rel="stylesheet" href="/bookshop/style/admin_style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    
    <div id="admin">
        <?php
            $email = mysqli_fetch_array(mysqli_query($connection, "SELECT email FROM users WHERE id = '$user_id';"))['email'];
            echo ("<h2>Witaj, $email</h2>");
        ?>
        <?php
            if (isset($_GET['set_paid'])) {
                $order_id = $_GET['set_paid'];
                if (mysqli_query($connection, "UPDATE orders SET status = 'paid' WHERE id = $order_id;")) {
                    echo ("<strong>Zamówienie #$order_id zostało zatwierdzone</strong>");
                }

            }
        ?>
        <section>
            <h3>Oczekujące zamówienia:</h3>
            <?php
                $zamowienia = mysqli_query($connection, "SELECT orders.id, orders.status, orders.total_price, users.email FROM orders INNER JOIN users ON orders.user_id = users.id WHERE orders.status = 'pending';");
                if (mysqli_num_rows($zamowienia) == 0) {
                    echo ("<p>Brak oczekujących zamówień</p>");
                } else {
                    echo ("<ul>");
                    echo ("<form>");
                    while ($row = mysqli_fetch_array($zamowienia)) {
                        echo ("<li>");
                            echo ("<span>#$row[id]</span>");
                            echo ("<span>-</span>");
                            echo ("<span>$row[email]</span>");
                            echo ("<span>-</span>");
                            echo ("<span>$row[total_price] zł</span>");
                            echo ("<button type='submit' name='set_paid' value='$row[id]'>Zatwierdź zamówienie</button>");
                        echo ("</li>");
                    }
                    echo ("</form>");
                    echo ("</ul>");
                }
            ?>
        </section>
    </div>

    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>