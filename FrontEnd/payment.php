<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/payment_style.css">
    <title>Payment Page</title>
</head>

<body>

    <div class="container">
        <div class="card-container">
            <div class="front">
                <div class="image">
                    <img src="../images/chip.png" alt="">
                    <img src="../images/visa.png" alt="">
                </div>
                <div class="card-number-box">############</div>
                <div class="flexbox">
                    <div class="box">
                        <span>card holder</span>
                        <div class="card-holder-name">full name</div>
                    </div>
                    <div class="box">
                        <span>expires</span>
                        <div class="expiration"></div>
                        <span class="exp-month">mm</span>
                        <span class="exp-year">yyyy</span>
                    </div>
                </div>
            </div>
        </div>



        <form id = "payment_form" action="">
            <div class="inputbox">
                <span>card number:</span>
                <input type="text" maxlength="16" class="card-number-input" placeholder="16-digit number" pattern="[0-9]{16}" required autofocus>
            </div>
            <div class="inputbox">
                <span>card holder:</span>
                <input type="text" class="card-holder-input" placeholder="Enter name" required>
            </div>
            <div class="flexbox">
                <div class="inputbox">
                    <span>expiration mm</span>
                    <select name="" id="" class="month-input" required>
                        <option value="" selected disabled>month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="inputbox">
                    <span>expiration yyyy</span>
                    <select name="" id="" class="year-input" required>
                        <option value="" selected disabled>year</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
                <div class="inputbox">
                    <span>cvv</span>
                    <input type="password" maxlength="3" class="cvv-input" placeholder="3-digit number" pattern="[0-9]{3}" required>
                </div>
            </div>
            <input type="submit" value="Pay now" onclick="openPopup(event)" class="submit-btn">
        </form>
    </div>


    <div class="popup" id="popup">
        <img src="../images/check.png">
        <h2>Payment successful!</h2>
        <p></p>
        <button type="button" onclick="closePopup()">Okay</button>
    </div>




    <script>
        document.querySelector('.card-number-input').oninput = () => {
            document.querySelector('.card-number-box').innerText = document.querySelector('.card-number-input').value;
        }
        document.querySelector('.card-holder-input').oninput = () => {
            document.querySelector('.card-holder-name').innerText = document.querySelector('.card-holder-input').value;
        }
        document.querySelector('.month-input').oninput = () => {
            document.querySelector('.exp-month').innerText = document.querySelector('.month-input').value;
        }
        document.querySelector('.year-input').oninput = () => {
            document.querySelector('.exp-year').innerText = document.querySelector('.year-input').value;
        }

        function isFormComplete(form) {
            var fields = form.elements;

            for (var i = 0; i < fields.length; i++) {
                if (fields[i].required && fields[i].value === "") {
                    return false;
                }
            }
            return true;
        }


        let popup = document.getElementById("popup");
        var form = document.getElementById("payment_form");
        function openPopup(event) {
            if(isFormComplete(form))
            {
            event.preventDefault();
            popup.classList.add("open-popup");
            }
        }

        function closePopup() {
            popup.classList.remove("open-popup");
            window.location.assign("Biblion.php");
        }
    </script>
</body>

</html>