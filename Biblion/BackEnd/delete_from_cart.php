<?php
include_once'connect.php';
$book_id =$_POST['Book_ID'];

$stmt = $con->prepare("DELETE FROM cart WHERE Book_id = ?");
$stmt->bind_param('s', $book_id);
if (!$stmt->execute()) {
  die('Error inserting data into database: ' . $stmt->error);
}

  $stmt->close();
  $con->close();

exit();
?>