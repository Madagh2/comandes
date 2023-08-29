<!-- capg.php -->
  <?php $a=$_SESSION['anyacad'];?>
  <header>
    <nav class="<?php echo $colornav;?>" role="navigation">
      <a href="menu.php" class="brand-logo center"><div class="c"><img src="img/logosol.png" style="height: 56px; width: 56px;" alt="<?php include "dades/centre.php";?>"><span class="hide-on-small-only <?php echo $colortit;?>"> <?php echo $titol;?></span></div></a>
    <ul id="slide-out" class="sidenav <?php echo $colornav;?>">
      <li>
        <div class="user-view">
          <div class="background">
              <img src="img/bg.png" alt="Fons">
          </div>
          <a href="menu.php"><img class="responsive-img" style="max-width: 20%;" src="img/logosol.png" alt="<?php include "dades/centre.php";?>"></a>
          <a href="usuedit.php?uid=<?php echo $_SESSION['uid'];?>" class="waves-effect waves-teal <?php echo $colortit;?> name"><?php echo $_SESSION['profe'];?><br><i><?php echo $_SESSION['depart'];?></i></a>
        </div>
      </li>
      <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
          <li><a href="comand.php" class="collapsible-header waves-effect waves-teal"><i class="material-icons">shopping_cart</i>Comandes</a></li>
          <?php if ($_SESSION['nivell'] == '0') {
            if (isset($_GET['d'])) {
              echo '<script>alert("'.($_GET['d'] == "n" ? "No s'ha fet cap còpia de seguretat de les bases de dades" : "Han passat ".$_GET['d']." dies des de la darrera còpia de seguretat").'");</script>';
            }?>
            <li class="divider"></li>
            <li><a href="xmlcreatablas.php" class="collapsible-header waves-effect waves-teal"><i class="material-icons">storage</i>Bases de dades</a></li>
          <?php }
          if ($_SESSION['nivell']<'1' OR permis('usuaris')==1) {?>
            <li>
              <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">people</i>Usuaris</a>
              <div class="collapsible-body">
                <ul>
                    <li><a href="usuaris.php">Gestió d'usuaris</a></li>
                    <li><a href="usuedit.php">Nou usuari</a></li>
                    <li><a href="permisosqui.php">Permisos</a></li>
                </ul>
              </div>
            </li>
          <?php }
          if ($_SESSION['nivell']<'1' OR permis('dades')==1) {?>
            <li>
              <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">settings</i>Configuració</a>
              <div class="collapsible-body">
                <ul>
                    <li><a href="oferta.php">Oferta educativa</a></li>
                    <li><a href="signatures.php">Signatures</a></li>
                    <li><a href="dades.php">Dades del centre</a></li>
                </ul>
              </div>
            </li>
            <li class="divider"></li>
          <?php }
          $curs= substr($a, 0, 2) . '/' . substr($a, -2);?>
          <li>
            <a class="collapsible-header waves-effect waves-teal"><i class="material-icons">access_time</i>Curs <?php echo $curs;?> <span onclick='location.href="canviany.php?curs=<?php echo $a-101;?>"'><i class="material-icons left">arrow_drop_down</i></span><span onclick='location.href="canviany.php?curs=<?php echo $a+101;?>"'><i class="material-icons right">arrow_drop_up</i></span></a>
          </li>
          <li><a title="Ajuda" href="javascript:ajuda('ajuda.php?id=<?php echo substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],"/")+1,strlen($_SERVER['SCRIPT_NAME'])-strrpos($_SERVER['SCRIPT_NAME'],"/")-5);?>')" class="collapsible-header waves-effect waves-teal"><i class="material-icons">help</i>Ajuda</a></li>
          <li class="divider"></li>
          <li><a href="terminar.php" class="collapsible-header waves-effect waves-teal"><i class="material-icons">power_settings_new</i>Tancar</a></li>
        </ul>
      </li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large"><i class="material-icons">menu</i></a>
    </nav>
  </header>

