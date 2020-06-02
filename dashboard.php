<!DOCTYPE html>
<html lang="en">
<?php
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin']) {
        if ($_SESSION['type'] != 'customer')
            header('location:trader.php');
    } else {
        echo "You are logged out. Please log in. Redirecting...";
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


    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="uploadImageModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="img-demo" style="width:350px;margin:2rem auto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" style="margin:0 auto" id="crop">Upload and Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="py-1 bg-primary">
        <div class="container">
            <div class="row no-gutters d-flex align-items-start align-items-center px-md-0">
                <div class="col-lg-12 d-block">
                    <div class="row d-flex">
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-phone2"></span></div>
                            <span class="text">+ 1235 2355 98</span>
                        </div>
                        <div class="col-md pr-4 d-flex topper align-items-center">
                            <div class="icon mr-2 d-flex justify-content-center align-items-center"><span class="icon-paper-plane"></span></div>
                            <span class="text">eshop@cfx.com</span>
                        </div>
                        <div class="col-md-5 pr-4 d-flex topper align-items-center text-lg-right">
                            <span class="text">3-5 Business days &amp; Free Returns</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">CFX eShop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="shop.php" class="nav-link">Shop</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
                    <li class="nav-item active"><a href="dashboard.php" class="nav-link">Profile</a></li>
                    <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span>[0]</a></li>
                    <li class="nav-item btn-nav"><a href="logout.php" class="nav-link">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END nav -->
    <section class="ftco-section profile bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="card">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:3%;padding-bottom:3%">
                                <div class="circle">
                                    <img src="<?php echo $_SESSION["pic"]; ?>" class="profilepic" id="ora">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title">Hello! <?php echo $_SESSION["user"]; ?></h6>
                                    <h5 class="card-text"><?php echo $_SESSION["first"] . " " . $_SESSION["last"]; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="row no-gutters">
                            <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:3%;padding-bottom:3%">
                                <div class="circle">
                                    <img src="images/image_6.jpg" id="ora">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title">Hello! <?php echo $_SESSION["user"]; ?></h6>
                                    <h5 class="card-text"><?php echo $_SESSION["first"] . " " . $_SESSION["last"]; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Profile</h5>
                            <p class="card-text">
                                <form id="updateProfile"><br>
                                    <fieldset class="accInfo">
                                        <h6>Account Information</h6>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div id="errorInf">
                                                </div>
                                                <input type="hidden" id="userId" value="<?= $_SESSION['id'] ?>">

                                                <div class="form-group">
                                                    <label for="updateEmail">Email</label><a href="" class="ml-5" id="editEmail">Edit</a>
                                                    <button id="saveEmail" class="btn btn-sm float-right btn-primary col-form-label px-3" style="display:none">SAVE</button>
                                                    <div id="upEm">
                                                        <input type="email" disabled="disabled" value="<?php echo $_SESSION["email"] ?>" class="form-control" id="updateEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="updatePassword">Password</label><a href="" class="ml-3" id="editPassword">Change Password</a>
                                                    <button id="savePassword" class="btn btn-sm float-right btn-primary col-form-label px-3" style="display:none">SAVE</button>
                                                    <input type="password" disabled="disabled" value="" class="form-control" id="updatePassword">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-5 offset-md-1 picture">
                                                <label for="image_upload" class="avatar col-md-11 offset-md-1 mb-3" style="text-align: center;">
                                                    <img src="<?php echo $_SESSION["pic"]; ?>" style="cursor:pointer" class="img-fluid profilepic" />
                                                </label>
                                                <div class="custom-file col-md-11 offset-md-1">
                                                    <input type="file" class="custom-file-input" accept="image/*" name="image_upload" style="cursor: pointer" id="image_upload">
                                                    <label class="custom-file-label" style="cursor: pointer" for="image_upload">Choose Image</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset><br>
                                    <hr>
                                    <br>
                                    <div id="errInd">
                                        </div>
                                    <div id="personalInfo">
                                        
                                        <fieldset class="personalInfo">

                                            <h6>Personal Information</h6>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" class="form-control validate" id="firstName" value="<?php echo $_SESSION["first"] ?>" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="lastName">Last Name</label>
                                                    <input type="text" class="form-control validate" id="lastName" value="<?php echo $_SESSION["last"] ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label>
                                                        <h6 style="font-weight: normal">Sex</h6>
                                                    </label><br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="male" <?php echo ($_SESSION['sex'] == 'M') ?  "checked" : '' ?> value="M" name="gender" class="custom-control-input">
                                                        <label class="custom-control-label" style="color:#82ae46;" for="male">
                                                            <h6>Male</h6>
                                                        </label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="female" <?php echo ($_SESSION['sex'] == 'F') ? "checked" : '' ?> value="F" name="gender" class="custom-control-input">
                                                        <label class="custom-control-label" style="color:#82ae46" for="female">
                                                            <h6>Female</h6>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="phone">Phone Number</label>
                                                    <input id="phone" maxlength="12" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" class="form-control validate" value="<?php echo $_SESSION["phone"] ?>" name="phoneNo" required>
                                                </div>
                                                <div class="form-group col-md-3 offset-md-1">
                                                    <label for="age" class="ml-2">Age</label>
                                                    <input type="range" class="custom-range col-10 ml-2" value="<?php echo $_SESSION["age"] ?>" name="age" id="age" min="16" max="100" onchange="updateAge(this.value)" />
                                                    <span id="ageValue" class="offset-10"><?php echo $_SESSION["age"] ?></span>
                                                </div>
                                            </div>
                                        </fieldset><br>
                                        <hr>
                                        <br>
                                        <fieldset class="address">
                                            <h6>Address Information</h6>
                                            <div class="form-group">
                                                <label for="inputAddress">Address</label>
                                                <input type="text" class="form-control validate" id="inputAddress" maxlength="30" value="<?php echo $_SESSION["add1"]; ?>" placeholder="1234 Main St">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputAddress2">Address 2</label>
                                                <input type="text" class="form-control validate" id="inputAddress2" maxlength="30" value="<?php echo $_SESSION["add2"]; ?>" placeholder="Apartment, studio, or floor">
                                            </div>
                                        </fieldset>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
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
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
</body>

</html>