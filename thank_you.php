<?php
include("includes/header.html");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You!</title>
</head>
<body>
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #fff;
        }
        .thank-you {
            color: purple;
            font-size: 6rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: 0.1em;
        }
        .home-link {
            display: inline-block;
            padding: 1.2rem 3rem;
            font-size: 2rem;
            background: purple;
            color: #fff;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }
        .home-link:hover {
            background: #800080cc;
        }
    </style>
    <div class="thank-you">THANK YOU</div>
    <a class="home-link" href="index1.php">Back to Home Page</a>
</body>
</html>