<?php
include_once 'connect.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM books WHERE Title LIKE '{$input}%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $title = $row['Title'];
            $bookid = (string)$row['Book_ID'];
            $book_html = "<div class='book-title' id='book$bookid'>
                            $title  
                          </div>";
            echo $book_html;
            $counter++;
        }
    }
}
?>

<style>
    .book-title {
        font-size: 20px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 15px;
        font-family: sans-serif;
        cursor: pointer;
    }

    .book-title:hover {
        background-color: rgba(174, 180, 183, 0.67);
        color: black;
        cursor: pointer;
    }
</style>