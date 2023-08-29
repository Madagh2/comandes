<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");
include("conexion.php");?>
</head>
<body>
<?php $a=$_SESSION['anyacad'];
if (file_exists('exportacioDadesCentre'.$a.'.xml')) {
    $xml = simplexml_load_file('exportacioDadesCentre'.$a.'.xml');
    $datamod = date("j/m/y", filemtime('exportacioDadesCentre'.$a.'.xml'));
    $missatge = "Actualitzat el ".$datamod;
    $error = 0;
} else {
    $missatge = "No existeix el fitxer exportacioDadesCentre".$a.".xml";
    $error = 1;
}
$titol="Crear taules MySQL<br>";
include ("capg.php");
$n=1;?>

<main>
<h4 class="header center <?php echo $colorweb;?>-text text-darken-4">Crear taules MySQL</h4>
<div class="container">
<h5 class="header center <?php echo $colorweb;?>-text text-darken-4">Taules Curs 20<?php echo substr($a,0,2)."/".substr($a,2,2);?></h5>
<table class="bordered striped">
    <tr>
        <td></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="L'arxiu XML es generat pel Gestib al menú <b>Alumnat - Importació/exportació SGD</b>">Fitxer <b>exportacioDadesCentre<?php echo $a;?>.xml</b></td>
        <td><?php echo $missatge;?></td>
    </tr>
    <tr>
      <form method="POST" action="xmlupdate.php" name="xml" id="xml" ENCTYPE="multipart/form-data">
        <td></td>
        <td>
            <div class="file-field input-field">
              <div class="btn-small <?php echo $colorweb;?>">
                <i class="material-icons">search</i>
                <input type="file" name="archivo" accept="application/pdf">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
>
                <label>Adjuntar fitxer exportacioDadesCentre.xml</label>
              </div>
            </div>
        </td>
        <td>
          <i class="material-icons pointer <?php echo $colortit;?>" onclick="document.getElementById('xml').submit();">send</i>
        </td>
      </form>
    </tr>
    <tr>
        <th colspan="3">Taules del fitxer <i>exportacioDadesCentre<?php echo $a;?>.xml</i> que s'han d'actualitzar al llarg del curs</th>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td><a href="<?php if ($error==0) {echo "xmlprof.php";}?>">Crear taula professorat profes<?php echo $a;?></a></td>
        <td><?php echo tabla_existe("profes".$a,$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td><a href="<?php if ($error==0) {echo "xmldeps.php";}?>">Crear taula departaments deps<?php echo $a;?></a></td>
        <td><?php echo tabla_existe("deps".$a,$link,$db);?></td>
    </tr>

    <tr>
        <th colspan="3">Taules que es creen una única vegada a començament del curs</th>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Comandes dels departaments"><?php if (tabla_existe("comanda".$a,$link,$db)=="Taula no existent") {
            ?><a href="xmlcomand.php?url=xmlcreatablas">Crear taules <?php echo "comanda",$a," i comandadetall",$a;?></a><?php 
        } else {
            echo 'comanda',$a;
        }?></td>
        <td><?php echo tabla_existe("comanda".$a,$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Detall de les comandes vinculada a l'anterior"><?php if (tabla_existe("comandadetall".$a,$link,$db)=="Taula no existent") {
            ?><a href="xmlcomand.php?url=xmlcreatablas">Crear taules <?php echo "comanda",$a," i comandadetall",$a;?></a><?php 
        } else {
            echo "comandadetall",$a;
        }?></td>
        <td><?php echo tabla_existe("comanda".$a,$link,$db);?></td>
    </tr>
    <tr>
        <th colspan="3"><h5 class="header center <?php echo $colorweb;?>-text text-darken-4">Taules permanents</h5></th>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Registre d'activitat a la intranet"><a href="activitat.php">activitat</a></td>
        <td><?php echo tabla_existe("activitat",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Ajuda dels menús de la intranet">ajuda</td>
        <td><?php echo tabla_existe("ajuda",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Còpies de seguretat de la base de dades">backup</td>
        <td><?php echo tabla_existe("backup",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Dades del centre (nom, dades de contacte, CIF, etc)"><a href="dades.php">dades</a></td>
        <td><?php echo tabla_existe("dades",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Oferta educativa del centre"><a href="oferta.php">oferta</a></td>
        <td><?php echo tabla_existe("oferta",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Permisos individuals dels usuaris (comandes de centre, administració d'usuaris, etc)"><a href="permisosqui.php">permisos</a></td>
        <td><?php echo tabla_existe("permisos",$link,$db);?></td>
    </tr>
    <tr>
        <td><?php echo $n;$n++;?></td>
        <td class="tooltipped" data-position="bottom" data-tooltip="Usuaris"><a href="Usuaris.php">usuaris</a></td>
        <td><?php echo tabla_existe("usuaris",$link,$db);?></td>
    </tr>
</table>
</div>

<div class="container">
<h5 class="header center <?php echo $colorweb;?>-text text-darken-4">Utilitats</h5>
<table class="bordered striped">
    <tr>
        <td><a href="xmlbackup.php">Crear còpia de seguretat</a></td>
        <td>
        <?php
        $sql = "SELECT * FROM backup ORDER BY id DESC LIMIT 1";
        $res = mysqli_query($link, $sql);
        mysqli_close($link);

        // Imprimir el registro más reciente
        if (mysqli_num_rows($res) > 0) {
            while($fila = mysqli_fetch_assoc($res)) {
                $darrer = substr($fila["copia"], 0, 10);
                $dma=explode('-',$darrer);
                $timestamp1 = mktime(0,0,0,$dma[1],$dma[2],$dma[0]); 
                $timestamp2 = mktime(0,0,0,date('m'),date('d'),date('Y'));
                $difback = round(($timestamp2-$timestamp1)/(60*60*24));
                echo "Darrera còpia fa ".$difback." dies, el ".$dma[2].'/'.$dma[1].'/'.$dma[0];
            }
        } else {
            echo "No hi ha còpia de seguretat";
        }
        ?></td>
    </tr>
    <tr>
        <td><a href="<?php include('servidor.php');?>" target="_blank">Panell de control servidor</a></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="<?php include('phpmyadmin.php');?>" target="_blank">PHPmyAdmin</a></td>
        <td></td>
    </tr>
    <tr>
        <td><a href="infophp.php" target="_blank">Informació PHP</a></td>
        <td></td>
    </tr>
</table>
</div>

</main>
<?php include("footer.php");
if (isset($_GET['e'])) {
    $e=array("S'ha actualitzat el fitxer exportacioDadesCentre".$a.".xml. Recorda actualitzar les taules corresponents.","El fitxer excedeix els 32Mb","No s'ha adjuntat un fitxer XML","No s'ha pogut adjuntar el fitxer","No s'ha adjuntat cap fitxer");?>
    <script language='javascript'>alert ("<?php echo $e[$_GET['e']];?>");</script>
<?php }?>
</body>
</html>