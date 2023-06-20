<?php
include_once('connect.php');
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
    <link rel="stylesheet" href="trial_style.css">

</head>

<script src="cart_script.js"></script>

<body>
    <div class="banner">
        <div class="navbar">
            <div class="dropdown">
                <div class="wrap">
                    <div class="icon"></div>
                    <div class="icon"></div>
                    <div class="icon"></div>
                </div>
                <div class="dropdown-content">
                    <a href="Biblion.php">HOME</a>
                    <a href="Rent.php">RENT</a>
                    <a href="SignIn.php">SIGN IN</a>
                </div>
            </div>
            <h1 class="Logo">BIBLION</h1>
            <ul>
                <li><a href="Biblion.php">HOME</a></li>
                <li><a href="Rent.php">RENT</a></li>
            </ul>

            <div class="search-container">
                <input type="text" class="searchbar" id="live_search" autocomplete="off" placeholder="Looking for something">
                <div class="search-result-container" id="searchresult"></div>
            </div>

            <c class="cta">
                <a href="signup.php"> <button type="button"><img src="images/user-3-fill.png"></button></a>
                <a href="cart.php"> <button type="button"><img src="images/shopping-cart3.png"></button>
                </a>
            </c>
        </div>

        <div class="OuterContainer">
            <div class="InnerContainer">

                <div class="basket">
                    <div class="basket-module">
                        <label for="promo-code">Enter a promotional code</label>
                        <input id="promo-code" type="text" name="promo-code" maxlength="5" class="promo-code-field">
                        <button class="promo-code-cta">Apply</button>
                    </div>
                    <div class="basket-labels">
                        <ul>
                            <li class="item-heading"><h2>Item</h2></li>
                            <li class="price-heading"><h2>Price</h2></li>
                            <li class="quantity-heading"><h2>Quantity</h2></li>
                            <li class="subtotal-heading"><h2>Subtotal</h2></li>
                        </ul>
                    </div>
                    <div class="basket-container">
                        <?php
                        $select_query = "Select * from books b , cart c where c.Book_ID = b.Book_ID";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
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
                                    <input type='number' value= $quantity min='1' class='quantity-field'>
                                </div>

                                <div class='subtotal'>$subtotal</div>

                                <div class='remove'>
                                    <button>Remove</button>
                                </div>
                                </div>";
                        }
                        ?>
                    </div>    
                </div>

                <div class="Summary">

                    <div class="summary-total-items">
                        <span class="total-items"></span> Items in your Bag
                    </div>

                    <div class="summary-subtotal">

                        <div class="subtotal-title">Subtotal</div>

                        <div class="subtotal-value final-value" id="basket-subtotal">130.00</div>

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
                        <div class="total-value final-value" id="basket-total">130.00</div>
                    </div>

                    <div class="summary-checkout">
                        <button class="checkout-cta" onclick="openPopup()">Go to Secure Checkout</button>
                    </div>

                </div>

                <div class="popup" id="popup">
                    <img src="images/check.png">
                    <h2>ORDER CONFIRMED</h2>
                    <p>Your order has been confirmed. You will soon receive a mail with confirmation details!</p>
                    <button type="button" onclick="closePopup()">Okay</button>
                </div>

            </div>
        </div>
    </div>

        <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
        <script src="./script.js"></script>
        <script>
            let popup = document.getElementById("popup");

            function openPopup() {
                popup.classList.add("open-popup");
            }

            function closePopup() {
                popup.classList.remove("open-popup");
            }
        </script>

        <script type="text/javascript">
            $(document).ready(function() {
                $("#live_search").keyup(function() {
                    var input = $(this).val();

                    if (input != "") {
                        $.ajax({
                            url: "live_search.php",
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
<?php include('footer.php')?>
</body>
</html>