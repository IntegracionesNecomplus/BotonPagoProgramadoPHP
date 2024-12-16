<?php
include 'config.inc.php';

function generateToken()
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => VISA_URL_SECURITY,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      'Authorization: ' . 'Basic ' . base64_encode(VISA_USER . ":" . VISA_PWD)
    ),
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}

function generateSesion($amount, $token, $maxAmount)
{
 /* $response = file_get_contents("http://ip.jsontest.com/");
  $data = json_decode($response, true);
  $clientIp = $data['ip'];*/
  $session = array(
    'channel' => 'web',
    'amount' => $amount,
    'recurrenceMaxAmount' => $maxAmount,
    'antifraud' => array(
      'clientIp' => $_SERVER['REMOTE_ADDR'],
      'merchantDefineData' => array(
        'MDD4' => 'niubiz@necomplus.com', // Email del donante
        'MDD32' => '87654321', // codigo del donante
        'MDD75' => 'Registrado', // Tipo de resgistro
        'MDD77' => '27' // Número de días transcurridos
      ),
    ),
    'dataMap' => array(  //Datos Dinámicos
      'cardholderCity' => 'Lima',
      'cardholderCountry' => 'PE',
      'cardholderAddress' => 'Av Jose Pardo 831',
      'cardholderPostalCode' => '15078',
      'cardholderState' => 'LIM',
      'cardholderPhoneNumber' => '987654321',
    ),
  );
  $json = json_encode($session);
  $response = json_decode(postRequest(VISA_URL_SESSION, $json, $token));
  return $response->sessionKey;
}

function generateAuthorization($initialAmount, $amount, $purchaseNumber, $transactionToken, $token, $maxAmount, $frecuencia, $tipo)
{
  $beneficiaryId = rand(75830110, 80143741);
  $data = array(
    'channel' => 'web',
    'captureType' => 'manual',
    'countable' => true,
    'order' => array(
      'tokenId' => $transactionToken,
      'purchaseNumber' => $purchaseNumber,
      'amount' => $initialAmount,
      'currency' => 'PEN',
      'productId' => "00001" 
    ),

    'cardHolder' => array(
      'documentType' => 0,
      'documentNumber' => "87655554"
    ),

    'recurrence' => array(
      'type' => $tipo,
      'frequency' => $frecuencia,
      'beneficiaryId' => $beneficiaryId,
      'beneficiaryFirstName' => 'Integraciones',
      'beneficiaryLastName' => 'Niubiz', 
      'maxAmount' => $maxAmount,
      'amount' => $amount     
    )
  );

  $json = json_encode($data);
  // echo '<div class="container"><div class="row"><div class="col-md-6"><textarea value="dd"></div></div></div>';
  $session = json_decode(postRequest(VISA_URL_AUTHORIZATION, $json, $token));
  // var_dump($session);
  return $session;
}

function postRequest($url, $postData, $token)
{
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_HTTPHEADER => array(
      'Authorization: ' . $token,
      'Content-Type: application/json'
    ),
    CURLOPT_POSTFIELDS => $postData
  ));
  $response = curl_exec($curl);
  curl_close($curl);
  echo '<link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <div class="container-fluid mt-3">
          <div class="row">
            <div class="col-md-6">
              <b><label>Request</label></b>
              <textarea class="form-control" rows="20" disabled>' . json_encode(json_decode($postData), JSON_PRETTY_PRINT) . '</textarea>
            </div>
            <div class="col-md-6">
            <b><label>Response</label></b>
              <textarea class="form-control" rows="20" disabled>' . json_encode(json_decode($response), JSON_PRETTY_PRINT) . '</textarea>
            </div>
          </div>
        </div>';
  return $response;
}

function generatePurchaseNumber()
{
  $archivo = "assets/purchaseNumber.txt";
  $purchaseNumber = 222;
  $fp = fopen($archivo, "r");
  $purchaseNumber = fgets($fp, 100);
  fclose($fp);
  ++$purchaseNumber;
  $fp = fopen($archivo, "w+");
  fwrite($fp, $purchaseNumber, 100);
  fclose($fp);
  return $purchaseNumber;
}
