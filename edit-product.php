<?php
include 'connection.php';

session_start();
$output = "";
$id = $_SESSION['id'];
if (isset($_GET['view'])) {
    $query = oci_parse($conn, "SELECT count(*) NUM FROM SUPPLIER_PRODUCTS WHERE SUPPLIER_ID = '${id}'");
    oci_execute($query);
    $totalRows = oci_fetch_assoc($query)['NUM'];


    if ($totalRows > 0) {
        $items = 8;
        $totalPages = $totalRows / $items + 1;

        isset($_GET['sort']) ? $sort = $_GET['sort'] : $sort = "PRODUCT_NAME";

        isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;

        if ($page > 1) {
            $start = ($page * $items) - $items + 1;
            $upper = $start + $items - 1;
        } else {
            $start = 1;
            $upper = $items;
        }

        $output .= "<h6 class='mt-5 mb-4'>Your Products</h6><nav aria-label='Page navigation example'>
        <ul class='pagination-bs justify-content-end' id='$page'>" .
            (($page != 1) ? "<li class='page-item-bs'><a class='page-link-bs prev' id='$page'>Previous</a></li>" : "");

        for ($i = 1; $i <= $totalPages; $i++) {
            $output .= "<li class='page-item-bs'><a class='page-link-bs' id='$i'>$i</a></li>";
        }

        $output .=  (($page != (int) $totalPages) ? "<li class='page-item-bs'><a class='page-link-bs next' id='$page'>Next</a></li>" : "") .
            "</ul>
    </nav>
    <div class='table-responsive'>
        <table class='table table-hover'>
            <thead class='thead-dark'>
                <tr>
                    <th scope='col' style='width: 21%'>Product Image</th>
                    <th scope='col'>Product Name</th>
                    <th scope='col'><a  id='sort-price' style='cursor:pointer'>Price</a></th>
                    <th scope='col'>Stock Remaining</th>
                    <th scope='col'>Shop</th>
                </tr>
            </thead>
            <tbody>";

        $query = oci_parse($conn, "SELECT * FROM (SELECT t.*, Row_Number() OVER (ORDER BY PRODUCT_NAME) MyRow FROM SUPPLIER_PRODUCTS t WHERE SUPPLIER_ID = '${id}') WHERE MyRow BETWEEN '${start}' AND '${upper}' ORDER BY {$sort} ");
        oci_execute($query);
        while ($result = oci_fetch_assoc($query)) {
            $output .= "<tr class='edit-product' style='cursor:pointer' id='" . $result['PRODUCT_ID'] . "'>
                        <td style='padding-top:5px;padding-bottom:5px'><img class='img-fluid' src='" . $result['PRODUCT_IMAGE'] . "'></td>
                        <td>" . $result['PRODUCT_NAME'] . "</td>
                        <td>$" . $result['PRICE'] . "</td>
                        <td>" . $result['STOCK_AMOUNT'] . "</td>
                        <td>" . $result['SHOP_NAME'] . "</td>
                    </tr>";
        }
        $output .= "</tbody>
        </table>
    </div>";
    } else {
        $output = 'no';
    }
} else if (isset($_GET['edit']) && isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    $page = $_GET['page'];
    $query = oci_parse($conn, "SELECT * FROM PRODUCT NATURAL JOIN SHOP_PRODUCT WHERE PRODUCT_ID = '${pid}'");
    oci_execute($query);
    $result = oci_fetch_assoc($query);
    $unit = explode(" ", $result['QUANTITY']);
    $output .= "<button type='button' id='deleteBtn' class='btn btn-danger mt-n2 mb-4 float-right'>Delete Product</button><h6 class='mt-5 mb-4'>Edit Product</h6>
    
    <p class='card-text'>
    <form id='editProduct' method='get'>
    <div id='errorInfo-edit'></div>";
    $output .= "<div class='form-row align-items-start'>
    <input type='hidden' id='pid' value='$pid'><input type='hidden' id='pid' value='$pid'>
        <div class='form-group col-md-6'>
            <label for='product-name'>Product Name</label>
            <input type='text' minlength='5' maxlength='30' value='" . $result['PRODUCT_NAME'] . "' class='form-control validate' id='product-name-edit' name='product-name' placeholder='Product Name' required>
        </div>
        <div class='form-group col-md-5 offset-md-1'>
            <label for='product-price'>Product Price</label>
            <input type='number' step='0.05' min='0.50' value='" . $result['PRICE'] . "' max='99999' class='form-control validate' id='product-price-edit' name='product-price' required>
        </div>
    </div>
    <div class='form-row'>
        <div class='form-group col-md-5'>
            <label for='quanPerItem'>Quantity per Item</label>
            <div class='row no-gutters'>
                <div class='col-md-5'>
                    <input id='quanPerItem-edit' type='number' min='1' max='19999' class='form-control validate' value='$unit[0]' name='quanPerItem' required></div>
                <div class='col-md-6 offset-md-1'>
                    <select class='form-control validate' id='unit-edit' name='unit' required>
                        <option disabled hidden>Select Unit</option>
                        <option " . ((strpos($unit[1], "grams") !== false) ? "selected" : "") . " value='grams'>grams</option>
                        <option " . ((strpos($unit[1], "pound") !== false) ? "selected" : "") . " value='pounds'>pounds</option>
                        <option " . ((strpos($unit[1], "piece") !== false) ? "selected" : "") . " value='pieces'>pieces</option>
                        <option " . ((strpos($unit[1], "slice") !== false) ? "selected" : "") . " value='slices'>slices</option>
                        <option " . ((strpos($unit[1], "ml") !== false) ? "selected" : "") . " value='ml'>ml</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class='form-row'>
        <div class='form-group col-md-6'>
            <label for='allergy'>Allergy Information</label>
            <input type='text' class='form-control' value='" . $result['ALLERGY'] . "' maxlength='100' name='allergy' id='allergy-edit' placeholder='Allergens'>
        </div>
        <div class='form-group col-md-2 offset-md-1'>
            <label for='min-order'>Min. Quantity</label>
            <input type='number' name='min-order' min='1' max='999' class='form-control validate ' id='min-order-edit'  value='" . $result['MIN_ORDER'] . "' required>
        </div>
        <div class='form-group col-md-2 offset-md-1'>
            <label for='max-order'>Max. Quantity</label>
            <input type='number' min='1' max='999' class='form-control validate' name='max-order' id='max-order-edit'  value='" . $result['MAX_ORDER'] . "' required>
        </div>
    </div>
    <div class='form-row align-items-end'>
        <div class='form-group col-md-6'>
            <label for='stock-amount'>Stock Amount</label>
            <input type='number' min='1' max='9999' class='form-control col-md-6 validate' name='stock-amount' id='stock-amount-edit'  value='" . $result['STOCK_AMOUNT'] . "' required>
            <br>
            <label for='description'>Product Description</label>
            <textarea rows='5' maxlength='250' minlength='50' class='form-control validate' name='description' id='description-edit' placeholder='A short product description' required>" . $result['DESCRIPTION'] . "</textarea>
        </div>
        <div class='form-group col-md-5 offset-md-1 picture'>
            <label for='product-image' class='avatar col-md-11 offset-md-1 mb-3' style='text-align: center;'>
                <img src='" . $result['PRODUCT_IMAGE'] . "' style='cursor:pointer' class='img-fluid product-pic-edit' />
            </label>
            <div class='custom-file col-md-11 offset-md-1'>
                <input type='file' value='" . $result['PRODUCT_IMAGE'] . "' class='custom-file-input trader form-control' accept='image/*' name='product-image' style='cursor: pointer' id='product-image'>
                <label class='custom-file-label' style='cursor: pointer' for='product-image'>Choose Image</label>
            </div>
        </div>
    </div>
    <br>
    <div class='form-row'>
    <button type='button' id='$page' class='btn btn-info withPage backBtn col-md-2'>Cancel</button>
        <button type='reset' id='resetBtn' class='btn btn-dark col-md-3 offset-md-3'>Reset Fields</button>
        <button type='submit' id='editProduct' class='btn btn-primary col-md-3 offset-md-1'>Update Product</button>
    </div>";
} else if (isset($_GET['pname']) && isset($_GET['pid']) && isset($_GET['price']) && isset($_GET['allergy']) && $_GET['description'] != NULL && isset($_GET['min']) && isset($_GET['max']) && isset($_GET['stock']) && isset($_GET['pimg']) && isset($_GET['quantity'])) {

    $pid = $_GET['pid'];
    $pname = $_GET['pname'];
    $price = $_GET['price'];
    $description = $_GET['description'];
    $min = $_GET['min'];
    $max = $_GET['max'];
    $stock = $_GET['stock'];
    $pimg = $_GET['pimg'];
    $quantity = $_GET['quantity'];
    $allergy = $_GET['allergy'];

    $query = oci_parse($conn, "UPDATE PRODUCT SET PRODUCT_NAME = '${pname}',PRICE = '${price}',DESCRIPTION = '${description}',MIN_ORDER = '${min}',MAX_ORDER = '${max}',PRODUCT_IMAGE = '${pimg}',ALLERGY = '${allergy}' WHERE PRODUCT_ID = '${pid}'");
    oci_execute($query);
    $query = oci_parse($conn, "UPDATE SHOP_PRODUCT SET STOCK_AMOUNT = '${stock}' WHERE PRODUCT_ID = '${pid}'");
    oci_execute($query);

    $output = "okay";
} else if (isset($_GET['delete']) && isset($_GET['pid']) && isset($_GET['pimg'])) {

    $pid = $_GET['pid'];
    $pimg = $_GET['pimg'];
    unlink($pimg);
    $query = oci_parse($conn, "DELETE FROM SHOP_PRODUCT WHERE PRODUCT_ID = '${pid}'");
    oci_execute($query);
    $query = oci_parse($conn, "DELETE FROM PRODUCT WHERE PRODUCT_ID = '${pid}'");
    oci_execute($query);
    $output = "deleted";
}

echo $output;
