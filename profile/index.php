<?php
    //Uruchomienie sesji
    session_start();
    //Przekierowanie niezalogowanych
    if (!isset($_SESSION['log'])) {
        header("Refresh:0, url=/bookshop/login");
    }
    //Połączenie z bazą danych
    $connection = mysqli_connect("127.0.0.1","root",""); //Informacje identyfikujące bazę danych
    mysqli_select_db($connection,"kup_book");
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
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>

    <main id="profile">
        <header>
            <?php
                $user_id = $_SESSION['log'];
                $email = mysqli_fetch_array(mysqli_query($connection, "SELECT email FROM users WHERE id = '$user_id';"))[0];
                echo ("<h2>Witaj, $email</h2>");
            ?>
        </header>
        <section>
            <header>
                <h3>Twoje zamówienia</h3>
            </header>
            <?php
                //Wyświetlanie oczekujących zamówień użytkownika
                $pending = mysqli_query($connection, "SELECT id, total_price FROM orders WHERE user_id = '$user_id' AND status = 'pending' ORDER BY id DESC;");
                if (mysqli_num_rows($pending) == 0) {
                    echo ("<p>Brak oczekujących zamówień</p>");
                } else if (mysqli_num_rows($pending) <= 3 || isset($_GET['pending'])) {
                    echo ("<ul>");
                    while ($row = mysqli_fetch_array($pending)) {
                        echo ("<li> #$row[id] - $row[total_price] zł (oczekujące)</li>");
                    }
                    echo ("</ul>");
                } else {
                    //Logika wyświetlania wszystkich po kliknięciu przycisku
                    $pending = mysqli_query($connection, "SELECT id, total_price FROM orders WHERE user_id = '$user_id' AND status = 'pending' ORDER BY id DESC LIMIT 3;");
                    echo ("<ul>");
                    while ($row = mysqli_fetch_array($pending)) {
                        echo ("<li> #$row[id] - $row[total_price] zł (oczekujące)</li>");
                    }
                    echo ("</ul>");
                    echo ("<form>");
                        echo ("<button name='pending' id='pending'>VV Zobacz wszystkie VV</button>");
                    echo ("</form>");
                }
            ?>
        </section>
        <section>
            <header>
                <h3>Twoje książki</h3>
            </header>
            <?php
                //Wyświetlanie opłaconych zamówień - książek, które zostały zakupione i można je pobrać
                $query = mysqli_query($connection,"SELECT books.id AS book_id, books.title, books.cover 
                        FROM orders
                        JOIN order_items ON orders.id = order_items.order_id
                        JOIN books ON order_items.book_id = books.id
                        WHERE orders.user_id = '$user_id' AND orders.status = 'paid';");

                if (mysqli_num_rows($query) == 0) {
                    echo ("<p>Brak posiadanych książek</p>");
                } else {
                    $all_books = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    $total_books = count($all_books);

                    $limit = 2;
                    $show_all = isset($_GET['paid']) || $total_books <= $limit;
                    $books_to_show = $show_all ? $all_books : array_slice($all_books, 0, $limit);

                    echo ("<ol>");
                    foreach ($books_to_show as $book) {

                        echo ("<li>");
                            echo ("<img src='$book[cover]' alt='$book[title]'>");
                            echo ("<strong>$book[title]</strong>");
                            echo ("<form action='/bookshop/components/download.php' method='POST'>");
                                echo ("<button class='download' name='book_id' value='$book[book_id]'>Pobierz E-book</button>");
                            echo ("</form>");
                        echo ("</li>");
                    }
                    echo ("</ol>");
                    //Logika wyświetlania wszystkich produktów po kliknięciu przycisku
                    if (!$show_all) {
                        echo ("<form method='GET' class='show_all'>");
                            echo ("<button name='paid' id='paid'>VV Zobacz wszystkie VV</button>");
                        echo ("</form>");
                    }
                }
            ?>
            <form action="/bookshop/components/logout.php" id="profile_log_out">
                <button type="submit">Wyloguj się</button>
            </form>
        </section>
    </main>

    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php"); //Ścieżka identyfikująca potrzebne komponenty
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>