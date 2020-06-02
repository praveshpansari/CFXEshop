<?php
include 'connection.php';
session_start();
if (isset($_SESSION['loggedin'])) {

    if (isset($_POST['id']) && isset($_POST['email'])) {
        $id = $_POST['id'];
        $email = $_POST['email'];

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = $email;
            $query = oci_parse($conn, "UPDATE USERS SET EMAIL = '${email}' WHERE USER_ID = '${id}'");
            oci_execute($query);
            echo "successE";
        } else echo "format";
    } else if (isset($_POST['password'])) {

        $id = $_POST['id'];
        $password = $_POST['password'];

        if (preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?=.*\d)(?!.* ).{8,}$^', $password)) {
            $query = oci_parse($conn, "UPDATE USERS SET PASSWORD = '${password}' WHERE USER_ID = '${id}'");
            oci_execute($query);
            echo "successP";
        } else echo "format";
    } else {
        if ($_SESSION['type'] == 'customer') {
            if (isset($_POST['first']) && isset($_POST['last']) && isset($_POST['phone']) && isset($_POST['age'])) {
                $first = $_POST['first'];
                $last = $_POST['last'];

                if (preg_match('/[a-zA-Z]$/', $first) && preg_match('/[a-zA-Z]$/', $last)) {
                    $_SESSION['first'] = $first;
                    $_SESSION['last'] = $last;
                    $phone = $_POST['phone'];
                    $age = $_POST['age'];
                    $id = $_POST['id'];

                    $_SESSION['phone'] = $phone;
                    $_SESSION['age'] = $age;

                    if (isset($_POST['sex'])) {
                        $sex = $_POST['sex'];
                        $_SESSION['sex'] = $sex;
                    } else $sex = null;

                    if (isset($_POST['add1'])) {
                        $add1 = $_POST['add1'];
                        $_SESSION['add1'] = $add1;
                    } else $add1 = null;

                    if (isset($_POST['add2'])) {
                        $add2 = $_POST['add2'];
                        $_SESSION['add2'] = $add2;
                    } else $add2 = null;

                    $query = oci_parse($conn, "UPDATE CUSTOMER SET FIRST_NAME = '${first}',LAST_NAME = '${last}', SEX = '${sex}' ,AGE = '${age}' WHERE CUSTOMER_ID = '${id}'");

                    oci_execute($query);

                    $query = oci_parse($conn, "UPDATE USERS SET PHONE_NO = '${phone}', ADDRESS_1 = '${add1}',ADDRESS_2 = '${add2}' WHERE USER_ID = '${id}'");
                    oci_execute($query);

                    echo "successI";
                } else echo "format";
            }
        } else if ($_SESSION['type'] == 'trader') {
            if (isset($_POST['name']) && isset($_POST['website']) && isset($_POST['phone']) && isset($_POST['cat'])) {
                $name = $_POST['name'];
                $website = $_POST['website'];
                $cat = $_POST['cat'];
                $phone = $_POST['phone'];

                $_SESSION['website'] = $website;
                $_SESSION['phone'] = $phone;
                $_SESSION['user'] = $name;
                $_SESSION['catno'] = $cat;

                if (isset($_POST['add1'])) {
                    $add1 = $_POST['add1'];
                    $_SESSION['add1'] = $add1;
                } else $add1 = null;

                if (isset($_POST['add2'])) {
                    $add2 = $_POST['add2'];
                    $_SESSION['add2'] = $add2;
                } else $add2 = null;

                $query = oci_parse($conn, "UPDATE TRADER SET TRADER_NAME = '${name}',WEBSITE = '${website}', CATEGORY_NO = '${cat}' WHERE TRADER_ID = '${id}'");

                oci_execute($query);

                $query = oci_parse($conn, "UPDATE USERS SET PHONE_NO = '${phone}', ADDRESS_1 = '${add1}',ADDRESS_2 = '${add2}' WHERE USER_ID = '${id}'");
                oci_execute($query);

                echo "successI";
            }
        }
    }
} else echo "You are not allowed to acces this page";
