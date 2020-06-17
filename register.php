<?php
include 'connection.php';
//$conn = oci_connect('eshop', 'oracle', 'XE');

if (isset($_POST['first_name']) && isset($_POST['username']) && isset($_POST['age']) && isset($_POST['last_name']) && isset($_POST['registerEmail']) && isset($_POST['registerPassword']) && isset($_POST['phone'])) {
    $age = $_POST['age'];

    if (preg_match('/[a-zA-Z]$/', $_POST['first_name'])) {
        $firstname = $_POST['first_name'];
        if (preg_match('/[a-zA-Z]$/', $_POST['last_name'])) {
            $lastname = $_POST['last_name'];
            if (filter_var($_POST['registerEmail'], FILTER_VALIDATE_EMAIL)) {
                $registerEmail = $_POST['registerEmail'];
                if (preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?=.*\d)(?!.* ).{8,}$^', $_POST['registerPassword'])) {
                    $registerPassword = $_POST['registerPassword'];
                    if (preg_match('/[a-z0-9_\-]{6,}$/', $_POST['username'])) {
                        $username = $_POST['username'];
                        $query = oci_parse($conn, "SELECT * FROM USERS WHERE EMAIL = '${registerEmail}'");
                        oci_execute($query);
                        if (oci_fetch($query)) {
                            echo 'email_exists';
                        } else {
                            $query = oci_parse($conn, "SELECT * FROM CUSTOMER WHERE USERNAME = '${username}'");
                            oci_execute($query);
                            if (oci_fetch($query)) {
                                echo 'username_exists';
                            } else {
                                //$_SESSION['admin'] = $row['Admin'];
                                // $_SESSION['loggedin'] = true;
                                // $_SESSION['user'] = $row['USER_ID'];
                                // $_SESSION['name'] = $row["First_Name"] . ' ' . $row["Second_Name"];
                                // $_SESSION['email'] = $row['Email'];
                                // $_SESSION['username'] = $username;
                                //header('location:index.php');
                                $phone = $_POST['phone'];
                                $default = 'DEFAULT';
                                $vkey = md5(time() . $username);
                                $query = oci_parse($conn, "BEGIN REGISTER_CUSTOMER('{$registerPassword}','{$registerEmail}','{$phone}','{$vkey}','C','{$username}','{$firstname}','{$lastname}','{$age}'); END;");
                                oci_execute($query);
                                $to = $registerEmail;
                                $subject = "Email Verification - CFX eShop";
                                $message = "<h2 style='font:Calibri'>Hello $username!</h2>
                                            <div style='font:Calibri;font-size:0.9rem'>
                                            Welcome to CFX eShop! We’re happy to have you with us. <br>
                                            Just verify your email subscription to login and start purchasing your favorite goods from our vast selection.<br><br>
                                            <a style='padding:10px 10px;text-decoration:none;font-size:0.6rem;text-transform:uppercase;letter_spacing:1px;background:green;color:white;font-weight:600;' target='_blank' href='http://localhost/website/verify.php?vkey=$vkey'>Verify Account</a><br><br>
                                            If you received this email by mistake, just delete it. You won't be subscribed if you don't confirm your subscription above.<br>
                                            Thanks again for joining our community!<br><br>
                                            Sincerely,<br>
                                            CFX eShop</div>";
                                $headers = "From: cfxeshop@gmail.com" . "\r\n";
                                $headers .= "MIME-Version:1.0" . "\r\n";
                                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                $success = mail($to, $subject, $message, $headers);
                                if(!$success) {
                                    print_r(error_get_last()['message']);
                                } else 
                                echo 'success';
                            }
                        }
                    } else {
                        echo 'username';
                    }
                } else {
                    echo 'password';
                }
            } else {
                echo 'email';
            }
        } else {
            echo 'lastname';
        }
    } else {
        echo 'firstname';
    }
} else if (isset($_POST['trader_name']) && isset($_POST['website']) && isset($_POST['trader']) && isset($_POST['category']) && isset($_POST['registerTraderEmail']) && isset($_POST['registerTraderPassword']) && isset($_POST['phone'])) {
    $trader_name = $_POST['trader_name'];
    $category = $_POST['category'];
    if (filter_var($_POST['registerTraderEmail'], FILTER_VALIDATE_EMAIL)) {
        $registerEmail = $_POST['registerTraderEmail'];
        if (preg_match('^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?=.*\d)(?!.* ).{8,}$^', $_POST['registerTraderPassword'])) {
            $registerPassword = $_POST['registerTraderPassword'];
            $website = $_POST['website'];
            $query = oci_parse($conn, "SELECT * FROM USERS WHERE EMAIL = '${registerEmail}'");
            oci_execute($query);
            if (oci_fetch($query)) {
                echo 'email_exists';
            } else {
                $phone = $_POST['phone'];
                $default = 'DEFAULT';
                $vkey = md5(time() . $trader_name);
                $query = oci_parse($conn, "BEGIN REGISTER_TRADER('{$registerPassword}','{$registerEmail}','{$phone}','{$vkey}','T','{$trader_name}','{$website}','{$category}'); END;");
                oci_execute($query);
                $to = $registerEmail;
                $subject = "Email Verification - CFX eShop";
                $message = "<h2 style='font:Calibri'>Hello $trader_name!</h2>
                                            <div style='font:Calibri;font-size:0.9rem'>
                                            Welcome to CFX eShop! We’re happy to have you with us. <br>
                                            Just verify your email subscription to login and start selling your goods from our portal.<br><br>
                                            <a style='padding:10px 10px;text-decoration:none;font-size:0.6rem;text-transform:uppercase;letter_spacing:1px;background:green;color:white;font-weight:600;' target='_blank' href='http://localhost/website/verify.php?vkey=$vkey'>Verify Account</a><br><br>
                                            If you received this email by mistake, just delete it. You won't be subscribed if you don't confirm your subscription above.<br>
                                            Thanks again for joining our community!<br><br>
                                            Sincerely,<br>
                                            CFX eShop</div>";
                $headers = "From: cfxeshop@gmail.com" . "\r\n";
                $headers .= "MIME-Version:1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                echo "success";
                mail($to, $subject, $message, $headers);
            }
        } else {
            echo 'password';
        }
    } else {
        echo 'email';
    }
}
