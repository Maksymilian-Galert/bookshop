<?php
    //Podłączenie bazy danych
    $connection = mysqli_connect("127.0.0.1","root",""); //Informacje identyfikujące bazę danych
    mysqli_select_db($connection,"kup_book");

    // Definiowanie zmiennych
    $search = $_GET['search'];
    $authors = isset($_GET['choose_author']) ? $_GET['choose_author'] : [];
    $sorting = isset($_GET['choose_sorting']) ? $_GET['choose_sorting'] : 'sel';
    $min_price = isset($_GET['minimal_price']) && $_GET['minimal_price'] !== '' ? (float)$_GET['minimal_price'] : 0;
    $max_price = isset($_GET['maximal_price']) && $_GET['maximal_price'] !== '' ? (float)$_GET['maximal_price'] : 999999;

    // Podstawowe zapytanie do wyszukiwania (które później jest edytowane)
    if ($search == 'Wyszukaj') {
        $sql = "SELECT id, title, author, price, cover FROM books WHERE price BETWEEN $min_price AND $max_price";

    } else {
        $sql = "SELECT id, title, author, price, cover FROM books WHERE 
            (title LIKE '%$search%' OR author LIKE '%$search%' OR description LIKE '%$search%') 
            AND price BETWEEN $min_price AND $max_price";
    }

    // Dodanie do zapytania filtru sprawdzającego autorów
    if (!empty($authors)) {
        $escaped_authors = array_map(function($auth) use ($connection) {
            return "'" . mysqli_real_escape_string($connection, $auth) . "'";
        }, $authors);
        
        $author_list = implode(',', $escaped_authors);
        $sql .= " AND author IN ($author_list)";
    }

    // Dodanie do zapytania sortowania
    switch ($sorting) {
        Case 'price_low':
            $sql .= " ORDER BY price ASC";
            Break;
        Case 'price_high':
            $sql .= " ORDER BY price DESC";
            Break;
        Case 'new':
            $sql .= " ORDER BY id DESC";
            Break;
        Case 'old':
            $sql .= " ORDER BY id ASC";
            Break;
        Case 'az':
            $sql .= " ORDER BY title ASC";
            Break;
        Case 'za':
            $sql .= " ORDER BY title DESC";
            Break;
        Default:
            Break;
    }

    // Wykonanie zapytania
    $query = mysqli_query($connection, $sql);
    if ($query && mysqli_num_rows($query) > 0) {
        $wynik = mysqli_fetch_all($query, MYSQLI_ASSOC);

        // Wyświetlenie wyszukanych elementów
        foreach ($wynik as $row) {
            echo ("<a href='/bookshop/book/?book_name=$row[id]'>");
                echo ("<div>");
                    echo ("<img src='$row[cover]' alt='$row[title]'>");
                    echo ("<strong>$row[title]</strong>");
                    echo ("<em>$row[author]</em>");
                    echo ("<span>$row[price] zł</span>");
                echo ("</div>");
            echo ("</a>");
        }
    } else {
        echo ("<p>Brak wyników spełniających kryteria.</p>");
    }
?>