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
            <p>REGISTER FORM</p>
            <form action="../proc/process_register.php" method="POST" class="chatonline-form-form" onsubmit="return ValidateRegister()">

                <label for="username">USERNAME: <span id="username_e" style="display: none;">Write the username.</span></label>
                <input type="text" id="username" name="username" placeholder="username..." class="chatonline-form-input">
                <br><br>
                <label for="name">FULL NAME: <span id="name_e" style="display: none;">Write the full name.</span></label>
                <input type="text" id="name" name="username" placeholder="full name..." class="chatonline-form-input">
                <br><br>
                <label for="pwd1">PASSWORD: <span id="pwd1_e" style="display: none;">Write the first password.</span></label>
                <input type="password" id="pwd1" name="pwd1" placeholder="password..." class="chatonline-form-input">
                <br><br>
                <label for="pwd2">VERIFY PASSWORD: <span id="pwd2_e" style="display: none;">Write the second password.</span></label>
                <input type="password" id="pwd2" name="pwd2" placeholder="password..." class="chatonline-form-input">
                <span id="pwdcheck_e" style="display: none;">Passwords doesn't match.</span>
                <br>
                <input type="submit" value="REGISTER" class="chatonline-form-submit">
            </form>
            <br>
            <a href="./login.php">You already have account? Login here!</a>
        </div>
    </div>
</div>

</body>
</html>