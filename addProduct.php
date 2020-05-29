<?php
include 'connection.php';
session_start();
if (isset($_GET['pname']) && isset($_GET['price']) && $_GET['description'] != NULL && isset($_GET['min']) && isset($_GET['max']) && isset($_GET['stock']) && isset($_GET['pimg']) && isset($_GET['quantity']) && isset($_GET['pshop'])) {

    $pname = $_GET['pname'];
    $pshop = $_GET['pshop'];
    $query = oci_parse($conn, "SELECT PRODUCT_ID FROM PRODUCT WHERE PRODUCT_NAME = '${pname}'");
    oci_execute($query);
    while ($result = oci_fetch_array($query)) {
        $pid = $result['PRODUCT_ID'];
        $query1 = oci_parse($conn, "SELECT SHOP_ID FROM SHOP_PRODUCT WHERE PRODUCT_ID = '${pid}'");
        oci_execute($query1);
        $flag = oci_fetch_assoc($query1)['SHOP_ID'] == $pshop;
        if($flag) break;
    }

    if (!$flag) {
        $price = $_GET['price'];
        $description = $_GET['description'];
        $min = $_GET['min'];
        $max = $_GET['max'];
        $stock = $_GET['stock'];
        $pimg = $_GET['pimg'];
        $quantity = $_GET['quantity'];
        
        if (isset($_GET['allergy'])) {
            $allergy = $_GET['allergy'];
        } else {
            $allergy = 'DEFAULT';
        }

        $query = oci_parse($conn, "BEGIN insert_product('{$pname}','{$description}','{$price}','{$quantity}','{$min}','{$max}','{$pimg}','{$allergy}','{$stock}','{$pshop}'); END;");
        oci_execute($query);
    } else {
        echo "exist";
    }
} else {
    echo "all";
}
