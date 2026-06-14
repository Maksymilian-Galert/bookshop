<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
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
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/header.php");
    ?>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/nav.php");
    ?>
    <main id="main_search">
        <?php
            if (!isset($_GET['search'])) {
                header("Refresh: 0, url=/bookshop/search/?search=Wyszukaj");
            } else {
                $search = $_GET['search'];
                if ($search == '') {
                    header("Refresh: 0, url=/bookshop/search/?search=Wyszukaj");
                }
                if ($search == "Wyszukaj") {
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books;");
                    $wynik = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    echo ("<header><h2>Wszystkie książki w katalogu</h2></header>");
                } else {
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books WHERE title LIKE '%$search%';");
                    $wynik = mysqli_fetch_all($query, MYSQLI_ASSOC);
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books WHERE author LIKE '%$search%';");
                    $wynik = array_merge($wynik, mysqli_fetch_all($query, MYSQLI_ASSOC));
                    $query = mysqli_query($connection,"SELECT id, title, author, price, cover FROM books WHERE description LIKE '%$search%';");
                    $wynik = array_merge($wynik, mysqli_fetch_all($query, MYSQLI_ASSOC));
                    echo ("<header><h2>Wyniki wyszukania po frazie: $search</h2></header>");
                }

                foreach ($wynik as $row) {
                    echo ("<a href='/bookshop/book/?book_name=$row[id]'>");
                        echo ("<div>");
                            echo ("<img src='$row[cover]' alt='$row[title]'>");
                            echo ("<strong>$row[title]</strong>");
                            echo ("<em>$row[author]</em>");
                            echo ("<span>$row[price]</span>");
                        echo ("</div>");
                    echo ("</a>");
                }
            }
        ?>
    </main>
    <?php
        require ($_SERVER['DOCUMENT_ROOT']."/bookshop/components/footer.php");
    ?>
    <?php
        mysqli_close($connection);
    ?>
</body>
</html>