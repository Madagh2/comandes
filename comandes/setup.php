<?php
    if(file_exists("conexion.php")) {
      header ("Location: index.php");
    }
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="ca">
  <head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen"/>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="author" content="Manuel Almonacid" />
    <meta name="title" content="Comandes" />
    <meta name="description" content="Gestió de comandes de centres educatius" />
    <meta name="language" content="ca" >
    <meta name="robots" content="noindex,nofollow" />
    <meta name="theme-color" content="#006EBE">
  </head>

  <body>
  <header class="indigo lighten-3" role="navigation">
    <div class="container center">
      <h1 class="nomargin">Comandes</h1>
    </div>
  </header>
  <main>
    <div class="section no-pad-bot" id="index-banner">
      <div class="container center">
      	<h3 class="header center indigo-text">Configuració inicial de l'aplicació</h3>
    	<h5 class="header light">Connexió a base de dades</h5>
        <div class="row">
            <form action="initdb.php" method="POST">
              <div class="row">
                <div class="input-field col s12">
                  <input name="host" id="host" type="text" class="validate">
                  <label class="active" for="host">Host</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input name="db" id="db" type="text" class="validate size2r">
                  <label class="active" for="db">Base de dades</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input name="user" id="user" type="text" class="validate size2r">
                  <label class="active" for="user">Nom d'usuari</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input name="pass" id="pass" type="text" class="validate size2r">
                  <label class="active" for="pass">Contrasenya</label>
                </div>
              </div>
              <button class="btn waves-effect waves-light indigo" type="submit" name="action">Ves-hi</button>
            </form>
        </div>
  	  </div>
    </div>
  </main>
  <?include ("footer.php");?>
  </body>
</html>