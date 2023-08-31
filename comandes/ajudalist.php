<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php
include ("head.php");
include("conexion.php");?>
  <style type="text/css">
    ul {
        margin: inherit !important;
        padding: inherit !important;
        list-style-type: inherit !important;
    }

    ul > li {
        margin: inherit !important;
        padding: inherit !important;
        list-style-type: inherit !important;
    }
  </style>

</head>

<body>
	<?php 
	$titol="Ajuda";
	include ("capg.php");
	?>
<main>
	<div class="container">
		
			<?php 
			$sql = "select * from ajuda";
			$res = mysqli_query($link,$sql);
			while($row = mysqli_fetch_array ($res))
			{
				$id = $row['id'];
				$pagina = $row['pagina'];
                $item = $row['item'];
                $text = stripslashes($row['text']);
                ?>
                <div class="card">
                    <div class="row browser-default">
                        <div class="col s2">
                            <?php echo $pagina;?><br>
                            <a href="javascript:ajuda('ajuda.php?id=<?php echo $pagina;?>')" class="<?php echo $colortit;?>"><i class="material-icons">edit</i></a>
                        </div>
                        <div class="col s10">
                            <h3 class="<?php echo $colortit;?> center"><?php echo $item;?></h3>
                        </div>
                        <div class="col s12">
                            <?php echo $text;?>
                        </div>
                    </div>
                </div>
			<?php }
			?>
		
	</div>
	</main>
<?php include("footer.php");?>
</body>
</html>