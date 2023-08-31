<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php
include ("head.php");
include("conexion.php");?>
</head>

<body>
	<?php 
	$titol="Còpies de seguretat";
	include ("capg.php");
	?>
<main>
	<div class="container">
		<table class="bordered striped">
			<tr><th>Id</th><th>Còpia</th><th>Mida</th><th>Esborrar</th></tr>
			<?php 
			$sql = "select * from backup";
			$res = mysqli_query($link,$sql);
			while($row = mysqli_fetch_array ($res))
			{
				$id = $row['id'];
				$copia = $row['copia'];
                $filename = 'backup/'.$copia.'.sql.gz';
                if (file_exists($filename)) {
                    $filesize = filesize($filename);
                } else {
                    echo 'The file does not exist.';
                }?>
                <tr>
                    <tr><td><?php echo $id;?></td>
				    <td><a href="<?php echo $filename;?>" target="_blank"><?php echo $copia;?></a></td>
				    <td><?php echo $filesize;?>&nbsp;bytes</td>
				    <td><a href="copiaesb.php?c=<?php echo $copia;?>" class="<?php echo $colortit;?>"><i class="material-icons">delete</i></a></td>
                </tr>
			<?php }
			?>
		</table>
	</div>
	</main>
<?php include("footer.php");?>
</body>
</html>