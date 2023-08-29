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
$titol="Dades del Centre";
include ("capg.php");
?>
<main>
<div class="container">
    <div class="card">
		<h4 class="mostra header <?php echo $colortit;?>">Dades del centre</h4>
	    <form method="POST" action="dadesact.php" name="comandnou" ENCTYPE="multipart/form-data">
		    <?php $sql="SELECT * FROM dades ORDER BY id";
		    $query = mysqli_query($link,$sql);
		    while ($row = mysqli_fetch_assoc($query)) {
		      	$id=$row['id'];
				$camp=$row['camp'];
				switch($camp) {
					case "color":?>
						<div class="input-field">
							<input name="valor<?php echo $id;?>" id="valor<?php echo $id;?>" type="text" value="<?php echo $row['valor'];?>" readonly/>
							<label for="valor<?php echo $id;?>">color</label>
							<?php $col=array("red","pink","purple","deep-purple","indigo","blue","light-blue","cyan","teal","green","light-green","lime","yellow","amber","orange","deep-orange","brown","grey","blue-grey");
                    		foreach ($col as $key => $value) {?>
								<span id="<?php echo $value;?>" style="cursor: pointer;" class="material-symbols-outlined <?php echo $value;?>-text" onclick="document.getElementById(document.getElementById('valor<?php echo $id;?>').value).innerHTML = 'crop_square'; this.innerHTML = 'check_box'; document.getElementById('valor<?php echo $id;?>').value = '<?php echo $value;?>'"><?php echo ($value==$row['valor'] ? 'check_box' : 'crop_square');?></span>
							<?php }?>
						</div><?php ;
						break;
					default:?>
						<div class="input-field">
							<input name="valor<?php echo $id;?>" id="valor<?php echo $id;?>" type="text" value="<?php echo $row['valor'];?>"/>
							<label for="valor<?php echo $id;?>"><?php echo $camp;?></label>
						</div><?php ;
						break;
		    	}
			}?>
            <div class="input-field center">
                <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons right">send</i>Actualitza les dades</button>
            </div>

		</form>
    </div>
	<!-- Logo -->
	<?php
	// Logo
	imgcard("logosol", "Logotip senzill", ", proporció aproximada 1:1", "dades", 100);
	// Logo gros
	imgcard("logocentre", "Logotip gros", ", per als vals de compra", "dades", 300);
	// Logo
	imgcard("bg", "Fons semitransparent menú lateral", " escala de grisos, proporció aproximada 3:2", "dades", 300);
	?>
</div>
</main>
<?php include("footer.php");
include("footerform.php");?>
</body>
</html>