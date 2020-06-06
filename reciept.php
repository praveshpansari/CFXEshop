<?php
require_once 'dompdf/autoload.inc.php';
include 'connection.php';
session_start();

use Dompdf\Dompdf;

if (isset($_SESSION['loggedin'])) {

  if (isset($_POST['payment'])) {
    $cart = $_SESSION['cartId'];
    $query = oci_parse($conn, "BEGIN :count := num_products('{$cart}'); END;");
    oci_bind_by_name($query, ":count", $count);
    oci_execute($query);
    if ($count != 0) {

      $slot = $_POST['slot'];
      $f = $_SESSION['first'];
      $l = $_SESSION['last'];
      $cmail = $_SESSION['email'];
      $add1 = $_SESSION['add1'];
      $add2 = $_SESSION['add2'];
      $tid = md5(time() . $f);
      $query = oci_parse($conn, "SELECT * FROM CART WHERE CART_ID = '${cart}'");
      oci_execute($query);
      $result = oci_fetch_assoc($query);
      $amount = $result['NET_AMOUNT'];
      $query = oci_parse($conn, "INSERT INTO INVOICE VALUES (DEFAULT,'{$tid}',DEFAULT,DEFAULT,'{$slot}','{$cart}', '${amount}')");
      oci_execute($query);
      $query = oci_parse($conn, "UPDATE COLLECTION_SLOT SET ORDERS = ORDERS + 1 WHERE SLOT_ID = '${slot}'");
      oci_execute($query);
      $query = oci_parse($conn, "SELECT * FROM INVOICE WHERE CART_ID = '${cart}' AND TRANSACTION_ID = '{$tid}'");
      oci_execute($query);
      $result = oci_fetch_assoc($query);
      $query = oci_parse($conn, "SELECT * FROM AVAILABLE_SLOTS WHERE SLOT_ID = '${slot}'");
      oci_execute($query);
      $time = oci_fetch_assoc($query);

      $invoice = $result["INVOICE_NO"];
      $cid = $_SESSION['id'];
      $document = new Dompdf();
      $output = '
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
  <style>
    @font-face {
      font-family: SourceSansPro;
      src: url(SourceSansPro-Regular.ttf);
    }

    a {
      color: #0087C3;
      text-decoration: none;
    }

    body {  
      position: relative;
      margin: 0 auto;
      color: #555555;
      background: #FFFFFF;
      font-family: Calibri;
      font-size: 14px;
      font-family: SourceSansPro;
    }

    header {
      margin-bottom: 20px;
      border-bottom: 1px solid #AAA;
    }

    #logo {
      margin-top: 8px;
    }

    #logo img {
      height: 70px;
    }

    #company {
      text-align: right;
    }

    #details {
      margin-bottom: 50px;
    }

    #client {
      padding-left: 6px;
      border-left: 6px solid #0087C3;
    }

    #client .to {
      color: #777777;
    }

    h2.name {
      font-size: 1.4em;
      font-weight: normal;
      margin: 0;
    }

    #invoice {
      float: right;
      text-align: right;
    }

    #invoice h1 {
      color: #0087C3;
      font-size: 2.4em;
      line-height: 1em;
      font-weight: normal;
      margin: 0 0 10px 0;
    }

    #invoice .date {
      font-size: 1.1em;
      color: #777777;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      margin-bottom: 20px;
    }

    table th,
    table td {
      padding: 5px 10px;
      background: #EEEEEE;
      text-align: center;
      border-bottom: 1px solid #FFFFFF;
    }

    table th {
      white-space: nowrap;
      font-weight: normal;
    }

    table td {
      text-align: right;
    }

    table td h3 {
      color: #57B223;
      font-size: 1.15em;
      font-weight: normal;
      margin: 0 0 0.2em 0;
    }

    table .no {
      color: #FFFFFF;
      font-size: 1.6em;
      background: #57B223;
    }

    table .desc {
      text-align: left;
    }

    table .unit {
      background: #DDDDDD;
    }

    table .qty {}

    table .total {
      background: #57B223;
      color: #FFFFFF;
    }

    table td.unit,
    table td.qty,
    table td.total {
      font-size: 1.2em;
    }

    table tbody tr:last-child td {
      border: none;
    }

    table tfoot td {
      padding: 10px 20px;
      background: #FFFFFF;
      border-bottom: none;
      font-size: 1.2em;
      white-space: nowrap;
      border-top: 1px solid #AAAAAA;
    }

    table tfoot tr:first-child td {
      border-top: none;
    }

    table tfoot tr:last-child td {
      color: #57B223;
      font-size: 1.4em;
      border-top: 1px solid #57B223;

    }

    strong {
      font-weight:bold;
      font-family:Calibri !important;
      font-size:0.65rem;
      color: #0087C3;
    }

    table tfoot tr td:first-child {
      border: none;
    }

    #thanks {
      font-size: 2em;
      margin-bottom: 50px;
    }

    #notices {
      padding-left: 6px;
      border-left: 6px solid #0087C3;
    }

    #notices .notice {
      font-size: 1.2em;
    }

    footer {
      color: #777777;
      width: 100%;
      height: 30px;
      position: absolute;
      bottom: 0;
      border-top: 1px solid #AAAAAA;
      padding: 8px 0;
      text-align: center;
    }
  </style>
</head>
<body>

  <header><div class="row no-gutters" style="padding-bottom:-4.5em;">
    <div  id="logo">
      <img src="logo.png">
    </div>
    <div class="col-md-4" id="company">
      <h2 class="name">CFX eShop</h2>
      <div>11 Avenue Street, Cleckshudderfax, UK</div>
      <div>(123) 456-7890</div>
      <div><a href="mailto:cfxeshop@gmail.com">cfxeshop@gmail.com</a></div>
    </div>
    </div></div>
  </header>
  
  <main>
    <div id="details" class="row no-gutters">
      <div id="client">
        <div class="to">RECIEPT TO:</div>
        <h2 class="name">' . $f . ' ' . $l . '</h2>
        <div class="address">' . $add1 . ' ' . $add2 . '</div>
        <div class="email"><a href="mailto:' . $cmail . '">' . $cmail . '</a></div>
      </div>
      <div class="col-md-6" id="invoice">
        <h1>RECIEPT ' . $result["INVOICE_NO"] . '</h1>
        <div class="date">Date of Payment: ' . $result["PAYMENT_DATE"] . '</div>
      </div>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="no" >#</th>
          <th class="desc" >DESCRIPTION</th>
          <th class="unit" >UNIT PRICE</th>
          <th class="qty" >QUANTITY</th>
          <th class="total" >TOTAL</th>
        </tr>
      </thead>
      <tbody>';

      $query = oci_parse($conn, "SELECT * FROM PRODUCTS_IN_CART WHERE CART_ID = '${cart}'");
      oci_execute($query);
      $count = 1;
      while ($result = oci_fetch_assoc($query)) {
        $pid = $result['PRODUCT_ID'];
        $sid = $result['SHOP_ID'];
        $q = $result['ITEM_QUANTITY'];
        $pr = $result['TOTAL'];
        $query2 = oci_parse($conn, "INSERT INTO ORDERS VALUES ('{$cid}','{$invoice}','{$pid}','{$sid}','{$q}','{$pr}')");
        oci_execute($query2);
        $query3 = oci_parse($conn, "UPDATE SHOP_PRODUCT SET STOCK_AMOUNT = STOCK_AMOUNT - '{$q}' WHERE PRODUCT_ID = '${pid}'");
        oci_execute($query3);
        $output .= "<tr>
          <td class='no'>$count</td>
          <td class='desc'>
            <h3>" . $result['PRODUCT_NAME'] . "</h3>
          </td>
          <td class='unit'>$" . $result['PRICE'] . "</td>
          <td class='qty'>$q</td>
          <td class='total'>$$pr</td>
        </tr>";
        $count++;
      }
      $query = oci_parse($conn, "SELECT * FROM CART WHERE CART_ID = '${cart}'");
      oci_execute($query);
      $result = oci_fetch_assoc($query);
      $discount = $result['AMOUNT'] * $result['DISCOUNT'] / 100;
      $output .=
        '</tbody>
      <tfoot>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">SUBTOTAL</td>
          <td>$' . number_format($result['AMOUNT'], 2) . '</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">DISCOUNT%</td>
          <td>$' . number_format($discount, 2) . '</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td colspan="2">GRAND TOTAL</td>
          <td>$' . number_format($result['NET_AMOUNT'], 2) . '</td>
        </tr>
      </tfoot>
    </table>
    <div><strong>COLLECTION TIME:</strong> ' . $time['START_TIME'] . ':00-' . $time['END_TIME'] . ':00<br><strong>COLLECTION DATE: </strong>' . $time['DAY'] . ' - ' . $time['FULL_DATE'] .  '</div>
    <div id="thanks">Thank you!</div>
    <div id="notices">
      <div>NOTICE:</div>
      <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div>
  </main>
  <footer>
    Invoice was created on a computer and is valid without the signature and seal.
  </footer>
</body>';

      $document->loadHtml($output);

      $document->setPaper('a4', 'portrait');

      //Render the HTML as PDF
      $document->render();

      $name = md5(time() . 'receipt') . '.pdf';
      $pdf = $document->output();
      file_put_contents($name, $pdf);

      $file = $name;

      $mailto = $cmail;
      $subject = 'Payment Completed';
      $message = 'Thank you for purchasing from CFX eShop. Find your payment information attached to this mail.';

      $content = file_get_contents($file);
      $content = chunk_split(base64_encode($content));

      // a random hash will be necessary to send mixed content
      $separator = md5(time());

      // carriage return type (RFC)
      $eol = "\r\n";

      // main header (multipart mandatory)
      $headers = "From: CFX eShop <cfxeshop@gmail.com>" . $eol;
      $headers .= "MIME-Version: 1.0" . $eol;
      $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
      $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
      $headers .= "This is a MIME encoded message." . $eol;

      // message
      $body = "--" . $separator . $eol;
      $body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
      $body .= "Content-Transfer-Encoding: 8bit" . $eol;
      $body .= $message . $eol;

      // attachment
      $body .= "--" . $separator . $eol;
      $body .= "Content-Type: application/octet-stream; name=\"invoice.pdf\"" . $eol;
      $body .= "Content-Transfer-Encoding: base64" . $eol;
      $body .= "Content-Disposition: attachment" . $eol;
      $body .= $content . $eol;
      $body .= "--" . $separator . "--";

      $query = oci_parse($conn, "DELETE FROM CART_PRODUCT WHERE CART_ID = '${cart}'");
      oci_execute($query);
      $query = oci_parse($conn, "UPDATE CART SET AMOUNT = 0 WHERE CART_ID = '${cart}'");
      oci_execute($query);

      if (mail($mailto, $subject, $body, $headers)) {
        unlink($file);
        echo "OK";
      } else {
        echo "ERROR!";
      }
    } else {
      header('location:shop.php');
    }
  } else {
    header('location:checkout.php');
  }
} else {
  header('location:index.php');
}
