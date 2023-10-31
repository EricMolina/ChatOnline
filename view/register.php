<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Cuadrícula</title>
    <link href="https://fonts.cdnfonts.com/css/helvetica-neue-55" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css"> <!-- Asegúrate de enlazar tu archivo CSS aquí -->
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
            <form action="../proc/process_register.php" method="POST" class="chatonline-form-form">

                <label for="username">USERNAME:</label>
                <input type="text" id="username" name="username" placeholder="username..." class="chatonline-form-input">
                <br><br>
                <label for="name">FULL NAME:</label>
                <input type="text" id="name" name="username" placeholder="full name..." class="chatonline-form-input">
                <br><br>
                <label for="pwd1">PASSWORD:</label>
                <input type="password" id="pwd1" name="pwd1" placeholder="password..." class="chatonline-form-input">
                <br><br>
                <label for="pwd2">VERIFY PASSWORD:</label>
                <input type="password" id="pwd2" name="pwd2" placeholder="password..." class="chatonline-form-input">
                <br>
                <input type="submit" value="LOGIN" class="chatonline-form-submit">
            </form>
        </div>
    </div>
</div>

</body>
</html>