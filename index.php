<?php
    //Uruchomienie sesji
    session_start();
    //Połączenie z bazą danych
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");
    //Logika dodania produktu do koszyka
    if (isset($_GET['add_to_cart'])) {
        $add_to_cart = intval($_GET['add_to_cart']);
        if (!isset($_SESSION['log'])) {
            //Przekierowanie niezalogowanych użytkowników
            header("Refresh:0; url=/bookshop/login");
        }
        $user_id = intval($_SESSION['log']);
        $check_cart = mysqli_query($connection,"SELECT book_id FROM cart WHERE user_id = $user_id AND book_id = $add_to_cart;");
        if (!mysqli_num_rows($check_cart)) {
            $check_order = mysqli_query($connection, "SELECT order_items.book_id FROM order_items INNER JOIN orders ON orders.id = order_items.order_id WHERE orders.user_id = $user_id AND order_items.book_id = $add_to_cart;");
            if (!mysqli_num_rows($check_order)) {
            //Logika dodania produktu do koszyka
                mysqli_query($connection, "INSERT INTO cart (book_id, user_id) VALUES ('$add_to_cart', '$user_id');");
                header("Refresh:0; url=/bookshop/cart");
            } else {
                //Zapobieganie przed dodanie do koszyka kupionego już wcześniej produktu
                header("Refresh:0; url=/bookshop/cart?bought=kupiony");
            }
        } else {
            //Zapobieganie przed dodaniem do koszyka produktu będącego w koszyku
            header("Refresh:0; url=/bookshop/cart?bought=koszyk");
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
                    //Wyświetlenie trzech najlepiej sprzedających się książek
                    $order_of_bestsellers = mysqli_query($connection, "SELECT book_id FROM order_items GROUP BY book_id ORDER BY COUNT(id) DESC LIMIT 3;");
                    $order_of_bestsellers = mysqli_fetch_all($order_of_bestsellers, MYSQLI_ASSOC);
                    foreach ($order_of_bestsellers as $i) {
                        $query = mysqli_fetch_array(mysqli_query($connection, "SELECT title, author, cover FROM books WHERE id = $i[book_id];"));

                        echo ("<div>");
                        echo ("<a href='/bookshop/book?book_name=".$i['book_id']."'>");
                        echo ("<figure><img src='".$query['cover']."' alt='".$query['title']."'></figure>");
                        echo ("<strong>".$query['title']."</strong>");
                        echo ("<em>".$query['author']."</em>");
                        echo ("</a>");
                        if (isset($_SESSION["log"])) {
                            echo ("<form>");
                            echo ("<button type='submit' name='add_to_cart' class='book_site' value='$i[book_id]'>Dodaj do koszyka</button>");
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
            <section id="najnowsze">
                <header>
                    <h3>Nowości</h3>
                </header>
                <?php
                    //Wyświetlenie książek o największym ID (najnowszych)
                    $order_of_new_ones = mysqli_query($connection, "SELECT id as 'book_id' FROM books ORDER BY book_id DESC LIMIT 3;");
                    $order_of_new_ones = mysqli_fetch_all($order_of_new_ones, MYSQLI_ASSOC);
                    foreach ($order_of_new_ones as $i) {
                        $query = mysqli_fetch_array(mysqli_query($connection, "SELECT title, author, cover FROM books WHERE id = $i[book_id];"));

                        echo ("<div>");
                        echo ("<a href='/bookshop/book?book_name=".$i['book_id']."'>");
                        echo ("<figure><img src='".$query['cover']."' alt='".$query['title']."'></figure>");
                        echo ("<strong>".$query['title']."</strong>");
                        echo ("<em>".$query['author']."</em>");
                        echo ("</a>");
                        if (isset($_SESSION["log"])) {
                            echo ("<form>");
                            echo ("<button type='submit' name='add_to_cart' class='book_site' value='$i[book_id]'>Dodaj do koszyka</button>");
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
            <section id="our_offer">
                <header>
                    <h3>Nasza oferta</h3>
                </header>
                <?php
                    //Wyświetlenie książek o najmniejszym ID (te najstarsze - stała oferta)
                    $order_of_our_offer = mysqli_query($connection, "SELECT id as 'book_id' FROM books ORDER BY book_id ASC LIMIT 3;");
                    $order_of_our_offer = mysqli_fetch_all($order_of_our_offer, MYSQLI_ASSOC);
                    foreach ($order_of_our_offer as $i) {
                        $query = mysqli_fetch_array(mysqli_query($connection, "SELECT title, author, cover FROM books WHERE id = $i[book_id];"));

                        echo ("<div>");
                        echo ("<a href='/bookshop/book?book_name=".$i['book_id']."'>");
                        echo ("<figure><img src='".$query['cover']."' alt='".$query['title']."'></figure>");
                        echo ("<strong>".$query['title']."</strong>");
                        echo ("<em>".$query['author']."</em>");
                        echo ("</a>");
                        if (isset($_SESSION["log"])) {
                            echo ("<form>");
                            echo ("<button type='submit' name='add_to_cart' class='book_site' value='$i[book_id]'>Dodaj do koszyka</button>");
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