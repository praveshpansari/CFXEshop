<!DOCTYPE html>
<html lang="en">
<?php
include 'connection.php';
session_start();
if (isset($_SESSION['loggedin'])) {
    if ($_SESSION['loggedin'] && $_SESSION['type'] == 'trader') {
        $query = oci_parse($conn, "SELECT * FROM CATEGORY");
        oci_execute($query);
        oci_fetch_all($query, $_SESSION['cat_name']);
        $_SESSION['shops'] = array();
    } else {
        echo "Please Login as a trader. Redirecting...";
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
                    <h5 class="modal-title" id="profilePicModal">Upload Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="img-demo" style="width:350px;margin:2rem auto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" style="margin:0 auto" id="crop">Upload and
                            Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="uploadProductModal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productPicModal">Upload Profile Picture</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="product-img-demo" style="width:350px;margin:2rem auto">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" style="margin:0 auto" id="cropProduct">Upload and
                            Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="trader.php">DASHBOARD</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active"><a href="trader.php" class="nav-link"><strong><?= $_SESSION['user'] ?></strong></a></li>
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
                            <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:3%;padding-bottom:3%">
                                <div class="circle">
                                    <img src="<?= $_SESSION["pic"]; ?>" class="profilepic " id="ora">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h6 class="card-title"><?= $_SESSION["user"]; ?></h6>
                                    <h5 class="card-text"><?= $_SESSION["cat"]; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="row no-gutters">

                            <div class="card-body">
                                <button class="btn-accord btn-block " id="profileUpdateBtn" type="button" data-toggle="collapse" data-target="#profileUpdate" aria-controls="profileUpdate">
                                    Update Profile
                                </button>
                                <button class="btn-accord btn-block" id="shopManageBtn" type="button" data-toggle="collapse" data-target="#shopManage" aria-controls="shopManage">
                                    Your Shops
                                </button>
                                <button class="btn-accord btn-block" id="addProductBtn" type="button" data-toggle="collapse" data-target="#addProduct" aria-controls="addProduct">
                                    Add Product
                                </button>
                                <button class="btn-accord btn-block" id="manageProductBtn" type="button" data-toggle="collapse" data-target="#manageProduct" aria-controls="manageProduct">
                                    Manage Products
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 collapse" id="profileUpdate" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Update Profile</h5>
                            <p class="card-text">
                                <form id="updateProfileT"><br>
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
                                                        <input type="email" disabled="disabled" value="<?= $_SESSION["email"] ?>" class="form-control" id="updateEmail">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="updatePassword">Password</label><a href="" class="ml-3" id="editPassword">Change Password</a>
                                                    <button id="savePassword" class="btn btn-sm float-right btn-primary col-form-label px-3" style="display:none">SAVE</button>
                                                    <input type="password" disabled="disabled" class="form-control" id="updatePassword">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-5 offset-md-1 picture">
                                                <label for="image_upload" class="avatar col-md-11 offset-md-1 mb-3" style="text-align: center;">
                                                    <img src="<?= $_SESSION["pic"]; ?>" style="cursor:pointer" class="img-fluid profilepic" />
                                                </label>
                                                <div class="custom-file col-md-11 offset-md-1">
                                                    <input type="file" class="custom-file-input trader" accept="image/*" name="image_upload" style="cursor: pointer" id="image_upload">
                                                    <label class="custom-file-label" style="cursor: pointer" for="image_upload">Choose Image</label>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset><br>
                                    <hr>
                                    <br>
                                    <div id="errInd">
                                    </div>
                                    <div id='personalInfo'>
                                        <fieldset class="personalInfo">
                                            <h6>Personal Information</h6>
                                            <div class="form-row align-items-start">
                                                <div class="form-group col-md-6">
                                                    <label for="supplierName">Trader Name</label>
                                                    <input type="text" class="form-control validate" maxlength="40" required id="supplierName" name="supplier" value="<?= $_SESSION["user"] ?>">
                                                </div>
                                                <div class="form-group col-md-5 offset-md-1">
                                                    <label for="category">Category</label>
                                                    <select id="category" class="form-control validate" required disabled>
                                                        <?php
                                                        $cat = $_SESSION['cat_name'];
                                                        for ($x = 0; $x < count($cat['CATEGORY_NO']); $x++) {
                                                            if ($cat['CATEGORY_NAME'][$x] == $_SESSION['cat']) {
                                                                echo "<option selected value=" . $cat['CATEGORY_NO'][$x]  . ">" . $cat['CATEGORY_NAME'][$x] . "</option>";
                                                            } else {
                                                                echo "<option value=" . $cat['CATEGORY_NO'][$x]  . ">" . $cat['CATEGORY_NAME'][$x] . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">

                                                <div class="form-group col-md-8">
                                                    <label for="website">Website</label>
                                                    <input type="text" class="form-control validate" maxlength="50" id="website" required name="website" value="<?= $_SESSION["website"] ?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="phone">Phone Number</label>
                                                    <input id="phone" maxlength="12" type="tel" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" class="form-control validate" required value="<?= $_SESSION["phone"] ?>" name="phoneNo">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div><br>
                                    <hr>
                                    <br>

                                    <fieldset class="address">
                                        <h6>Address Information</h6>
                                        <div class="form-group">
                                            <label for="inputAddress">Address</label>
                                            <input type="text" class="form-control validate" maxlength="30" id="inputAddress" value="<?= $_SESSION["add1"]; ?>" placeholder="1234 Main St">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress2">Address 2</label>
                                            <input type="text" class="form-control validate" maxlength="30" id="inputAddress2" value="<?= $_SESSION["add2"]; ?>" placeholder="Apartment, studio, or floor">
                                        </div>
                                    </fieldset>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 collapse" id="shopManage" data-parent="#accordian">
                    <div class="card pb-5">
                        <div class="card-body">
                            <h5 class="card-title mb-n1">Your Shops</h5>
                            <p class="card-text">
                                <h6 class="mt-5 mb-4">Shop Information</h6>

                                <?php
                                $userId = $_SESSION['id'];
                                $query = oci_parse($conn, "SELECT count(SHOP_ID) NUM FROM SHOP WHERE SUPPLIER_ID = '${userId}'");
                                $result = [1][0];
                                oci_execute($query);
                                if (oci_fetch_assoc($query)['NUM'] != 0) {
                                    $query = oci_parse($conn, "SELECT SHOP_ID, SHOP_NAME, to_char(DATED, 'DDth MONTH, YYYY') DATED FROM SHOP WHERE SUPPLIER_ID = '${userId}'");
                                    oci_execute($query); ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Reg. No.</th>
                                                    <th scope="col">Shop Name</th>
                                                    <th scope="col">Total Products</th>
                                                    <th scope="col">Date Registered</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                while ($result = oci_fetch_assoc($query)) {
                                                    array_push($_SESSION['shops'], $result);
                                                    $sid = $result['SHOP_ID'];
                                                    $q = oci_parse($conn, "BEGIN :c := shop_products('${sid}'); END;");
                                                    oci_bind_by_name($q, ":c", $count);
                                                    oci_execute($q);
                                                ?>
                                                    <tr>
                                                        <th scope="row"><?= $result['SHOP_ID'] ?></th>
                                                        <td><?= $result['SHOP_NAME'] ?></td>
                                                        <td><?= $count ?></td>
                                                        <td><?= $result['DATED'] ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else {
                                    echo "No records found";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 collapse" id="addProduct" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add a Product</h5>
                            <p class="card-text">
                                <form id="addProduct" action="" method="get">
                                    <div id="errorInfo"></div>
                                    <h6>Product Information</h6>
                                    <div class="form-row align-items-start">
                                        <div class="form-group col-md-6">
                                            <label for="product-name">Product Name</label>
                                            <input type="text" minlength="5" maxlength="30" class="form-control validate" id="product-name" name="product-name" placeholder="Product Name" required>
                                        </div>
                                        <div class="form-group col-md-5 offset-md-1">
                                            <label for="product-price">Product Price</label>
                                            <input type="number" step="0.05" min="0.50" value="0.50" max="99999" class="form-control validate" id="product-price" name="product-price" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <?php
                                            $result = $_SESSION['shops'] ?>
                                            <label for="shop-id">Shop</label>
                                            <select class="form-control" id="shop-id" name="shop-id" required>
                                                <option hidden selected disabled>Select Shop</option>
                                                <?php
                                                for ($x = 0; $x < count($result); $x++) {
                                                    echo "<option value=" . $result[$x]['SHOP_ID']  . ">" . $result[$x]['SHOP_NAME'] . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-5 offset-md-1">
                                            <label for="quanPerItem">Quantity per Item</label>
                                            <div class="row no-gutters">
                                                <div class="col-md-5">
                                                    <input id="quanPerItem" type="number" min="1" max="19999" class="form-control validate" value="100" name="quanPerItem" required></div>
                                                <div class="col-md-6 offset-md-1">
                                                    <select class="form-control validate" id="unit" name="unit" required>
                                                        <option selected="selected" disabled hidden>Select Unit</option>
                                                        <option value="grams">grams</option>
                                                        <option value="pounds">pounds</option>
                                                        <option value="pieces">pieces</option>
                                                        <option value="slices">slices</option>
                                                        <option value="ml">ml</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="allergy">Allergy Information</label>
                                            <input type="text" class="form-control" maxlength="100" name="allergy" id="allergy" placeholder="Allergens">
                                        </div>
                                        <div class="form-group col-md-2 offset-md-1">
                                            <label for="min-order">Min. Quantity</label>
                                            <input type="number" name="min-order" min="1" max="999" class="form-control validate " id="min-order" value="1" required>
                                        </div>
                                        <div class="form-group col-md-2 offset-md-1">
                                            <label for="max-order">Max. Quantity</label>
                                            <input type="number" min="1" max="999" class="form-control validate" name="max-order" id="max-order" value="10" required>
                                        </div>
                                    </div>
                                    <div class="form-row align-items-end">
                                        <div class="form-group col-md-6">
                                            <label for="stock-amount">Stock Amount</label>
                                            <input type="number" min="1" max="9999" class="form-control col-md-6 validate" name="stock-amount" id="stock-amount" value="1" required>
                                            <br>
                                            <label for="description">Product Description</label>
                                            <textarea rows="5" maxlength="250" minlength="50" class="form-control validate" name="description" id="description" placeholder="A short product description" required></textarea>
                                        </div>
                                        <div class="form-group col-md-5 offset-md-1 picture">
                                            <label for="product-image" class="avatar col-md-11 offset-md-1 mb-3" style="text-align: center;">
                                                <img src="images/product-demo.png" style="cursor:pointer" class="img-fluid product-pic" />
                                            </label>
                                            <div class="custom-file col-md-11 offset-md-1">
                                                <input type="file" class="custom-file-input trader form-control validate" accept="image/*" name="product-image" style="cursor: pointer" id="product-image" required>
                                                <label class="custom-file-label" style="cursor: pointer" for="product-image">Choose Image</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <button type="reset" id="resetBtn" class="btn btn-primary col-md-3 offset-md-5">Reset Fields</button>
                                        <button type="submit" id="submitProduct" class="btn btn-primary col-md-3 offset-md-1">Add Product</button>
                                    </div>
                                </form>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 collapse" id="manageProduct" data-parent="#accordian">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Manage Your Products</h5>
                            <p class="card-text" id="manageProductPara">
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