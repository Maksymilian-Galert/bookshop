<?php
    //Uruchomienie sesji
    session_start();
    //Usunięcie sesji
    session_destroy();
    //Przekierowanie na stronę główną
    header("Refresh:0; url=/bookshop");
    exit();
?>