<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Cuadrícula</title>
    <link rel="stylesheet" href="./css/styles.css"> <!-- Asegúrate de enlazar tu archivo CSS aquí -->
</head>
<body class="chatonline-index-bg">
    <div class="container">
        <div class="row">
            <div class="column column-1 chatonline-header">
                <img src="./img/logo.svg" class="chatonline-img-logo chatonline-svg-white"/>
                <p>PATACHAT</p>
            </div>
        </div>
        <div class="row">
            <div class="column column-30 chatonline-contacts">
                <div class="row">
                    <div class="column column-1 chatonline-contacts-title">
                        <div class="row">
                            <div class="column column-1">
                                <p>CONTACTS</p>
                            </div>
                        </div>
                    </div>
                    <div class="column column-1 chatonline-contacts-finder">
                        <form action="" method="GET">
                            <input type="text" name="searched_user" class="chatonline-contacts-input">
                            <input type="submit" value="SEARCH" class="chatonline-contacts-submit">
                        </form>
                    </div>
                    <div class="row chatonline-contacts-contacts">
                        <div class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>username</h1>
                                    <p>last message</p>
                                </div>
                                <div class="column column-10">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>

                        <div class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>username</h1>
                                    <p>last message</p>
                                </div>
                                <div class="column column-10">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>
                        <div class="column column-1 chatonline-contacts-contact">
                            <div class="row">
                                <div class="column column-30">
                                    <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                                </div>
                                <div class="column column-60">
                                    <h1>username</h1>
                                    <p>last message</p>
                                </div>
                                <div class="column column-10">
                                    <h2>15:05</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column column-70 chatonline-chat">
                <p>chat</p>
            </div>
        </div>
    </div>
</body>
</html>