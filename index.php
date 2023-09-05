<?php
session_start();
include_once 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Biblion</title>

    <link rel="stylesheet" href="../CSS/Biblion_style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <div id="banner" class="banner">
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
        <div class="containerfirst">
            <span>Renting Books Made Easy</span>
        </div>
        <div class="container">
            <div class="wrapper">
                <div class="slider-holder">
                    <div id="img1"></div>
                    <div id="img2"></div>
                    <div id="img3"></div>
                    <div id="img4"></div>
                    <div id="img5"></div>
                </div>
            </div>
            <div class="button-holder">
                <a href="#img1" class="dots"></a>
                <a href="#img2" class="dots"></a>
                <a href="#img3" class="dots"></a>
                <a href="#img4" class="dots"></a>
                <a href="#img5" class="dots"></a>
            </div>
        </div>
        <div class="Sub">
            <h1>GENRE<h1>
        </div>
        <?php
        echo
        "<div class='container2'>
                <div class='col1'>
                    <div class='text'>ADVENTURE</div>
                        <a href='Genre.php?id=1'>
                        <img src='../images/Adventure.png'>
                        </a>
                </div>
                <div class='col1'>
                    <div class='text'>SCIENCE FICTION</div>
                        <a href='Genre.php?id=2'>
                        <img src='../images/ScienceFiction.png'>
                        </a>
                </div>
                <div class='col1'>
                    <div class='text'>NON-FICTION</div>
                        <a href='Genre.php?id=3'>
                        <img src='../images/NonFiction.png'>
                        </a>
                </div>
                <div class='col1'>
                    <div class='text'>MYSTERY</div>
                        <a href='Genre.php?id=4'>
                        <img src='../images/Mystery.png'>
                        </a>
                </div>
            </div>
            <div class='container3'>
                <div class='col2'>
                    <div class='text'>HORROR</div>
                        <a href='Genre.php?id=5'>
                        <img src='../images/Horror.png'>
                        </a>
                </div>
                <div class='col2'>
                    <div class='text'>ROMANTIC</div>
                        <a href='Genre.php?id=6'>
                        <img src='../images/Romantic.png'>
                        </a>
                </div>
                <div class='col2'>
                    <div class='text'>PARANORMAL</div>
                    <a href='Genre.php?id=7'>
                    <img src='../images/Paranormal.png'>
                    </a>
                </div>
                <div class='col2'>
                    <div class='text'>FANTASY</div>
                    <a href='Genre.php?id=8'>
                    <img src='../images/Fantasy.png'>
                    </a>
                </div>
            </div>"
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $(".wrap").click(function() {
                $(".dropdown-content").toggleClass("opensidebar")
            });
        });

        function changebg() {
            var scrollval = window.scrollY;
            var navbar = document.getElementById('navbar');
            if (scrollval < 620) {
                navbar.classList.remove('bgColor1');
            } else {
                navbar.classList.add('bgColor1');
            }
        }

        function changebg2() {
            var scrollval = window.scrollY;
            var navbar = document.getElementById('navbar');
            if (scrollval < 1670) {
                navbar.classList.remove('bgColor2');
            } else {
                navbar.classList.add('bgColor2');
            }
        }
        window.addEventListener('scroll', changebg)
        window.addEventListener('scroll', changebg2)

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                console.log(entry)
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                } else {
                    entry.target.classList.remove('show');
                }
            });
        });


        const hiddenElements1 = document.querySelectorAll('.col1');
        hiddenElements1.forEach((el) => observer.observe(el));
        const hiddenElements2 = document.querySelectorAll('.col2');
        hiddenElements2.forEach((el) => observer.observe(el));
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
        function signOut() {
            <?php
                unset($_SESSION['loggedIn']);
                unset($_SESSION['email']);
            ?>
        }
    </script>
    <?php include('footer.php') ?>
</body>

</html>