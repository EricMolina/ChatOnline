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


$contact_friend_ship_id = mysqli_escape_string($conn, $_POST["contact_friend_ship"]);
$message_content = mysqli_escape_string($conn, str_split($_POST["msg"], 250)[0]);
$sender_user_id = mysqli_escape_string($conn, $logged_user['id']);

try {
    // Create contact message
    mysqli_autocommit($conn, false);
    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    $query_create_message = 'INSERT INTO message (content, id_friendship, id_user_sender) VALUES (?, ?, ?);';
    $stmt_create_message = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt_create_message, $query_create_message);
    mysqli_stmt_bind_param(
        $stmt_create_message,
        "sii",
        $message_content,
        $contact_friend_ship_id,
        $sender_user_id,
    );
    mysqli_stmt_execute($stmt_create_message);

    mysqli_commit($conn);

    mysqli_stmt_close($stmt_create_message);
    mysqli_close($conn);

    ?>
    <form action="../index.php" method="POST" name="formMessage">
        <input type="hidden" name="contact" value="<?php echo $_POST["contact"]; ?>">
    </form>
    <script>document.formMessage.submit();</script>
    <?php

} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error al enviar mensaje: ".$e->getMessage();
    die();
}