<?php
    //Uruchomienie sesji
    session_start();
    //Połączenie z bazą danych
    $connection = mysqli_connect("127.0.0.1","root",""); //Informacje identyfikujące bazę danych
    mysqli_select_db($connection,"kup_book");
    //Gdy nie kupuje się, użytkownik jest przekierowany do podstrony koszyka
    if (!isset($_GET['buy_every'])) {
        header("Refresh: 0, url=/bookshop/cart");
    } else {
        $user_id = $_SESSION['log'];
        $cart = mysqli_query($connection,"SELECT book_id FROM cart WHERE user_id = $user_id;");
        if (mysqli_num_rows($cart) == 0) {
            //Gdy nie kupuje się, użytkownik jest przekierowany do podstrony koszyka
            header("Refresh: 0, url=/bookshop/cart");
        } else {
            //Dodanie zakupionych produktów do zamówień
            mysqli_query($connection,"INSERT INTO orders (user_id, status, total_price) VALUES ('$user_id', 'pending', '$_GET[buy_every]');");
            $orders = mysqli_fetch_array(mysqli_query($connection,"SELECT id FROM orders WHERE user_id = '$user_id' AND status = 'pending' AND total_price = '$_GET[buy_every]' ORDER BY id DESC;"))[0];
            $orders = intval($orders);
            while ($row = mysqli_fetch_array($cart)) {
                $row = (float)($row['book_id']);
                mysqli_query($connection, "INSERT INTO order_items (order_id, book_id) VALUES ('$orders', '$row');");
                //Usunięcie produktów z koszyka
                mysqli_query($connection, "DELETE FROM cart WHERE user_id = $user_id AND book_id = $row;");
            }
        }
        header("Refresh: 0, url=/bookshop/payment?buy_every=$_GET[buy_every]");
    }


    mysqli_close($connection);
?>