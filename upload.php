<?php
include 'connection.php';
session_start();
if (isset($_POST["image_upload"])) {
    $data = $_POST["image_upload"];

    $extension = explode('/', mime_content_type($data))[1];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);


    $userId = $_SESSION["id"];

    if ($_SESSION['type'] == 'customer') {
        $imageName = 'images/profile/' . time() . "." . $extension;
        file_put_contents($imageName, $data);
        $query = oci_parse($conn, "UPDATE CUSTOMER SET PROFILE_PIC = '{$imageName}' WHERE CUSTOMER_ID = '{$userId}'");
    } else if ($_SESSION['type'] == 'trader') {
        $imageName = 'images/traders/' . time() . "." . $extension;
        file_put_contents($imageName, $data);
        $query = oci_parse($conn, "UPDATE TRADER SET SUPPLIER_PIC = '{$imageName}' WHERE TRADER_ID = '{$userId}'");
    }
    $_SESSION["pic"] = $imageName;
    oci_execute($query);
    echo $imageName;
}

if (isset($_POST["product-image"])) {
    $data = $_POST["product-image"];

    $extension = explode('/', mime_content_type($data))[1];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

    switch ($_SESSION['catno']) {
        case '1':
            $imageName = 'images/product/meat/' . time() . "." . $extension;
            break;
        case '2':
            $imageName = 'images/product/grocery/' . time() . "." . $extension;
            break;
        case '3':
            $imageName = 'images/product/fish/' . time() . "." . $extension;
            break;
        case '4':
            $imageName = 'images/product/bakery/' . time() . "." . $extension;
            break;
        case '5':
            $imageName = 'images/product/deli/' . time() . "." . $extension;
            break;
    }


    file_put_contents($imageName, $data);
    echo $imageName;
}
