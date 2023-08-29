<?php
    if(!file_exists("conexion.php")) {
      header ("Location: setup.php");
    }
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <?php
      session_start();
      include ("head.php");
    ?>
  </head>

  <body>
  <header class="<?php echo $colornav;?>" role="navigation">
    <div class="container center">
      <a id="logo-container" href="#" class="brand-logo"><img src="img/logocentre.png" style="height: 56px;"></a>
    </div>
  </header>
  <main>
    <div class="section no-pad-bot" id="index-banner">
      <div class="container center">
      	<h1 class="header center <?php echo $colortit;?>"><?php include "dades/centre.php";?></h1>
    	  <h5 class="header col s12 light">Gestió de centre</h5>
        <div class="row">
            <div class="col s3"></div>
            <form action="control.php" method="POST" class="col s6">
              <div class="row">
                <div class="input-field col s12">
                  <input name="usuari" id="usuari" type="text" class="validate size2r">
                  <label for="usuari">Usuari</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input name="contrasena" id="contrasena" type="password" class="validate size2r">
                  <label for="contrasena">Contrasenya</label>
                </div>
              </div>
              <button class="btn waves-effect waves-light <?php echo $colorweb;?>" type="submit" name="action">Ves-hi
<i class="material-icons right">send</i></button>
            </form>
            <div class="col s3"></div>
        </div>
  	  </div>
    </div>
  </main>
  <?php include ("footer.php");?>
  </body>
</html>