<!DOCTYPE html>
<html>
<head>
    <title>To Be Continued</title>
    <style>
        body {
            background-color: #f5f5f5;
            text-align: center;
        }
        .container {
            margin-top: 100px;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h1 {
            color: #333;
            font-size: 36px;
        }
        p {
            color: #666;
            font-size: 18px;
        }
    </style>
    <script>
        var countdown = 8;
        var countdownInterval = setInterval(function() {
            var popup = document.getElementById('popup');
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                window.location.href = "http://localhost";
            } else {
                popup.innerText = "Redirecting to Homepage in " + countdown + " seconds";
                countdown--;
            }
        }, 1000); // 1000 milliseconds = 1 second
    </script>
</head>
<body>
    <div class="container">
        <h1>Reread</h1>
        <p>To Be Continued </p>
        <p id="popup">Redirecting to Homepage in 8 seconds</p>
    </div>
</body>
</html>
