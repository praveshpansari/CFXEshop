<?php
include 'connection.php';
session_start();

if (isset($_SESSION['loggedin'])) {
	if ($_SESSION['type'] == 'trader') 
		header('location:trader.php');
	else if (isset($_GET['fav']) && isset($_GET['pid'])) {
		$id = $_SESSION['id'];
        $pid = $_GET['pid'];
        
		$query = oci_parse($conn,"BEGIN add_to_fav('${id}', '${pid}'); END;");
		oci_execute($query);
    }
}else {
    echo "Page not found";
}
