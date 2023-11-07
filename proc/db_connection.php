<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_server = "localhost";
$db_username = "root";
$db_password = "";
$db_database = "db_chatonline";

try {
    $conn = @mysqli_connect(
        $db_server,
        $db_username,
        $db_password,
        $db_database
    );

} catch (Exception $e) {
    echo "Error en la conexión con la base de datos: ".$e->getMessage();
    mysqli_close($conn);
    header("location: ../index.php");
}
