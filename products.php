<?php
include 'connection.php';
session_start();
$items = 12;

isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;

if ($page > 1) {
    $start = ($page * $items) - $items + 1;
    $upper = $start + $items - 1;
} else {
    $start = 1;
    $upper = $items;
}

$_SESSION['page'] = $page;

$output = '<div class="row">';

$query = oci_parse($conn, "SELECT count(*) NUM FROM PRODUCT");
oci_execute($query);
$totalRows = oci_fetch_assoc($query)["NUM"];

$totalPages = $totalRows / $items + 1;

$query = oci_parse($conn, "SELECT * FROM (SELECT t.*, Row_Number() OVER (ORDER BY PRODUCT_ID) MyRow FROM PRODUCT t) WHERE MyRow BETWEEN '${start}' AND '${upper}'");
oci_execute($query);

while ($result = oci_fetch_assoc($query)) {

    $name = $result['PRODUCT_NAME'];
    $price = number_format($result['PRICE'], 2);
    $min = $result['MIN_ORDER'];
    $image = $result['PRODUCT_IMAGE'];
    $prodId = $result['PRODUCT_ID'];
    $discountQuery = oci_parse($conn, "SELECT OFFER FROM SHOP_PRODUCT WHERE PRODUCT_ID = '${prodId}'");
    oci_execute($discountQuery);
    $discount = oci_fetch_assoc($discountQuery)['OFFER'];
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
        $cart = $_SESSION['cartId'];
        $inCartQuery = oci_parse($conn, "BEGIN :count := check_cart('${cart}', '${prodId}'); END;");
        oci_bind_by_name($inCartQuery, ":count", $count);
        oci_execute($inCartQuery);
    }
    $output .= "<div class='col-md-6 col-lg-3 ftco-animate'>
    <div class='product'>
        <a href='product-single.php?product=" . $prodId . "' class='img-prod'><img class='img-fluid product-pic' src='$image'>
        " . (($discount != 0) ? "<span class='status'>$discount%</span>" : "") . "
        <div class='overlay'></div>
        </a>
        <div class='text py-3 pb-4 px-3 text-center'>
            <h3><a href='#' class='product-name'>$name</a></h3>
            <div class='d-flex'>
                <div class='pricing'>
                    <p class='price'>
                        " . (($discount != 0) ? "<span class='mr-2 price-dc'>$$discount</span>" : "") . "
                        <span class='price-sale'>$$price</span></p>
                </div>
            </div>
            <div class='bottom-area d-flex px-3'>
                <div class='m-auto d-flex'>
                    <a href='product-single.php?product=$prodId' class='add-to-cart d-flex justify-content-center align-items-center text-center'>
                        <span><i class='ion-ios-menu'></i></span>
                    </a>
                    <input type='hidden' id='min-quantity' value='$min'>
                    <a id='$prodId' class='buy-now d-flex justify-content-center align-items-center mx-1' style='cursor:pointer'>
                        <span><i class='" . ((isset($_SESSION['loggedin']) && $count > 0) ? "ion-md-close" : "ion-ios-cart") . "'></i>
                        </span>
                    </a>
                    <a href='#' class='heart d-flex justify-content-center align-items-center '>
                        <span><i class='ion-ios-heart'></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
";
}
$output .=  "</div><div class='row mt-5'><div class='col text-center'><div class='block-27'><ul id='paginate'>";

for ($x = 1; $x <= $totalPages; $x++) {

    $output .=  "<li class='mx-2 pag_link page-item " . (($_SESSION['page'] == $x) ? "active disabled" : "") . "'  style='cursor:pointer'><a class='page-link' id='" . $x . "'>" . $x . "</a></li>";
}
$output .= "</ul></div></div></div>";
echo $output;
