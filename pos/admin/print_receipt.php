<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>PLM Merch</title>
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/img/icons/plm-merch-logo-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/img/icons/plm-18x18.png">
  <link rel="manifest" href="assets/img/icons/site.webmanifest">
  <link rel="mask-icon" href="assets/img/icons/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <link href="assets/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/jquery.js"></script>
  <style>
  html {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  body {
    background-image: url('./assets/img/brand/plm_bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center center;
    height: 100vh;
    width: 100vw;
    overflow: hidden;
    position: relative;
    z-index: -1;
    padding-top: 1rem;
  }

  .blur {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
    background-color: rgba(31, 37, 69, .6);
    width: 100%;
    height: 100vh;
    backdrop-filter: blur(8px);
  }

  .container {
    position: relative;
    z-index: 999;
  }
  </style>
</head>
</style>
<?php
$order_code = $_GET['order_code'];
$ret = "SELECT * FROM  rpos_orders WHERE order_code = '$order_code'";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($order = $res->fetch_object()) {
    $total = ($order->prod_price * $order->prod_qty);

?>

<body>
  <div class="blur"></div>
  <div class="container">
    <div class="row">
      <div id="Receipt" class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <address>
              <strong>PLM Merch</strong>
              <br>
              General Luna, corner Muralla St, Intramuros,
              <br>
              Intramuros, Manila, 1002 Metro Manila
              <br>
              (+63 9876543210)
            </address>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 text-right">
            <p>
              <em>Date: <?php echo date('d/M/Y g:i', strtotime($order->created_at)); ?></em>
            </p>
            <p>
              <em class="text-success">Receipt #: <?php echo $order->order_code; ?></em>
            </p>
          </div>
        </div>
        <div class="row">
          <div class="text-center">
            <h2>Receipt</h2>
          </div>
          </span>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th class="text-center">Unit Price</th>
                <th class="text-center">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="col-md-9"><em> <?php echo $order->prod_name; ?> </em></h4>
                </td>
                <td class="col-md-1" style="text-align: center"> <?php echo $order->prod_qty; ?></td>
                <td class="col-md-1 text-center">₱<?php echo $order->prod_price; ?></td>
                <td class="col-md-1 text-center">₱<?php echo $total; ?></td>
              </tr>
              <tr>
                <td>   </td>
                <td>   </td>
                <td class="text-right">
                  <p>
                    <strong>Subtotal: </strong>
                  </p>
                  <p>
                    <strong>Tax: </strong>
                  </p>
                </td>
                <td class="text-center">
                  <p>
                    <strong>₱<?php echo $total; ?></strong>
                  </p>
                  <p>
                    <strong>14%</strong>
                  </p>
                </td>
              </tr>
              <tr>
                <td>   </td>
                <td>   </td>
                <td class="text-right">
                  <h4><strong>Total: </strong></h4>
                </td>
                <td class="text-center text-danger">
                  <h4><strong>₱<?php echo $total; ?></strong></h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
        <button id="print" onclick="printContent('Receipt');" class="btn btn-success btn-lg text-justify btn-block">
          Print <span class="fas fa-print"></span>
        </button>
      </div>
    </div>
  </div>
</body>

</html>
<script>
function printContent(el) {
  var restorepage = $('body').html();
  var printcontent = $('#' + el).clone();
  $('body').empty().html(printcontent);
  window.print();
  $('body').html(restorepage);
}
</script>
<?php } ?>