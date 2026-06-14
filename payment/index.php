<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    if (!isset($_GET['buy_every'])) {
        header("Refresh: 0, url=/bookshop/cart");
    } else {
        if (!isset($_SESSION['log'])) {
            header("Refresh: 0, url=/bookshop/login");
        }
        $user_id = $_SESSION['log'];
        $orders = mysqli_fetch_array(mysqli_query($connection,"SELECT id FROM orders WHERE user_id = '$user_id' AND status = 'pending' AND total_price = '$_GET[buy_every]' ORDER BY id DESC;"))[0];
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>KUP BOOK</title>
    <link rel="stylesheet" href="/bookshop/style/style.css">
    <link rel="stylesheet" href="/bookshop/style/payment_style.css">
</head>
<body>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    <div id="payment">
        <h2>Złożono zamówienie</h2>
        <strong>Przelej pieniądze na numer konta:</strong>
        <em>xxxx-xxxx-xxxx-xxxx-xxxx</em>
        <strong>Tytuł przelewu:</strong>
        <?php
            echo ("<em>order_number_$orders</em>");
        ?>
        <strong>Kwota przelewu to:</strong>
        <?php
            echo ("<em>$_GET[buy_every] zł</em>");
        ?>
        <p>Czas oczekiwania na potwierdzenie zamówienia wynosi 1-3 dni.</p>
        <a href="/bookshop">Powrót na stronę główną</a>
    </div>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>