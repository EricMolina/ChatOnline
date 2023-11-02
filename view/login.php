<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PATACHAT</title>
    <link rel="icon" type="image/x-icon" href="../img/icon.ico">
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/functions.js"></script>
</head>
<body class="chatonline-form-bg">

<div class="chatonline-top-green-div">

</div>
<div class="container container-chatonline-form">
    <div class="row">
        <div class="column column-1 chatonline-form-title">
            <img src="../img/logo.svg" class="chatonline-img-10 chatonline-svg-white"/>
            <p>PATACHAT</p>
        </div>
    </div>
    <div class="row">
        <div class="column column-1 chatonline-form">
            <p>LOGIN FORM</p>
            <form action="../proc/process_login.php" method="POST" class="chatonline-form-form" onsubmit="return ValidateLogin()">

                <label for="username">USERNAME: <span id="username_e" style="display: none;">Enter the username.</span></label>
                <input type="text" id="username" name="username" placeholder="username..." class="chatonline-form-input">
                <br><br>
                <label for="pwd">PASSWORD: <span id="pwd_e" style="display: none;">Enter the password.</span></label>
                <input type="password" id="pwd" name="pwd" placeholder="password..." class="chatonline-form-input">
                <br>
                <input type="submit" value="LOGIN" class="chatonline-form-submit">
            </form>
            <br>
            <a href="./register.php">You don't have account? Register here!</a>
        </div>
    </div>
</div>

</body>
</html>