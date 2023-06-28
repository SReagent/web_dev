<?php
// Include the database connection code
include_once'connect.php';

// Get the book ID and quantity from the form data

$book_id =$_POST['Book_ID'];
$quantity = $_POST['Quantity'];

// Insert the book ID and quantity into the cart table
$stmt = $con->prepare("INSERT INTO cart (Book_id, Quantity) VALUES (?, ?) ON DUPLICATE KEY UPDATE Quantity = Quantity + ?");
$stmt->bind_param('sii', $book_id, $quantity,$quantity);
if (!$stmt->execute()) {
  die('Error inserting data into database: ' . $stmt->error);
}
  // Close the database connection
  $stmt->close();
  $con->close();

// Redirect the user back to the original page with a success message
header('Location: ' . $_SERVER['PHP_SELF'] . '?success=1');
exit();
?>