<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php
include ("head.php");
include("conexion.php");?>
	<STYLE type="text/css">
		.error {
			background-color: #eebbcc;
		}
		.seg {
			background-color: #eeeecc;
		}
		.sqr {
			background-color: #bbeecc;
		}
	</STYLE>
</head>

<body>
	<?php 
	$titol="Activitat a l'aplicació Comandes";
	include ("capg.php");
	?>
<main>
	<div class="container">
		<table class="bordered striped">
			<tr><th>Id</th><th>user</th><th>Observacions</th><th>Data</th></tr>
			<?php 
			$n=0;
			$sqlr="SELECT max(id_act) as t FROM activitat";
			$queryr = mysqli_query($link,$sqlr);
			$rowr = mysqli_fetch_assoc($queryr);
			$max=$rowr['t'];
			$sql = "select * from activitat WHERE data>'2010-08-01'";
			if ($_GET['id']!="") {$sql.=" AND id_act<'".$_GET['id']."'";}
			$sql.=" ORDER BY id_act DESC";
			//echo $max," - ",$sql,"<br />";
			$res = mysqli_query($link,$sql);
			while($row = mysqli_fetch_array ($res))
			{
				$cl="";
				$id = $row['id_act'];
				$user = $row['user'];
				$obs = $row['obs'];
				if ($obs=="Nou error") {
					$cl=" class='error'";
					$obs="<a href='llistaerrors.php'>".$row['obs']."</a>";
				}
				if ($obs=="Nou SQR") {$cl=" class='sqr'";}
				if (substr($obs,0,3)=="Seg") {$cl=" class='seg'";}

				$data = $row['data'];
				echo "<tr><td".$cl.">".$id."</td>";
				echo "<td".$cl.">".$user."</td>";
				echo "<td".$cl.">".$obs."</td>";
				echo "<td".$cl.">".$data."</td></tr>";
				$n++;
				if ($n==50) {break;}
			}
			?>
		</table>
	
		<div class="row">
			<div class="col s6">
				<?php 
				$ant=$id+100;
				echo ($_GET['id']=="" ? "" : '<a href="activitat.php'.($ant>=$max ? '' : '?id='.$ant).'">50 anteriors...</a>');?>
			</div>
			<div class="col s6">
				<?php echo ($n<50 ? '' : '<a href="activitat.php?id='.$id.'">50 següents...</a>');?>
			</div>
		</div>
	</div>
	</main>
<?php include("footer.php");?>
</body>
</html>