<?php
include 'connection.php';
session_start();

if (isset($_SESSION['loggedin'])) {
	$id = $_SESSION['id'];
	if ($_SESSION['type'] == 'trader')
		header('location:trader.php');

	else if ($_SESSION['type'] == 'admin')
		header('location:admin.php');

	else if (isset($_GET['fav']) && isset($_GET['pid'])) {
		$pid = $_GET['pid'];

		$query = oci_parse($conn, "BEGIN add_to_fav('${id}', '${pid}'); END;");
		oci_execute($query);
	} else if (isset($_GET['pid']) && isset($_GET['star'])) {
		$pid = $_GET['pid'];
		$stars = $_GET['star'];
		$query = oci_parse($conn, "BEGIN review_product('${pid}', '${id}', '${stars}'); END;");
		oci_execute($query);
	}
} else {
	echo "Page not found";
}
