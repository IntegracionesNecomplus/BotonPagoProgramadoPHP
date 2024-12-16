<?php
include 'config/functions.php';
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <?php
      include('assets/theme/head.php');
    ?>
  </head>

  <body>
    <div class="p-3 mb-2 bg-primary text-white">
      <h1><center><b>PAGO RECURRENTE</b></center></h1>
    </div>
    <br>

    <div class="container-fluid">
      <form action="<?php echo END_POINT; ?>boton.php" method="POST">
        <div class="card-group row">
          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-header">DATOS TARJETAHABIENTE</div>
              <div class="card-body">
                
                <div class="form-group mb-2">
                  <label for="name">Nombres</label>
                  <input type="text" name="name" id="name" class="form-control" value="Integraciones">
                </div>

                <div class="form-group mb-2">
                  <label for="lastname">Apellidos</label>
                  <input type="text" name="lastname" id="lastname" class="form-control" value="Niubiz">
                </div>

                <div class="form-group mb-2">
                  <label for="email">Email</label>
                  <input type="text" name="email" id="email" class="form-control" value="integraciones.niubiz@necomplus.com">
                </div>
                
                <div class="form-group mb-2">
                  <label for="logo">Logotipo</label>
                  <input type="text" name="logo" id="logo" class="form-control" value="http://localhost/niubiz.botonrecurrencia/assets/img/logo.png">
                </div>
                
                <br>
                <div class="col-md-6">
                  <img src="../niubiz.botonrecurrencia/assets/img/tarjetas.png" width="420" height="30">
                </div>
                <br>

                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary btn-full">Generar Pago</button>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card h-100">
              <div class="card-header">TIPO DE SUSCRIPCIÓN</div>
              <div class="card-body">
                <div class="form-group mb-2">
                  <label for="amount">Importe recurrente</label>
                  <input type="text" name="amount" id="amount" class="form-control" value="1.00" required>
                </div>
                <div class="form-group mb-2">
                  <label>Frecuencia</label>
                  <select class="form-control" name="frequency">
                    <option value="MONTHLY" selected>Mensual</option>
                    <option value="QUARTERLY">Trimestral</option>
                    <option value="BIANNUAL">Semestral</option>
                    <option value="ANNUAL">Anual</option>
                  </select>
                </div>
                
                <div class="form-group mb-2">
                  <label>Tipo</label>
                  <select class="form-control" name="type">
                    <option value="FIXED" selected>Fijo</option>
                    <option value="VARIABLE">Variable</option>
                    <option value="FIXEDINITIAL">Fijo con inicial</option>
                    <option value="VARIABLEINITIAL">Variable con inicial</option>
                  </select>
                </div>

                <div class="form-group mb-2">
                  <label for="initialAmount">Importe inicial</label>
                  <input type="text" name="initialAmount" id="initialAmount" class="form-control" value="1.00">
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
  <script src="assets/js/script.js"></script>
</html>