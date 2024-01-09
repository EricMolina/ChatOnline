<?php

include("./utils.php");
include("./db_connection.php");


session_start();

check_user_login("../view/login.php");

$logged_user = get_user_logedin();


if ((!isset($_POST["contact_friend_ship"]) || empty($_POST["contact_friend_ship"])) ||
    (!isset($_POST["msg"]) || empty($_POST["msg"])) ||
     !isset($_POST["contact"]) || empty($_POST["contact"])) {
    header("Location: ../");
}


$contact_friend_ship_id = $_POST["contact_friend_ship"];
$message_content = str_split($_POST["msg"], 250)[0];
$sender_user_id = $logged_user['id'];

try {
    // Create contact message
    $conn->beginTransaction();

    if (empty($_FILES['msg_files']['name'][0])) { //SIN IMAGENES
        $query_create_message = 'INSERT INTO message (content, id_friendship, id_user_sender) VALUES (:a, :b, :c);';
        $stmt_create_message = $conn->prepare($query_create_message);
        $stmt_create_message->bindParam(":a", $message_content);
        $stmt_create_message->bindParam(":b", $contact_friend_ship_id);
        $stmt_create_message->bindParam(":c", $sender_user_id);
        $stmt_create_message->execute();
    }
    else { //CON IMAGENES

        $directorio_destino = '../img/chats/';
        $query_create_message = 'INSERT INTO message (content, image, id_friendship, id_user_sender) VALUES (:a, :b, :c, :d);';
        $stmt_create_message = $conn->prepare($query_create_message);


        foreach ($_FILES['msg_files']['name'] as $key => $name) {

            $ruta_temporal = $_FILES['msg_files']['tmp_name'][$key]; 
            $nombrecompleto_fichero = $_FILES['msg_files']['name'][$key]; 
            $nombre_fichero = pathinfo($nombrecompleto_fichero, PATHINFO_FILENAME);
            $extension_fichero = pathinfo($nombrecompleto_fichero, PATHINFO_EXTENSION);

            $nombre_nuevo = $nombre_fichero."_".uniqid().".".$extension_fichero;
            move_uploaded_file($ruta_temporal, $directorio_destino . $nombre_nuevo);

            $rutaImgServidor = substr($directorio_destino, 1) . $nombre_nuevo;

            $stmt_create_message->bindParam(":a", $message_content);
            $stmt_create_message->bindParam(":b", $rutaImgServidor);
            $stmt_create_message->bindParam(":c", $contact_friend_ship_id);
            $stmt_create_message->bindParam(":d", $sender_user_id);

            $stmt_create_message->execute();
        }
        
    }
    $conn->commit();

    ?>
    <form action="../index.php" method="POST" name="formMessage">
        <input type="hidden" name="contact" value="<?php echo $_POST["contact"]; ?>">
    </form>
    <script>document.formMessage.submit();</script>
    <?php

} catch (PDOException $e) {
    $conn->rollBack();
    echo "Error al enviar mensaje: ".$e->getMessage();
    header("location: ../index.php");
}