<?php
    session_start();
    $connection = mysqli_connect("127.0.0.1","root","");
    mysqli_select_db($connection,"kup_book");

    if (isset($_POST['book_id'])) {
        
        $query = mysqli_fetch_array(mysqli_query($connection, "SELECT file_path FROM books WHERE id = '$_POST[book_id]'"))['file_path'];

        $file = 'C:\xampp\htdocs\bookshop\books\\'.$query;

        if(!file_exists($file)){ // file does not exist
            die('file not found');
        } else {
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$file");
            header("Content-Type: application/zip");
            header("Content-Transfer-Encoding: binary");

            // read the file from disk
            readfile($file);
        }

    }

    mysqli_close();
?>