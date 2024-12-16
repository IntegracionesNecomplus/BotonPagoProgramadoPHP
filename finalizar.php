<?php
  include 'config/functions.php';
  $transactionToken = $_POST["transactionToken"];
  $email = $_POST["customerEmail"];
  $amount = $_GET["amount"];
  $initialAmount = $_GET["initialAmount"];
  $purchaseNumber = $_GET["purchaseNumber"];
  $maxAmount = $_GET["maxAmount"];
  $frecuencia = $_GET["frecuencia"];
  $tipo = $_GET["tipo"];

  $token = generateToken();
  $data = generateAuthorization($initialAmount, $amount, $purchaseNumber, $transactionToken, $token, $maxAmount, $frecuencia, $tipo);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php
    include('assets/theme/head.php');
  ?>
</head>

<body>
  <br>
  <div class="p-3 mb-2 bg-primary text-white" style="text-align: center;">
    <h1 style="font-weight: bold;"><b>RESPUESTA DE PAGO</b></h1>
  </div>
  <br>

  <div class="container">
    <?php
    if (isset($data->dataMap)) {
      if ($data->dataMap->STATUS == "Authorized") {
        $c = preg_split('//', $data->dataMap->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
    ?>
        <div class="alert alert-warning my-custom-alert " role="alert">
         <?php echo $data->dataMap->ACTION_DESCRIPTION; ?>
        </div>
      <?php
      }

      if ($data->dataMap->RECURRENCE_SRV_CODE == "000") {
      ?>
        <div class="alert alert-warning my-custom-alert " role="alert">
          <?php echo $data->dataMap->RECURRENCE_SRV_MESSAGE; ?>
        </div>
        <div class="card" style="background-color: #ddf0e1; padding: 20px;">
        <div class="card-body" style="color: black;">
        <div class="row">
                <div class="col-md-12">
                    <b>Número de pedido: </b> <?php echo $purchaseNumber; ?>
                  </div>
                <div class="col-md-12">
                    <b>Nombre y Apellido: </b> <?php echo "Integraciones Necomplus"; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Fecha y hora del pedido: </b> <?php echo $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11]; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Tarjeta: </b> <?php echo $data->dataMap->CARD . " (" . $data->dataMap->BRAND . ")"; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Importe de la transacción: </b> <?php echo $data->order->amount . " " . $data->order->currency; ?>
                  </div>
                  <div class="col-md-12">
                    <b>Descripción de Productos/Servicios. </b> <?php echo "Producto de prueba"; ?>
                  </div>
                </div>
                </div>
                </div>
      <?php
      }
    } else {
      $c = preg_split('//', $data->data->TRANSACTION_DATE, -1, PREG_SPLIT_NO_EMPTY);
      ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $data->data->ACTION_DESCRIPTION; ?>
      </div>

      <div class="row">
        <div class="col-md-12">
          <?php
          if (isset($data->data->RECURRENCE_SRV_CODE) && $data->data->RECURRENCE_SRV_CODE != "000") {
          ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $data->data->RECURRENCE_SRV_MESSAGE; ?>
            </div>
            <div class="col-md-12">
                    <b>Fecha y hora del pedido: </b> <?php echo $c[4] . $c[5] . "/" . $c[2] . $c[3] . "/" . $c[0] . $c[1] . " " . $c[6] . $c[7] . ":" . $c[8] . $c[9] . ":" . $c[10] . $c[11]; ?>
                  </div>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>

</body>

</html>