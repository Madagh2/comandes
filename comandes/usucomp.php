<?PHP
include ("seguridad.php");
include("conexion.php");
$sql = "SELECT * FROM usuaris WHERE user='".$_GET['user']."'";
$result = $link->query($sql);
$esta=mysqli_num_rows($result);
$txt="Usuari<br>".($esta==0 ? "" : "no<br>")."disponible";
$col=($esta==0 ? "#B9F6CA" : "#FF8A80");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
	<title><?php include("dades/centre.php");?></title>
	<link href="img/icona.ico" rel="shortcut icon" />
	<style type="text/css">
		body {
			background-color: <?php echo $col;?>;
			font-family: sans-serif;
		}
		.padre-transform{
			height: 100vh;
			min-height:600px;
		}
		.padre-transform > div{
			position: absolute;
			top:50%;
			left: 50%;
			transform: translate(-50%,-50%);
			max-width: 50%;
			text-align: center;
		}
	</style>
</head>
<body>
	<div class="padre-transform">
	<div>
		<b><?php echo $txt;?></b> 
	</div>
</div>
<script>
	setTimeout("self.close()", 4000 ) // after 5 seconds
</script>
</body>
</html>