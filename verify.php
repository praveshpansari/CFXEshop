<?php
include 'connection.php';
if (isset($_GET['vkey'])) {
    $vkey = $_GET['vkey'];
    $query = oci_parse($conn, "SELECT STATUS FROM USERS WHERE STATUS = 'N' AND VKEY = '${vkey}'");
    oci_execute($query);
    $result = oci_fetch_assoc($query);
    if ($result) {
        $query = oci_parse($conn, "UPDATE USERS SET STATUS = 'Y' WHERE VKEY = '${vkey}'");
        if (oci_execute($query)) {
            echo "Your account has been verified. Redirecting to login page...";
            header('Refresh: 2,URL=http://localhost/website/index.html');
        }
    } else {
        echo "This account is invalid or has been already verified";
    }
} else if (isset($_GET['add1']) && isset($_GET['payment'])) {
    
} else {
    die('Something went wrong!');
}
