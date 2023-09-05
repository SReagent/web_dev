<?php
session_start();
include_once "connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookPage</title>

  <link rel="stylesheet" href="../CSS/bookpage_style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
//hghhyhyhy

<body>
  <div class="banner">
    <div id="navbar" class="navbar">
      <h4 id="Logo" class="Logo">BIBLION</h4>
      <div class="Links">
        <ul>
          <li><a href="Biblion.php">HOME</a></li>
          <li><a href="Rent.php">RENT</a></li>
        </ul>
      </div>
      <div class="search-container">
        <input type="text" class="searchbar" id="live_search" autocomplete="off" placeholder="Looking for something">
        <div class="search-result-container" id="searchresult"></div>
      </div>
      <div class="buttons">
        <div class="cta">
          <?php if (isset($_SESSION['loggedIn'])) : ?>
            <a href=""><button><img src="../images/logout.png"></button></a>
          <?php else : ?>
            <a href="SignIn.php"><button onclick="signOut()"><img src="../images/user-3-fill.png"></button></a>
          <?php endif; ?>
        </div>
        <div class="cta">
          <?php if (isset($_SESSION['loggedIn'])) : ?>
            <a href="cart.php"> <button type="button"><img src="../images/shopping-cart3.png"></button></a>
          <?php else : ?>
            <a href="SignIn.php"> <button type="button"><img src="../images/shopping-cart3.png"></button></a>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="container1">
      <?php
      $bookId = (string)$_GET['id'];
      $select = "Select * from books where Book_ID = '$bookId'";
      $result = mysqli_query($con, $select);
      $book = $result->fetch_assoc();
      $title = $book['Title'];
      $price = $book['Prices'];
      echo "
        <div class='book'>

          <div class='pic'>
          <img src='data:image/png;base64," . base64_encode($book['Book_Image']) . "' alt='Image {$book['Book_ID']}'>
          </div>

          <div class = 'details'>

            <div class = 'price-main__heading'>" . $book['Title'] . " </div>
            <div class = 'Author'>" . $book['Author'] . " </div>
            <div class = 'price-txt'>" . $book['Book_Description'] . "</div>
            
            <div class='price-box'>
              <div class='price-box__main'>
                <span class='price-box__main-new'>&#x20B9 $price.00</span>
                <div class='price-btnbox'>
              <div class='price-btns'>
                <button class='price-btn__add price-btn' onclick = 'addQuantity()'>
                  <img src='../images/icon-plus.png' alt='plus sig' class='price-btn_add-img price-btn_img' />
                </button>
                <span id='price-btn_txt' class='price-btn_txt'> 0 </span>
                <button class='price-btn__remove price-btn' onclick = 'removeQuantity()'>
                  <img src='../images/icon-minus.png' alt='minus sign' class='price-btn_remove-img price-btn_img' />
                </button>
                <form method='POST' action='add_to_cart.php'>
                  <input type='hidden' name='Book_ID' value='{$bookId}'>
                  <input type='hidden' id='quantity' name='Quantity' value='0'>
                  <button type='button'>
                    <img src='../images/shopping-cart3.png' onclick='openWrong(\"{$bookId}\")'>
                  </button>
                </form>
              </div>
            </div>
          </div>
         </div>
          </div>
        </div>
      <div class='popup' id='popup'>
        <img src='../images/check.png'>
        <p class = 'popup-message' id='popup-message'></p>
        <button type='button' onclick='closePopup()'>Okay</button>
      </div>";
      ?>
    </div>

    <div class='free'>
      <h2>
        <center>Free Preview</center>
      </h2>
    </div>


    <div class='container'>
      <?php
      require '../vendor/autoload.php';
      include_once 'connect.php';

      $bookid = (string)$_GET['id'];
      $query = "SELECT Content FROM books WHERE Book_ID = '$bookid'";
      $result = mysqli_query($con, $query);
      $book = $result->fetch_assoc();

      // Write the BLOB data to a temporary file
      $tmpfile = tempnam(sys_get_temp_dir(), 'pdf');
      file_put_contents($tmpfile, $book['Content']);

      // Execute pdftotext on the temporary file
      $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w")   // stderr is a pipe that the child will write to
      );

      $command = "pdftotext -layout -q -enc UTF-8 -nopgbrk -eol unix " . escapeshellarg($tmpfile) . " -";
      $process = proc_open($command, $descriptorspec, $pipes);
      if (is_resource($process)) {
        $content = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $return_value = proc_close($process);
      }

      // Delete the temporary file
      unlink($tmpfile);
      ?>


      <div class='pdf-content'>
        <?php if ($content !== null && strlen($content) > 0) echo nl2br(htmlentities($content)); ?>
      </div>
    </div>


    <script>
      function addToCart(bookId, quantity) {

        // Send an AJAX request to the server to add the book to the cart
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../BackEnd/add_to_cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            // Show the success message
            let img = document.querySelector("#popup img");
            let message = document.querySelector("#popup p");
            img.src = "../images/check.png";
            message.textContent = "ADDED TO CART";
            popup.classList.add("open-popup");
          } else {
            // Show the error message
            let img = document.querySelector("#popup img");
            let message = document.querySelector("#popup p");
            img.src = "../images/cancel-icon.png";
            message.textContent = "ITEM NOT ADDED";
            popup.classList.add("open-popup");
          }
        };
        {
          xhr.send(`Book_ID=${bookId}&Quantity=${quantity}`);
        }
      }


      function openWrong(bookId) {
        // Get the quantity from the page
        const quantity = parseInt(document.querySelector("#price-btn_txt").textContent);
        // Add the book to the cart if the quantity is greater than 0
        if (quantity > 0) {
          addToCart(bookId, quantity);
        } else {
          // Show the error message
          let img = document.querySelector("#popup img");
          let message = document.querySelector("#popup p");
          img.src = "../images/cancel-icon.png";
          message.textContent = "ITEM NOT ADDED";
          popup.classList.add("open-popup");
        }
      }

      function closePopup() {
        popup.classList.remove("open-popup");
      }

      let quantity_text = document.getElementById('price-btn_txt');
      console.log(quantity_text);
      let quantity = 0;

      function addQuantity() {
        quantity_text.innerHTML = ++quantity;
      }

      function removeQuantity() {
        if (quantity > 0)
          quantity_text.innerHTML = --quantity;
      }
    </script>



    <script type="text/javascript">
      $(document).ready(function() {
        $("#live_search").keyup(function() {
          var input = $(this).val();

          if (input != "") {
            $.ajax({
              url: "../BackEnd/live_search.php",
              method: "POST",
              data: {
                input: input
              },
              success: function(data) {
                $("#searchresult").html(data);
                $("#searchresult").css("display", "block");
              }
            });
          } else {
            $("#searchresult").css("display", "none");
          }
        });
        $(document).on("click", ".book-title", function() {
          var bookid = $(this).attr("id").replace("book", "");
          window.location.href = "bookpage.php?id=" + bookid.toString();
        });
      });

      signOut = () => {
        <?php
                unset($_SESSION['loggedIn']);
                unset($_SESSION['email']);
        ?>
      }
    </script>
    <div class="no-font-size">
      <?php include('footer.php') ?>
    </div>
</body>

</html>
