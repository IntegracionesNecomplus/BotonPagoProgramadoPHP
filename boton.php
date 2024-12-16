<?php
  include 'config/functions.php';
  $amount = $_POST['amount'];
  $frecuencia = $_POST['frequency'];
  $tipo = $_POST['type'];
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $maxAmount = $amount;
  $initialAmount = $_POST['initialAmount'];
  $logo = $_POST['logo'];
  $token = generateToken();
  $sesion = generateSesion($initialAmount, $token, $maxAmount);
  $purchaseNumber = generatePurchaseNumber();
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
  <div class="container-fluid mt-1">
    <form id="frmVisaNet" method="post" action="<?php echo END_POINT;?>finalizar.php?amount=<?php echo $amount;?>&purchaseNumber=<?php echo $purchaseNumber?>&frecuencia=<?php echo $frecuencia;?>&maxAmount=<?php echo $maxAmount?>&tipo=<?php echo $tipo;?>&initialAmount=<?php echo $initialAmount;?>"> 
    <script src="<?php echo VISA_URL_JS?>" 
        data-sessiontoken="<?php echo $sesion;?>"
        data-channel="web"
        data-merchantid="<?php echo VISA_MERCHANT_ID?>"
        data-merchantlogo="<?php echo $logo?>"
        data-purchasenumber="<?php echo $purchaseNumber;?>"
        data-amount="<?php echo $initialAmount; ?>"
        data-expirationminutes="5"
        data-timeouturl="<?php echo END_POINT;?>"
        data-cardholdername="<?php echo $name;?>"
        data-cardholderlastname="<?php echo $lastname;?>"
        data-cardholderemail="<?php echo $email;?>"
        data-recurrence="true"
        data-recurrencefrequency="<?php echo $frecuencia;?>"
        data-recurrencetype="<?php echo $tipo;?>"
        data-recurrencemaxamount="<?php echo $maxAmount;?>"
        data-recurrenceamount="<?php echo $amount;?>"
      ></script>
    </form>
  </div>
</body>
</html>

