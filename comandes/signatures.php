<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");
include ("pujarpng.php");?>
</head>
<body>
<?php 
include("conexion.php");
$titol="Gestió de signatures";
include ("capg.php");
?>
<main>
<div class="container">
	<h4 class="mostra header <?php echo $colortit;?>">Signatures per als vals de compra</h4>
	<?php
	// Administrador i segell
	imgcard("firmasello", "Administrador i segell", "", "signatures", 500);
	// Caps de departament
	$file="deps".$a;
	$sql = (file_exists($file) ? "SELECT * FROM ".$file." ORDER BY departament" : "SELECT DISTINCT(departament) FROM usuaris WHERE departament NOT IN ('Altres', 'No docent') ORDER BY departament");
	$res = mysqli_query($link,$sql);
	if (mysqli_num_rows($res)==0) {?>
		<div class="card horizontal">
		<p>No s'han definit els departaments.<br>Els departaments es defineixen quan s'assignen als usuaris en <a href="usuaris.php">Gestió d'usuaris</a> o quan s'importen les dades del Gestib en <a href="xmlcreatablas.php">Bases de dades</a></p>
		</div>
	<?php } else {
		while($row = mysqli_fetch_array ($res)) {
			$dep=$row['departament'];
			$codi=$row['codi'];
			$nf = "firma".preg_replace("/[^A-Za-z0-9]/", '', $dep);
			imgcard($nf, $dep, "", "signatures", 500);
		}
	}?>
</div>
</main>
<?php include("footer.php");?>
</body>
</html>