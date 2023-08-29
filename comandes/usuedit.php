<?php include ("seguridad.php");
include("conexion.php");
if ($_GET['uid']!=$_SESSION['uid'] && permis("usuaris")!=1 && $_SESSION['nivell']!=0) {
    header ("Location: menu.php");
} else {
  $pers=0;
  if (permis("usuaris")!=1 && $_SESSION['nivell']!=0) {
    $pers=1;
  }
}?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");
include ("editor.php");?>
<script>
  function validar(f) {
      if(f.pass.value == f.pass2.value){
      return true;
    }
    else{
      alert("Les contrassenyes no coincideixen");
      return false;
    }
  }
  function verifica() {
    var url = "usucomp.php?user="+document.getElementById("user").value;
    window.open(url,'Verificació','height=50,width=180,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no,marginweight=0,left=100,top=20');
  }
  function llista() {
    window.open('usugestib.php','Verificació','height=150,width=350,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no,marginweight=0,left=300,top=20');
  }
</script>
</head>
<body>
<main>
  <?php $titol="Dades d'usuari";
  include ("capg.php");?>
  <div class="container">
    <div class="card">
      <form name="usuact" id="usuact" onSubmit="return validar(this)" action="usuact.php" method="POST">
        <?php $uid = isset($_GET['uid']) ? $_GET['uid'] : 0;
        if ($uid!=0) {
          $sql = "select * from usuaris WHERE uid='".$uid."'";
          $res = mysqli_query($link,$sql);
          $row = mysqli_fetch_array ($res);
          $id = $row['uid'];
          $user = $row['user'];
          $email = $row['email'];
          $nivell = $row['nivell'];
          $capdep = $row['capdep'];
          $nom = $row['nom'];
          $tt=$nom;
          $st="Actualitzar";
          $departament = $row['departament'];
          $aut = $row['autoritzat'];
          $dma=explode('-',$row['altacentre']);
          $altacentre=$dma[2].'/'.$dma[1].'/'.$dma[0];
          if ($altacentre=="00/00/0000" OR $altacentre=="//") {$altacentre="01/09/2020";}
          $reenv = $row['reenvia'];
        } else {
          $id = $uid;
          $user = "";
          $email = "";
          $nivell = 3;
          $capdep = 0;
          $nom = "";
          $tt="Usuari nou";
          $st="Donar d'alta";
          $departament = "";
          $aut = 1;
          $altacentre=date('d/m/Y');
          if (isset($_GET['codi'])) {
            $sqlg = "select * from profes".$a." WHERE codi='".$_GET['codi']."'";
            echo "<!-- ".$sqlg." -->";
            $resg = mysqli_query($link,$sqlg);
            $rowg = mysqli_fetch_array ($resg);
            $nom = $rowg['ap1']." ".$rowg['ap2'].", ".$rowg['nom'];
            $tt=$nom;
            $departament = $rowg['dep'];
          }
        }?>
        <h5 class="header <?php echo $colortit;?>"><?php echo $tt;?><i class="material-icons right pointer <?php echo $colortit;?>" onclick="location.href='usuaris.php'">people</i></h5>
        <!-- Id i usuari -->
        <div class="row <?php echo $colorweb;?> lighten-5">
          <div class="input-field col s1">
            <input readonly="" type="text" value="<?php echo $uid;?>" id="uid" name="uid"/>
            <label for="profe">Id</label>
          </div>
          <div class="input-field col s11">
            <input type="text" required="" value="<?php echo $user;?>" id="user" name="user" pattern="[a-z]{5,15}" onchange="verifica()" <?php echo ($pers==1 ? ' readonly=""' : ' title="Només lletres minúscules, entre 5 i 15"');?>/>
            <label for="user">Usuari</label>
          </div>
        </div>
        <!-- Llinatges, Nom -->
        <div class="row">
          <div class="input-field col s12">
            <input type="text" value="<?php echo $nom;?>" id="nom" name="nom" <?php echo ($pers==1 ? ' readonly=""' : ' pattern="[a-zA-ZñÑçÇá-úÁ-Ú·àèòÀÈÒüÜ,'."'".' -]+"');?> />
            <label for="nom">Llinatges, Nom</label>
            <?php
            $file="profes".$a;
            $esta=(file_exists($file) ? 0 : 2);
            if ($nom!="" && $esta==0 && $pers==0) {
              $sqlcomp="SELECT * FROM profes".$a." WHERE CONCAT(ap1,' ', ap2,', ',nom)='".mb_convert_case($nom, MB_CASE_UPPER, "UTF-8")."'";
              echo '<!-- '.$sqlcomp.' -->';
              $rescomp = mysqli_query($link,$sqlcomp);
              if (mysqli_num_rows($rescomp)==0) {?>
                <i class="material-icons yellow-text tooltipped right" data-position="bottom" data-tooltip="No hi ha coincidència amb les dades del Gestib<br>Fes click per veure el llistat" onclick="llista()">error</i>
              <?php } else {
                $esta=1;
              }
            }?>
          </div>
        </div>
        <!-- Password -->
        <?php $pass= ($uid==0 ? "comandes" : "");?>
        <div class="row <?php echo $colorweb;?> lighten-5">
          <div class="input-field col s6">
            <input type="password" value="<?php echo $pass;?>" id="pass" name="pass" placeholder="****" pattern="[A-Za-z0-9]+"/>
            <label for="pass">Només lletres i nombres</label>
          </div>
          <div class="input-field col s6">
            <input type="password" value="<?php echo $pass;?>" id="pass2" name="pass2" placeholder="****" pattern="[A-Za-z0-9]+"/>
            <label for="pass2">Repeteix clau</label>
          </div>
        </div>
        <!-- Correu electrònic -->
        <div class="row">
          <div class="input-field col s12">
            <input type="email" value="<?php echo $email;?>" id="email" name="email"/>
            <label for="email">Correu electrònic</label>
          </div>
        </div>
        <!-- Nivell -->
        <div class="row <?php echo $colorweb;?> lighten-5">
          <div class="input-field col s12">
            <?php 
            $nivopt = array();
            $niv=["Administrador","Equip Directiu","Cap de Departament","Professorat","No docent","Altres"];
            if ($pers==0) {
              $opt="";
              foreach($niv as $valor) {
                $opt ='<option value="'.$i.'"';
                $opt.=($i==$nivell ? ' selected=""' : '');
                $opt.=($_SESSION['nivell']=="0" ? '' : 'disabled');
                $opt.='>'.$i." - ".$niv[$i].'</option>';
                $nivopt[] = $opt;
              }
              $nivopt = join("\n", $nivopt);
              ?>
              <select id="nivell" name="nivell">
                <?php echo $nivopt;?>
              </select>
            <?php } else {?>
              <input type="text" value="<?php echo $niv[$nivell];?>" id="nivell" readonly=""/>
              <input type="hidden" value="<?php echo $nivell;?>" name="nivell"/>
            <?php }?>            
            <label for="nivell">Nivell</label>
          </div>
        </div>
        <!-- Departament -->
        <div class="row">
          <div class="input-field col s12">
              <?php
              if ($pers==0) {
                $depopt = array();
                $file="deps".$a;
                $sqld = (file_exists($file) ? "SELECT * FROM ".$file." ORDER BY departament" : "SELECT DISTINCT(departament) FROM usuaris WHERE departament NOT IN ('Altres', 'No docent') ORDER BY departament");
                $queryd = mysqli_query($link,$sqld);
                while ($rowd = mysqli_fetch_assoc($queryd)) {
                  $opt = '<option value="'.$rowd['departament'].'"';
                  if ($rowd['departament']==$departament) {$opt.=' selected=""';}
                  $opt .='>'.$rowd['departament'].'</option>';
                  $depopt[] = $opt;
                }
                $opt = '<option value="No docent"';
                if ($departament=="No docent") {$opt.=' selected=""';}
                $opt .='>No docent</option>';
                $depopt[] = $opt;
                $opt = '<option value="Altres"';
                if ($departament=="Altres") {$opt.=' selected=""';}
                $opt .='>Altres</option>';
                $depopt[] = $opt;
                $depopt = join("\n", $depopt);
                ?>
                <select id="departament" name="departament"<?php echo ($pers==1 ? ' disabled' : '');?>><?php echo $depopt;?></select>
              <?php } else {?>
                <input type="text" value="<?php echo $departament;?>" id="departament" readonly=""/>
                <input type="hidden" value="<?php echo $departament;?>" name="departament"/>
              <?php }?>
              <label for="departament">Departament</label>
              <?php if ($esta==1) {
                $sqlcomp="SELECT * FROM profes".$a." WHERE CONCAT(ap1,' ', ap2,', ',nom)='".mb_convert_case($nom, MB_CASE_UPPER, "UTF-8")."'";
                echo '<!-- '.$sqlcomp.' -->';
                $rescomp = mysqli_query($link,$sqlcomp);
                $rowcomp = mysqli_fetch_array ($rescomp);
                if ($departament!=$rowcomp['dep']) {?>
                  <i class="material-icons yellow-text tooltipped right" data-position="bottom" data-tooltip="El departament segons el Gestib és<br><b><?php echo $rowcomp['dep'];?></b>">error</i>
                <?php }
              }?>
          </div>
        </div>
        <!-- Cap de departament -->
        <div class="row <?php echo $colorweb;?> lighten-5">
          <div class="input-field col s12">
            <div class="switch">
                <label>
                  Permís per autoritzar com a cap de departament: No
                  <input type="checkbox" id="capdep" name="capdep" value="1"<?php echo ($capdep=='1' ? ' checked="checked"' : ''); echo ($pers==1 ? ' disabled' : '');?>>
                  <span class="lever"></span>
                  Sí
                </label>
              </div>
            <label for="capdep"></label>
          </div>
        </div>
        <!-- Data alta i accès -->
        <div class="row <?php echo $colorweb;?> lighten-5">
          <?php if ($pers==0) {?>
          <div class="input-field col s12 m6">
            <input type="text" value="<?php echo $altacentre;?>" id="altacentre" name="altacentre" class="datepicker"/>
            <label for="altacentre">Alta al centre</label>
          </div>
          <div class="input-field col s12 m6">
            <span>Autoritzat&nbsp;</span>
            <?php $opt=[1 => "Sí", 2 => "Especial", 0 => "No"];
            foreach($opt as $key=>$value) {?>
              <span>
                <label>
                  <input class="with-gap" name="autoritzat" type="radio" <?php echo 'value="'.$key.'" '.($aut==$key ? ' checked="checked"' : '');?>>
                  <span><?php echo $value;?></span>
                </label>
              </span>
            <?php }?>
          </div>
          <?php } else {?>
            <input type="hidden" name="altacentre" value="<?php echo $altacentre;?>">
            <input type="hidden" name="autoritzat" value="<?php echo $aut;?>">
          <?php }?>
        </div>
        <!-- Enviar -->
        <div class="row">
            <div class="input-field col s12 center">
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons right">send</i><?php echo $st;?></button>
            </div>
        </div>
      </form>
    </div>
  </div>

  <?php if ($uid==0) {?>
    <script type="text/javascript">
      document.getElementById("usuact").action = "usunou.php";
    </script>
  <?php } else {?>
    <!-- -- -- -- -- PERMISOS -- -- -- -- -->
    <div class="container"<?php echo ($pers==1 ? ' style="display:none;"' : '');?>>
      <div class="card">
        <?php 
          $sqlr="SELECT max(id) as t FROM permisos";
          $queryr = mysqli_query($link,$sqlr);
          $rowr = mysqli_fetch_assoc($queryr);
          $na=$rowr['t'];
          $sqlp="SELECT BIN(permis) AS al FROM usuaris WHERE uid='".$uid."'";
          $queryp = mysqli_query($link,$sqlp);
          $rowp = mysqli_fetch_assoc($queryp);
          $permis=substr(str_repeat("0", $na).$rowp['al'],-$na);
        ?>
        <!-- Permisos varis -->
        <form name="permisact" action="permisact.php" method="POST">
          <h5 class="header <?php echo $colortit;?> pointer" onclick="location.href='permisosqui.php'">Permisos</h5>
          <table class="stripped">
          <tr>
            <th>Id</th><th>Codi</th><th>Descripció</th><th>Permís</th>
          </tr>
          <?php $c=20;
          $sqlp="SELECT * FROM permisos order by id";
          $queryp = mysqli_query($link,$sqlp);
          while ($rowp = mysqli_fetch_assoc($queryp))
          { $pa=substr($permis,-$rowp['id'],1);?>
            <tr style="background-color: rgb(<?php echo 235+$c,",",235+$c;?>,255);">
              <td><?php echo $rowp['id'];?></td>
              <td><?php echo $rowp['codi'];?></td>
              <td><?php echo $rowp['descr'];?></td>
              <td>
                <div class="input-field col s12">
                  <div class="switch">
                      <label>
                        <input type="checkbox" id="alt<?php echo $rowp['id'];?>" name="alt<?php echo $rowp['id'];?>" value="1"<?php if ($pa==1) {echo ' checked="checked"';}?>>
                        <span class="lever"></span>
                      </label>
                    </div>
                  <label for="alt<?php echo $rowp['id'];?>"></label>
                </div>
              </td>
            </tr>
            <?php $c=$c*(-1);
          }?>
          </table>
          <div class="row">
              <div class="input-field col s12 center">
                  <input type="hidden" name="uid" value="<?php echo $uid;?>">
                  <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons right">send</i>Actualitzar</button>
              </div>
          </div>
        </form>
      </div>
    </div>
  <?php }?>
</main>
<?php
if (isset($_GET['cc'])) {
  echo '<script>alert("Canvia la teva contrasenya");</script>';
}
if ($uid == 0) {
  echo '<script>alert("La contrasenya per defecte per a nous usuaris és \'comandes\' si no s\'especifica una altra. Es demanarà a l\'usuari que la canviï quan hi entri per primera vegada.");</script>';
}
include("footer.php");
include("footerform.php");?>
</body>
</html>