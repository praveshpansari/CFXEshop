<?php
include 'connection.php';
session_start();
if (isset($_SESSION['loggedin'])) {
    if (isset($_POST['approve']) && isset($_POST['tid'])) {
        $tid = $_POST['tid'];
        $query = oci_parse($conn, "UPDATE TRADER SET APPROVED = 'Y' WHERE TRADER_ID = '${tid}'");
        oci_execute($query);
    } else if (isset($_GET['delete']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = oci_parse($conn, "BEGIN delete_user('${id}'); END;");
        oci_execute($query);
    } else if (isset($_GET['access']) && isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = oci_parse($conn, "SELECT * FROM USERS WHERE USER_ID = '${id}'");
        oci_execute($query);
        $result = oci_fetch_assoc($query);
        $query = oci_parse($conn, "SELECT * FROM TRADER WHERE TRADER_ID = '${id}'");
        oci_execute($query);
        $result2 = oci_fetch_assoc($query);
        $cat = $result2['CATEGORY_NO'];
        $query = oci_parse($conn, "SELECT * FROM CATEGORY WHERE CATEGORY_NO = '${cat}'");
        oci_execute($query);
        $result3 = oci_fetch_assoc($query);
        $_SESSION['type'] = 'trader';
        $_SESSION['byAdmin'] = $_SESSION['id'];
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $result['EMAIL'];
        $_SESSION['add1'] = $result['ADDRESS_1'];
        $_SESSION['add2'] = $result['ADDRESS_2'];
        $_SESSION['phone'] = $result['PHONE_NO'];
        $_SESSION['website'] = $result2['WEBSITE'];
        $_SESSION['user'] = $result2['TRADER_NAME'];
        $_SESSION['catno'] = $cat;
        $_SESSION['cat'] = $result3['CATEGORY_NAME'];
        $_SESSION['pic'] = $result2['SUPPLIER_PIC'];
        echo 'success';
    } else if (isset($_GET['back']) && isset($_GET['id'])) {
        $id = $_SESSION['byAdmin'];
        $query = oci_parse($conn, "SELECT * FROM USERS WHERE USER_ID = '${id}'");
        oci_execute($query);
        $result = oci_fetch_assoc($query);
        $_SESSION['type'] = 'admin';
        $_SESSION['id'] = $id;
        $query = oci_parse($conn, "SELECT * FROM ADMIN WHERE ADMIN_ID = '${id}'");
        oci_execute($query);
        $result2 = oci_fetch_assoc($query);
        $_SESSION['email'] = $result['EMAIL'];
        $_SESSION['user'] = $result2['ADMIN_NAME'];
        echo "successA";
    }
}
