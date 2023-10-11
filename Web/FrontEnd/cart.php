<?php
include_once('../BackEnd/connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Shopping Cart</title>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="../CSS/cart_style.css">
</head>

<body>
  <div class="banner">
    <div id="navbar" class="navbar">
      <h4 id="Logo" class="Logo">BIBLION</h4>
      <div class="Links">
        <ul>
          <li><a href="../index.php">HOME</a></li>
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
          <a href="cart.php"> <button type="button"><img src="../images/shopping-cart3.png"></button></a>
        </div>
      </div>
    </div>

    <div class="Container">
      <main>
        <div class="basket">
          <div class="basket-module">
            <label for="promo-code">Enter a promotional code</label>
            <input id="promo-code" type="text" name="promo-code" maxlength="5" class="promo-code-field">
            <button type="button" class="promo-code-cta">Apply</button>
          </div>
          <div class="basket-labels">
            <ul>
              <li class="item-heading">
                <h2>Item</h2>
              </li>
              <li class="price-heading">
                <h2>Price</h2>
              </li>
              <li class="quantity-heading">
                <h2>Quantity</h2>
              </li>
              <li class="subtotal-heading">
                <h2>Subtotal</h2>
              </li>
            </ul>
          </div>

          <div class="basket-product-container">
            <?php
            $select_query = "Select * from books b , cart c where c.Book_ID = b.Book_ID";
            $result_query = mysqli_query($con, $select_query);
            while ($row = mysqli_fetch_assoc($result_query)) {
              $book_id = $row['Book_ID'];
              $book_title = $row['Title'];
              $book_author = $row['Author'];
              $book_image = $row['Book_Image'];
              $price = $row['Prices'];
              $quantity = $row['Quantity'];
              $subtotal = $price * $quantity;
              echo "
                  <div class='basket-product'>
                  <div class='item'>
                      <div class='product-image'>
                          <img src = 'data:image/png;base64," . base64_encode($book_image) . "' class='product-frame'>
                      </div>
                      <div class='product-details'>
                          <h2>$book_title</h2>
                          <p>$book_author</p>
                      </div>
                  </div>

                  <div class='price'>$price</div>

                  <div class='quantity'>
                      <input type='number' value= $quantity min='1' class='quantity-field' onkeydown = 'return false'>
                  </div>

                  <div class='subtotal'>$subtotal</div>

                  <div class='remove'>
                      <button type = 'button' data-bookid='$book_id'>Remove</button>
                  </div>
                  </div>";
            }
            ?>
          </div>
        </div>

        <aside>
          <div class="summary">
            <div class="summary-total-items"><span class="total-items"></span> Items in your Bag</div>
            <div class="summary-subtotal">
              <div class="subtotal-title">Subtotal</div>
              <div class="subtotal-value final-value" id="basket-subtotal">0.00</div>
              <div class="discount-title">Discount</div>
              <div class="discount-value" id="discount-value">0.00</div>
              <div class="summary-promo hide">
                <div class="promo-title">Promotion</div>
                <div class="promo-value final-value" id="basket-promo"></div>
              </div>
            </div>
            <div class="summary-delivery">
              <select name="delivery-collection" class="summary-delivery-selection">
                <option value="0" selected="selected">Select Collection or Delivery</option>
                <option value="collection">Collection</option>
                <option value="first-class">Royal Mail 1st Class</option>
                <option value="second-class">Royal Mail 2nd Class</option>
                <option value="signed-for">Royal Mail Special Delivery</option>
              </select>
            </div>
            <div class="summary-total">
              <div class="total-title">Total</div>
              <div class="total-value final-value" id="basket-total">0.00</div>
            </div>
            <div class="summary-checkout">
              <button class="checkout-cta" onclick="openPopup('popup')">Go to Secure Checkout</button>
            </div>
          </div>
        </aside>



        <div class="popup" id="popup">
          <img src="../images/check.png">
          <h2>ORDER CONFIRMED</h2>
          <p>Your order has been confirmed. You will soon receive a mail with confirmation details!</p>
          <button type="button" onclick="closePopup('popup')">Okay</button>
        </div>

        <div class="popup" id="popup-promo-wrong">
          <img src="../images/warning.png">
          <h2>INVALID PROMO CODE</h2>
          <button type="button" onclick="closePopup('popup-promo-wrong')">Okay</button>
        </div>

        <div class="popup" id="popup-promo-correct">
          <img src="../images/check.png">
          <h2>PROMO CODE APPLIED</h2>
          <button type="button" onclick="closePopup('popup-promo-correct')">Okay</button>
        </div>
      </main>
    </div>


    <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
    <script src="cart_script.js"></script>
    <script>
      function openPopup(popupId) {
        let popup = document.getElementById(popupId);
        popup.classList.add("open-popup");
      }

      function closePopup(popupId) {
        let popup = document.getElementById(popupId);
        popup.classList.remove("open-popup");
        if (popupId === "popup") {
          window.location.assign("payment.php");
        }
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
    </script>


    <script>
      $(document).ready(function() {
        // Get all the relevant elements
        var quantityInputs = $('.quantity-field');
        var prices = $('.price');
        var subtotalElements = $('.subtotal');

        // Loop through each quantity input field and add an event listener
        quantityInputs.each(function(index) {
          $(this).change(function() {
            // Get the current quantity value
            var quantity = parseInt($(this).val());

            // Get the price for this item using its index
            var price = parseFloat(prices.eq(index).text());

            // Calculate the new subtotal
            var subtotal = price * quantity;

            // Update the HTML content of the subtotal element with the new subtotal value
            subtotalElements.eq(index).text(subtotal);
          });
        });

        $('.remove button').click(function() {

          var item = $(this).closest('.basket-product');
          item.remove();

          let bookId = $(this).data("bookid").toString();
          console.log(bookId);

          const xhr = new XMLHttpRequest();
          xhr.open('POST', '../BackEnd/delete_from_cart.php');
          xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          xhr.send("Book_ID=" + bookId);
        });

      });
    </script>




    <!-- Discount and total value (Summary) -->
    <script>
      $(document).ready(function() {
        // Get the relevant elements
        var quantityInput = $('.quantity-field');
        var priceElements = $('.price');
        var subtotalElements = $('.subtotal');
        var totalElement = $('#basket-total');
        var basketsubElement = $('#basket-subtotal');
        var discountElement = $('#dicount-value');

        // Calculate initial total value
        var total = 0;
        subtotalElements.each(function() {
          total += parseFloat($(this).text());
        });
        basketsubElement.text(total.toFixed(2));

        var discount = 0;
        if (discountElement.text()) {
          discount = parseFloat(discountElement.text());
        }

        total -= discount;
        totalElement.text(total.toFixed(2));

        // Add event listeners to quantity input fields
        quantityInput.change(function() {
          // Get the current quantity value
          var quantity = parseInt($(this).val());

          // Get the corresponding price and subtotal elements
          var index = quantityInput.index(this);
          var price = parseFloat(priceElements.eq(index).text());
          var subtotalElement = subtotalElements.eq(index);

          // Calculate the new subtotal and update the subtotal element
          var subtotal = price * quantity;
          subtotalElement.text(subtotal.toFixed(2));

          // Calculate the new total and update the total element
          total = 0;
          subtotalElements.each(function() {
            total += parseFloat($(this).text());
          });
          totalElement.text(total.toFixed(2));
          basketsubElement.text(total.toFixed(2));
        });
      });
    </script>

    <script>
      var flag = false;
      $(document).ready(function() {


        var discountElement = $('#discount-value');
        var totalElement = $('#basket-total');
        var code = "OFF20";
        var total = parseFloat(totalElement.text());
        var sub_total = $('#basket-subtotal');
        var subtotal = parseFloat(sub_total.text());
        $('.promo-code-cta').click(function() {
          var promo = $('#promo-code').val().toUpperCase();
          discount = 0;
          if (code === promo && flag == false) {
            flag = true;
            discount += 0.20 * subtotal;
            total -= 0.20 * subtotal;
            totalElement.text(total.toFixed(2));
            discountElement.text(discount.toFixed(2));
            openPopup('popup-promo-correct');
          } else {
            openPopup('popup-promo-wrong');
            $('#promo-code').val("");
          }
        });
      });
    </script>

    <script>
      signOut = () => {
        <?php
        $_SESSION['loggedIn'] = false;
        $_SESSION['email'] = '';
        ?>
      }
    </script>
    <!-- Subtotal values in basket
    <script>
      $(document).ready(function() {
        // Get all the relevant elements
        var quantityInputs = $('.quantity-field');
        var prices = $('.price');

        var subtotalElements = $('.subtotal');
        var priceElements = $('.price');
        var totalElement = $('#basket-total');
        var basketsubElement = $('#basket-subtotal');
        var discountElement = $('#discount-value');
        var code = "OFF20";
        var total = parseFloat(totalElement.text());

        // Loop through each quantity input field and add an event listener
        quantityInputs.each(function(index) {
          $(this).change(function() {
            // Get the current quantity value
            var quantity = parseInt($(this).val());

            // Get the price for this item using its index
            var price = parseFloat(prices.eq(index).text());

            // Calculate the new subtotal
            var subtotal = price * quantity;

            // Update the HTML content of the subtotal element with the new subtotal value
            subtotalElements.eq(index).text(subtotal);

            // Calculate the new total and update the total element
            temp_total = 0;
            subtotalElements.each(function() {
              temp_total += parseFloat($(this).text());
            });
            basketsubElement.text(temp_total.toFixed(2));

            if (isDiscountValid) {
              discount = temp_total * 0.2;
              total = temp_total - discount;
            }else{
              total =temp_total;
            }
             discountElement.text(discount.toFixed(2));
            if (discountElement.text()) {
              discount = parseFloat(discountElement.text());
            }
            totalElement.text(total.toFixed(2));
          });
        });



        // Add event listener to remove button
        $('.remove button').click(function() {
          var item = $(this).closest('.basket-product');
          item.remove();

          // Calculate the new total and update the total element
          total = 0;
          subtotalElements.each(function() {
            temp_total += parseFloat($(this).text());
          });
          totalElement.text(total.toFixed(2));
          basketsubElement.text(temp_total.toFixed(2));
        });
        var isDiscountValid = false;




        // Add event listener to promo code button
        $('.promo-code-cta').click(function() {
          var promo = $('#promo-code').val().toUpperCase();
          discount = 0;
          if (code === promo) {
            isDiscountValid = true;
            discount += 0.20 * total;
            total -= discount;
            totalElement.text(total.toFixed(2));
            basketsubElement.text(temp_total.toFixed(2));
            discountElement.text(discount.toFixed(2));
            openPopup('popup-promo-correct');
          } else {
            openPopup('popup-promo-wrong');
            $('#promo-code').val("");
          }
        });

        // Calculate initial total value
        var total = 0;
        subtotalElements.each(function() {
          total += parseFloat($(this).text());
        });
        basketsubElement.text(total.toFixed(2));

        var discount = 0;
        if (discountElement.text()) {
          discount = parseFloat(discountElement.text());
        }

        total -= discount;
        totalElement.text(total.toFixed(2));
      });
    </script> -->


</body>

</html>