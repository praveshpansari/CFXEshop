<!DOCTYPE html>
<html lang="en">
<?php
include 'connection.php';
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin'] && $_SESSION['type'] == 'admin') {
        $query = oci_parse($conn, "SELECT * FROM CATEGORY");
        oci_execute($query);
        oci_fetch_all($query, $_SESSION['cat_name']);
        $_SESSION['shops'] = array();
    } else {
        echo "Please Login as a admin. Redirecting...";
        header('Refresh: 2,URL=http://localhost/website/index.php');
        die();
    }
} else {
    echo "You are not allowed to access this page.Redirecting...";
    header('Refresh: 2,URL=http://localhost/website/index.php');
    die();
} ?>

<head>
    <title>CFX eShop</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC:400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/croppie.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">


    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body class="goto-here dashboard">

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="admin.php">ADMIN PANEL</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="admin.php" class="nav-link"><strong><?= $_SESSION['user'] ?></strong></a></li>
                    <li class="nav-item btn-nav"><a href="logout.php" class="nav-link">LOGOUT</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <section class="ftco-section profile bg-light">
        <div class="container">
            <div class="row accordion" id="accordian">
                <div class="col-lg-4 mb-3">
                    <div class=" card">
                        <div class="row no-gutters">
                            <div class="card-body justify-content-center text-center">
                                <h6 class="card-title">Hello! <?= $_SESSION["user"]; ?></h6>
                                <h5 class="card-text"><?= $_SESSION["email"]; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="row no-gutters">

                            <div class="card-body">
                                <button class="btn-accord btn-block" id="manageTradersBtn" type="button" data-toggle="collapse" data-target="#manageTraders" aria-controls="manageTraders">
                                    Access Traders
                                </button>
                                <button class="btn-accord btn-block" id="approveTradersBtn" type="button" data-toggle="collapse" data-target="#approveTraders" aria-controls="approveTraders">
                                    Approve Traders
                                </button>
                                <button class="btn-accord btn-block" id="manageUsersBtn" type="button" data-toggle="collapse" data-target="#manageUsers" aria-controls="manageUsers">
                                    Manage Users
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 collapse" id="manageTraders" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Manage Traders</h5>
                            <p class="card-text">
                                <h6 class="mt-5 mb-4">Trader Information</h6>
                                <div class="table-responsive">
                                    <table id="traderTable" class="table table-hover">
                                        <thead class='thead-dark'>
                                            <tr>
                                                <th scope='col' style="width: 20% !important;">Trader Name</th>
                                                <th scope='col' style="width: 16% !important;">Category</th>
                                                <th scope='col' style="width: 25% !important;">Shops</th>
                                                <th scope='col' style="width: 12% !important;">Access</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = oci_parse($conn, "SELECT TRADER_ID,TRADER_NAME,CATEGORY_NAME,  LISTAGG('[' || SHOP_NAME || ']', '<br>') WITHIN GROUP (ORDER BY SHOP_NAME) AS SHOPS FROM TRADER, SHOP,CATEGORY WHERE TRADER.TRADER_ID = SHOP.SUPPLIER_ID AND TRADER.CATEGORY_NO = CATEGORY.CATEGORY_NO AND APPROVED = 'Y' GROUP BY TRADER_NAME,TRADER_ID,CATEGORY_NAME");
                                            oci_execute($query);
                                            while ($result = oci_fetch_assoc($query)) {
                                                echo "<tr>
                                                        <td>" . $result['TRADER_NAME'] . "</td>
                                                        <td>" . $result['CATEGORY_NAME'] . "</td>
                                                        <td>" . $result['SHOPS'] . "</td>
                                                        <td><a class='btn btn-dark access' id='" . $result['TRADER_ID'] . "' style='font-weight:bold;font-size:small;color:white;border-radius:0'>ACCESS</td>
                                                </tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 collapse" id="approveTraders" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Approve Traders</h5>
                            <p class="card-text">
                                <h6 class="mt-5 mb-4">Trader Requests</h6>

                                <?php
                                $query = oci_parse($conn, "SELECT count(*) num FROM TRADER WHERE APPROVED = 'N'");
                                oci_execute($query);
                                $result = oci_fetch_assoc($query);
                                if ($result['NUM'] > 0) {

                                ?><div class="table-responsive">
                                        <table id="approveTable" class="table table-hover">
                                            <thead class='thead-dark'>
                                                <tr>
                                                    <th scope='col' style="width: 20% !important;">Trader Name</th>
                                                    <th scope='col' style="width: 20% !important;">Category</th>
                                                    <th scope='col' style="width: 15% !important;">Website</th>
                                                    <th scope='col' style="width: 15% !important;">Approval</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = oci_parse($conn, "SELECT TRADER_ID,TRADER_NAME,CATEGORY_NAME,WEBSITE FROM TRADER, USERS,CATEGORY WHERE TRADER.TRADER_ID = USERS.USER_ID AND TRADER.CATEGORY_NO = CATEGORY.CATEGORY_NO AND APPROVED = 'N'");
                                                oci_execute($query);
                                                while ($result = oci_fetch_assoc($query)) {
                                                    echo "<tr>
                                                        <td>" . $result['TRADER_NAME'] . "</td>
                                                        <td>" . $result['CATEGORY_NAME'] . "</td>
                                                        <td>" . $result['WEBSITE'] . "</td>
                                                        <td><a class='btn btn-dark approve' id='" . $result['TRADER_ID'] . "' style='font-weight:bold;font-size:small;color:white;border-radius:0'>APPROVE</td>
                                                </tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else {
                                    echo "NO NEW TRADER REQUESTS";
                                } ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 collapse" id="manageUsers" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Manage Users</h5>
                            <p class="card-text">
                                <h6 class="mt-5 mb-4">User Information</h6>
                                <div id="errorInfo"></div>
                                <div class="table-responsive">
                                    <table id="userTable" class="table table-hover">
                                        <thead class='thead-dark'>
                                            <tr>
                                                <th scope='col' style="width: 20% !important;">Name</th>
                                                <th scope='col' style="width: 20% !important;">Account Type</th>
                                                <th scope='col' style="width: 15% !important;">Email</th>
                                                <th scope='col' style="width: 15% !important;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = oci_parse($conn, "SELECT USER_ID,EMAIL,TYPE FROM USERS WHERE TYPE != 'A'");
                                            oci_execute($query);
                                            while ($result = oci_fetch_assoc($query)) {
                                                echo "<tr>";
                                                $nid = $result['USER_ID'];
                                                if ($result['TYPE'] == 'T') {
                                                    $q = oci_parse($conn, "SELECT TRADER_NAME username FROM TRADER WHERE TRADER_ID = '${nid}'");
                                                } else if ($result['TYPE'] == 'C') {
                                                    $q = oci_parse($conn, "SELECT FIRST_NAME || ' ' || LAST_NAME username FROM CUSTOMER WHERE CUSTOMER_ID = " . $result['USER_ID']);
                                                }
                                                oci_execute($q);
                                                $c = oci_fetch_assoc($q)['USERNAME'];
                                                echo "<td>" . $c . "</td>
                                                        <td>" . (($result['TYPE'] == 'T') ? "TRADER" : "CUSTOMER") . "</td>
                                                        <td>" . $result['EMAIL'] . "</td>
                                                        <td><a class='btn btn-dark delete-user' id='" . $nid  . "' style='font-weight:bold;font-size:small;color:white;border-radius:0'>DELETE</td>
                                                </tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END section-->
    <footer class="ftco-footer ftco-section">
        <div class="container">
            <div class="row">
                <div class="mouse">
                    <a href="#" class="mouse-icon">
                        <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                    </a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">CFX eShop</h2>
                        <p>We aim to provide the best quality and fresh products from all the local traders of the
                            Cleckhuddersfax
                            area to you at your convenience and feasible rates.</p>
                        <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4 ml-md-5">
                        <h2 class="ftco-heading-2">Menu</h2>
                        <ul class="list-unstyled">
                            <li><a href="#" class="py-2 d-block">Shop</a></li>
                            <li><a href="#" class="py-2 d-block">About</a></li>
                            <li><a href="#" class="py-2 d-block">Journal</a></li>
                            <li><a href="#" class="py-2 d-block">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Help</h2>
                        <div class="d-flex">
                            <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
                                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
                                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
                                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
                            </ul>
                            <ul class="list-unstyled">
                                <li><a href="#" class="py-2 d-block">FAQs</a></li>
                                <li><a href="#" class="py-2 d-block">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="ftco-footer-widget mb-4">
                        <h2 class="ftco-heading-2">Have a Questions?</h2>
                        <div class="block-23 mb-3">
                            <ul>
                                <li><span class="icon icon-map-marker"></span><span class="text">11 Avenue Street,
                                        Cleckshudderfax, UK</span></li>
                                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929
                                            210</span></a></li>
                                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@cfx.com</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">

                    <p> Copyright &copy;2020 All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
        </svg>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/croppie.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script type="text/javascript" src="lib/DataTables/datatables.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function() {
            $('#traderTable').DataTable();
            $('#userTable').DataTable();
        });

        $('.access').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                url: "action.php",
                method: "GET",
                data: {
                    access: 1,
                    id: id
                },
                success: function(response) {
                    if (response == 'success')
                        window.location = 'trader.php';
                }
            });
        });

        $('.delete-user').click(function() {
            var id = $(this).attr('id');

            $.ajax({
                url: "action.php",
                method: "GET",
                data: {
                    delete: 1,
                    id: id
                },
                success: function(response) {
                    localStorage.setItem('doneDelete', 'yes');
                    location.reload();
                }
            });
        });

        $(document).ready(function() {
            if (localStorage.getItem('doneDelete') == 'yes') {
                $("#errorInfo").html(
                    '<div class="toast mt-n4 mb-4" data-autohide="false" id="wrong_email"><div class="toast-header"><strong style="color:#f76666"> Success!</strong><button type="button" class="close" data-dismiss="toast">&times;</button></div><div class="toast-body" style="text-align:left" id="aerror">User successfully deleted!</div></div>'
                );
                $("#wrong_email").toast("show");
                localStorage.setItem('doneDelete', 'no');
            }
        });
    </script>

</body>

</html>