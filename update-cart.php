<?php
include 'connection.php';
session_start();

if (isset($_GET['rem']) && isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $cart = $_SESSION['cartId'];
    $min = 0;
    $query = oci_parse($conn, "BEGIN remove_from_cart('${cart}', '${pid}'); END;");
    oci_execute($query);


    echo 'done';
}

if (isset($_GET['upd']) && isset($_GET['pid']) && isset($_GET['quan'])) {
    $pid = $_GET['pid'];
    $cart = $_SESSION['cartId'];
    $quan = $_GET['quan'];

    $query = oci_parse($conn, "BEGIN update_cart('${cart}', '${pid}', '${quan}'); END;");
    oci_execute($query);

    echo 'done';
}
