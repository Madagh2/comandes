<?php include ("seguridad.php");
include("conexion.php");
if (permis("usuaris")!=1 AND $_SESSION['nivell']!=0) {header ("Location: menu.php");}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
<script>
  function llista() {
    window.open('usugestib.php','Verificació','height=150,width=350,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no,marginweight=0,left=300,top=20');
  }
</script>
</head>
<body>
  <?php $titol="Administració d'usuaris";
  include ("capg.php");
  $aut = isset($_GET['aut']) ? $_GET['aut'] : "1";
  $niv = isset($_GET['niv']) ? $_GET['niv'] : "t";
  $dep = isset($_GET['dep']) ? $_GET['dep'] : "t";
  $cd = isset($_GET['cd']) ? $_GET['cd'] : "t";
  $ord = isset($_GET['ord']) ? $_GET['ord'] : "nom";
  $fil = " WHERE";
  $fil .= ($aut!="t" ? " autoritzat=".$aut : "");
  $and = ($fil == " WHERE" ? "" : " AND");
  $fil .= ($niv!="t" ? $and." nivell=".$niv : "");
  $and = ($fil == " WHERE" ? "" : " AND");
  $fil .= ($dep!="t" ? $and.' departament="'.$dep.'"' : "");
  $and = ($fil == " WHERE" ? "" : " AND");
  $fil .= ($cd!="t" ? $and.' capdep="'.$cd.'"' : "");
  $fil = ($fil == " WHERE" ? "" : $fil);
?>
<main>
<div class="container">
  <!-- Filtre -->
  <div class="card">
    <form action="usuaris.php" method="GET">
      <div class="row">
        <!-- Ordenar -->
        <div class="input-field col s6 m4 l2">
          <?php echo "<!-- ",$ord," -->";?>      
          <select id="ord" name="ord" onchange="this.form.submit();">
            <?php $opt = array('uid' => "Id", 'user' => "Usuari",'nom' => "Llinatges, nom",'departament' => "Departament", 'nivell' => "Nivell");
              foreach($opt as $key=>$value) {
                echo '<option value="',$key,'"';
                echo ($key==$ord ? ' selected=""' : '');
                echo '>',$value,'</option>';
                echo "\n";
              }?>
          </select>
          <label for="ord">Ordenar</label>
        </div>
        <!-- Autoritzats -->
        <div class="input-field col s6 m4 l2">
          <select id="aut" name="aut" onchange="this.form.submit();">
            <?php $opt = array('t' => "Tots", '0' => "0. No autoritzats",'1' => "1. Autoritzats",'2' => "2. Especials");
            foreach($opt as $key=>$value) {
                echo '<option value="',$key,'"';
                echo ($key==$aut ? ' selected=""' : '');
                echo '>',$value,'</option>';
                echo "\n";
            }?>
          </select>
          <label for="aut">Mostrar</label>
        </div>
        <!-- Nivell -->
        <div class="input-field col s6 m4 l3">
          <?php echo "<!-- ",$niv," -->";?>      
          <select id="niv" name="niv" onchange="this.form.submit();">
            <option value="t" <?php echo ($niv=="t" ? ' selected=""' : '');?>>Tots</option>
            <?php $nivell=["Administrador","Equip Directiu","Cap de Departament","Professorat","No docent","Altres"];
              if ($_SESSION['nivell']=="0") {$imin="0";} else {$imin="1";}
              for ($i=$imin; $i<=7; $i++)  {
                  echo '<option value="',$i,'"';
                  echo ($i==$niv ? ' selected=""' : '');
                  echo '>',$i,". ",$nivell[$i],'</option>';
                  echo "\n";
              }?>
          </select>
          <label for="niv">Nivell</label>
        </div>
        <!-- Cap de departament -->
        <div class="input-field col s6 m6 l2">
          <select id="cd" name="cd" onchange="this.form.submit();">
            <?php $opt = array('t' => "Tots", '1' => "Sí",'0' => "No");
            foreach($opt as $key=>$value) {
                echo '<option value="',$key,'"';
                echo ($key==$cd ? ' selected=""' : '');
                echo '>',$value,'</option>';
                echo "\n";
            }?>
          </select>
          <label for="cd">Cap departament</label>
        </div>
        <!-- Departament -->
        <div class="input-field col s12 m6 l3">
          <?php echo "<!-- ",$dep," -->";?>      
            <?php $options = array();
            $opt = '<option value="t"';
            if ($dep=="t") {$opt.=' selected=""';}
            $opt .='>Tots</option>';
            $options[] = $opt;
              $file="deps".$a;
              $sqld = (file_exists($file) ? "SELECT * FROM ".$file." ORDER BY departament" : "SELECT DISTINCT(departament) FROM usuaris WHERE departament NOT IN ('Altres', 'No docent') ORDER BY departament");
              $queryd = mysqli_query($link,$sqld);
              while ($rowd = mysqli_fetch_assoc($queryd)) {
                $opt = '<option value="'.$rowd['departament'].'"';
                if ($rowd['departament']==$dep) {$opt.=' selected=""';}
                $opt .='>'.$rowd['departament'].'</option>';
                $options[] = $opt;
              }
              $opt = '<option value="No docent"';
              if ($dep=="No docent") {$opt.=' selected=""';}
              $opt .='>No docent</option>';
              $options[] = $opt;
              $opt = '<option value="Altres"';
              if ($dep=="Altres") {$opt.=' selected=""';}
              $opt .='>Altres</option>';
              $options[] = $opt;
              $options = join("\n", $options);?>
              <select id="dep" name="dep" onchange="this.form.submit();">
                <?php echo $options;?></select>
              <label for="dep">Departament</label>
        </div>
      </div>
    </form>  
  </div>

<!-- Llistat d'usuaris -->
  <div class="card">
  <table class="stripped responsive-table">
    <thead>
      <tr>
        <th>n.</th><th>id</th><th>user</th><th>nom</th><th>email</th><th>nivell</th><th>departament</th><th>Aut</th><th></th>
      </tr>
    </thead>
    <tbody>
      <?php $colaut = array('0' => 'blue-grey lighten-3 blue-grey-text text-darken-2','1' => '','2' => 'blue-grey lighten-5');
      $n=1;
      $sql = "select * from usuaris".$fil." ORDER BY ".$ord;
      echo "<!-- ",$sql," -->";
      $res = mysqli_query($link,$sql);
      while($row = mysqli_fetch_array ($res))
      {
      	$uid = $row['uid'];
      	$user = $row['user'];
      	if ($row['pass']=="") {
      		$clau = "";
      	}
      	else {
      		$clau = "****";
      	}
      	$email = $row['email'];
      	$nivell = $row['nivell'];
      	$capdep = $row['capdep'];
      	$nom = $row['nom'];
      	$departament = $row['departament'];
        $aut = $row['autoritzat'];?>
      	<tr class="<?php echo $colaut[$aut];?>">
          <td <?php if ($_SESSION['nivell']=="0") {echo 'ondblclick="location.href='."'controlemu.php?uid=".$uid."'".'"';}?>>
            <?php if ($aut==1) {
              echo $n;
              $n++;
            }?>
          </td>
          <td>
            <?php 
            $file='profes'.$a.'.php';
            $esta=(file_exists($file) ? 0 : 2);
            if ($aut==1 && $esta==0) {
              $sqlcomp="SELECT * FROM profes".$a." WHERE CONCAT(ap1,' ', ap2,', ',nom)='".mb_convert_case($nom, MB_CASE_UPPER, "UTF-8")."'";
              echo '<!-- '.$sqlcomp.' -->';
              $rescomp = mysqli_query($link,$sqlcomp);
              if (mysqli_num_rows($rescomp)==0) {?>
                <i class="material-icons yellow-text tooltipped" data-position="bottom" data-tooltip="No hi ha coincidència amb les dades del Gestib<br>Fes click per veure el llistat" onclick="llista()">error</i>
              <?php } else {
                $esta=1;
                echo $uid;
              }
            } else {echo $uid;}?>
          </td>
          <td><?php echo $user;?></td>
          <td><?php echo $nom;?></td>
          <td><?php echo $email;?></td>
          <td title="<?php echo $niv[$nivell];?>"><?php echo $nivell; if ($capdep==1) {echo " CD";}?></td>
          <td>
            <?php if ($esta==1) {
              $sqlcomp="SELECT * FROM profes".$a." WHERE CONCAT(ap1,' ', ap2,', ',nom)='".mb_convert_case($nom, MB_CASE_UPPER, "UTF-8")."'";
              echo '<!-- '.$sqlcomp.' -->';
              $rescomp = mysqli_query($link,$sqlcomp);
              $rowcomp = mysqli_fetch_array ($rescomp);
              if ($departament!=$rowcomp['dep']) {?>
                <i class="material-icons yellow-text tooltipped" data-position="bottom" data-tooltip="El departament segons el Gestib és<br><b><?php echo $rowcomp['dep'];?></b>">error</i>
              <?php }
            }
            echo $departament;?>
          </td>
          <td><?php echo $aut;?></td>
          <td><a href="usuedit.php?uid=<?php echo $uid;?>" /><i class="material-icons <?php echo $colortit;?>">edit</i></td>
        </tr>
      <?php }?>
    </tbody>
  </table>
  </div>
</div>
</main>
<?php include("footer.php");
include("footerform.php");?>
</body>
</html>