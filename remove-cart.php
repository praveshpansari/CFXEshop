<?php
include 'connection.php';
session_start();

if (isset($_GET['rem']) && isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $cart = $_SESSION['cartId'];

    $query = oci_parse($conn, "DELETE FROM CART_PRODUCT WHERE CART_ID = '${cart}' AND PRODUCT_ID = '${pid}'");
    oci_execute($query);


    echo 'done';
}
