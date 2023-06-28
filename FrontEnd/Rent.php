<?php
include_once '../BackEnd/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent</title>

    <link rel="stylesheet" href="../CSS/Genre.css">
</head>

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
                <a href="SignIn.php"> <button type="button"><img src="../images/user-3-fill.png"></button></a>
                <a href="cart.php"> <button type="button"><img src="../images/shopping-cart3.png"></button>
                </a>
            </c>
        </div>
        <div class="OuterContainer">
            <div class="InnerContainer">
                <header class="Heading">
                    <div id="genre-heading"></div>
                    <h1>Novels</h1>
                </header>
                <ul id="books">
                    <div class="ContentContainer">
                        <?php
                        $select_query = "Select * from books";
                        $result_query = mysqli_query($con, $select_query);
                        while ($row = mysqli_fetch_assoc($result_query)) {
                            $book_id = $row['Book_ID'];
                            $book_title = $row['Title'];
                            $book_author = $row['Author'];
                            $book_image = $row['Book_Image'];
                            $description = $row['Book_Description'];
                            echo
                            "<div class='Book'>  
                                <img src = 'data:image/png;base64," . base64_encode($book_image) . "' alt = 'Image $book_id'>
                                <div class='content'>
                                    <div class='BookTitle'>
                                        $book_title
                                    </div>
                                    <div class='AuthorName'>
                                        $book_author
                                    </div>
                                    <div class='Description'>
                                        $description
                                    </div>
                                    <button class='read' id = $book_id type='submit'><h4>Free Preview </h4></button>
                                </div>
                            </div>";
                        }
                        $con->close();
                        ?>
                    </div>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.read').click(function() {
                const bookId = this.id;
                window.location.href = 'bookpage.php?id=' + bookId;
            });
        });
    </script>

    <script>
        function heading() {
            let ID = <?php echo $_GET['id'] ?>;
            let headingText = "";
            if (ID == 1)
                headingText = "<h1>Adventure Stories</h1>";
            else if (ID == 2)
                headingText = "<h1>Science Fiction Stories</h1>";
            else if (ID == 3)
                headingText = "<h1>Non-Fiction Stories</h1>";
            else if (ID == 4)
                headingText = "<h1>Mystery Stories</h1>";
            else if (ID == 5)
                headingText = "<h1>Horror Stories</h1>";
            else if (ID == 6)
                headingText = "<h1>Romantic Stories</h1>";
            else if (ID == 7)
                headingText = "<h1>Paranormal Stories</h1>";
            else if (ID == 8)
                headingText = "<h1>Fantasy Stories</h1>";
            document.getElementById("genre-heading").innerHTML = headingText;
        }
        heading();
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
</body>
<?php include('footer.php') ?>

</html>