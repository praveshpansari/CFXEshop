<?php
// $conn = oci_connect('eshop', 'oracle', 'XE');
include 'connection.php';
if (isset($_POST['emailId']) && isset($_POST['password'])) {
    $email = $_POST['emailId'];
    $password = $_POST['password'];
    $query = oci_parse($conn, "SELECT * FROM USERS WHERE email = '${email}'");
    oci_execute($query);
    if ($result = oci_fetch_assoc($query)) {
        if ($result['PASSWORD'] == $password) {
            if ($result['STATUS'] == 'Y') {
                $userId = $result['USER_ID'];
                if ($result['TYPE'] == 'C') {
                    $query = oci_parse($conn, "SELECT * FROM CUSTOMER_INFO WHERE CUSTOMER_ID = '${userId}'");
                    oci_execute($query);
                    $result2 = oci_fetch_assoc($query);
                    session_start();
                    $_SESSION['user'] = $result2['USERNAME'];
                    $_SESSION['email'] = $email;
                    $_SESSION['type'] = 'customer';
                    $_SESSION['add1'] = $result['ADDRESS_1'];
                    $_SESSION['add2'] = $result['ADDRESS_2'];
                    $_SESSION['phone'] = $result['PHONE_NO'];
                    $_SESSION['age'] = $result2['AGE'];
                    $_SESSION['cartId'] = $result2['CART_ID'];
                    $_SESSION['id'] = $userId;
                    $_SESSION['pic'] = $result2['PROFILE_PIC'];
                    $_SESSION['sex'] = $result2['SEX'];
                    $_SESSION['first'] = $result2['FIRST_NAME'];
                    $_SESSION['last'] = $result2['LAST_NAME'];
                    echo "successC";
                } else if ($result['TYPE'] == 'T') {
                    $query = oci_parse($conn, "SELECT * FROM TRADER WHERE TRADER_ID = '${userId}'");
                    oci_execute($query);
                    $result2 = oci_fetch_assoc($query);
                    $cat = $result2['CATEGORY_NO'];
                    $query = oci_parse($conn, "SELECT * FROM CATEGORY WHERE CATEGORY_NO = '${cat}'");
                    oci_execute($query);
                    $result3 = oci_fetch_assoc($query);
                    session_start();
                    $_SESSION['type'] = 'trader';
                    $_SESSION['id'] = $userId;
                    $_SESSION['email'] = $email;
                    $_SESSION['add1'] = $result['ADDRESS_1'];
                    $_SESSION['add2'] = $result['ADDRESS_2'];
                    $_SESSION['phone'] = $result['PHONE_NO'];
                    $_SESSION['website'] = $result2['WEBSITE'];
                    $_SESSION['user'] = $result2['TRADER_NAME'];
                    $_SESSION['catno'] = $cat;
                    $_SESSION['cat'] = $result3['CATEGORY_NAME'];
                    $_SESSION['pic'] = $result2['SUPPLIER_PIC'];
                    echo "successT";
                } else {
                    echo "successA";
                }
                $_SESSION['loggedin'] = true;
            } else {
                echo "not_verified";
            }
        } else {
            echo "fail_pass";
        }
    } else {
        echo "fail_email";
    }
}
