<?php
require 'ayar.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $captcha_response = htmlspecialchars($_POST['g-recaptcha-response'], ENT_QUOTES, 'UTF-8');
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response=".$captcha_response);
    $response_keys = json_decode($response, true);
    
    if (intval($response_keys["success"]) === 1) {
        $_SESSION['verified'] = true;
        $_SESSION['verified_time'] = time();
        header("Location: /");
        exit;
    } else {
        $error = "Captcha doğrulaması başarısız oldu. Lütfen tekrar deneyin.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Waf</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: black;
            font-family: Arial, sans-serif;
            position: relative;
            overflow: hidden;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 2;
            position: relative;
        }
        .container h1 {
            margin-bottom: 1rem;
            font-size: 2rem;
            color: #333;
        }
        .container .g-recaptcha {
            margin-bottom: 1rem;
        }
        .container input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        .container input[type="submit"]:hover {
            background: #0056b3;
        }
        .container .error {
            color: red;
            margin-top: 1rem;
        }
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            display: flex;
            flex-wrap: wrap;
        }
        .background span {
            font-size: 20px;
            color: green;
            animation: scroll 10s linear infinite;
        }
        @keyframes scroll {
            0% {
                transform: translateY(100%);
            }
            100% {
                transform: translateY(-100%);
            }
        }
        .title {
            position: absolute;
            top: -2rem;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            z-index: 3;
            font-size: 1.5rem;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="background">
        <?php for($i = 0; $i < 0; $i++): ?>
            <span><?php echo rand(0, 1); ?></span>
        <?php endfor; ?>
    </div>
    <div class="container">
        <div class="title">KadirInDev</div>
        <h1>WAF</h1>
        <form action="" method="POST">
            <div data-theme="dark" class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>
            <br/>
            <input type="submit" value="DOĞRULA">
        </form>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        <br>
        <br>
        <footer>
        &copy; <?php echo date('Y'); ?> github.com/KadirInDev 
    </footer>
    </div>
</body>
</html>
