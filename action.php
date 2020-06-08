<?php
include 'connection.php';
session_start();
if (isset($_SESSION['loggedin'])) {
    if (isset($_POST['approve']) && isset($_POST['tid'])) {
        $tid = $_POST['tid'];
        $query = oci_parse($conn, "UPDATE TRADER SET APPROVED = 'Y' WHERE TRADER_ID = '${tid}'");
        oci_execute($query);
    } 
}
