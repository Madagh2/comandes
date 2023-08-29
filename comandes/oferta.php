<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");?>
</head>
<body>
<?php 
include("conexion.php");
$titol="Oferta educativa";
include ("capg.php");
?>
<main>
<div class="container">
  <div class="card">
	<?php $nivell=array ("GB" => "Grau bàsic", "GM" => "Grau mitjà","GS" => "Grau superior");?>
	<h4 class="header <?php echo $colortit;?>">Oferta educativa</h4>
    <?php $sqlf="SELECT DISTINCT familia FROM oferta ORDER BY familia";
    $queryf = mysqli_query($link,$sqlf);
    while ($rowf = mysqli_fetch_assoc($queryf)) {?>
	  <div class="row">
	  	<div class="col s12 b <?php echo $colortit;?>">
	  		<?php echo $rowf['familia'];?>
	    </div>
	  </div>
      <?php $sqle='SELECT DISTINCT nivell FROM oferta WHERE familia="'.$rowf['familia'].'" ORDER BY nivell';
      $querye = mysqli_query($link,$sqle);
      while ($rowe = mysqli_fetch_assoc($querye)) {?>
		  <div class="row">
		  	<div class="col s1">
		  	</div>
		  	<div class="col s11">
		  		<?php echo $nivell[$rowe['nivell']];?>
		    </div>
		  </div>
	      <?php $sqlc='SELECT * FROM oferta WHERE familia="'.$rowf['familia'].'" AND nivell="'.$rowe['nivell'].'" ORDER BY codi';
	      $queryc = mysqli_query($link,$sqlc);
	      while ($rowc = mysqli_fetch_assoc($queryc)) {?>
			  <div class="row">
			  	<div class="col s2">
			  	</div>
			  	<div class="col s10">
			  		<?php echo $rowc['codi']," ",$rowc['nom'];?>
			    </div>
			  </div>
	      <?php }
	  }
    }?>       
  </div>
	<div class="card">
		<h5 class="header <?php echo $colortit;?>">Nous estudis</h4>
		<form method="POST" action="ofertaact.php" name="ofertanou" ENCTYPE="multipart/form-data">
			<div class="input-field">
				<?php
				$opt = array();
				$sqle="SELECT DISTINCT familia FROM oferta ORDER BY familia";
				$querye = mysqli_query($link,$sqle);
				while ($rowe = mysqli_fetch_assoc($querye)) {$opt[] = $rowe['familia'];}
				$html = '<select name="familia" id="familia">
				<option value="" disabled selected>Selecciona família</option>';
				foreach ($opt as $valor) {
					$html .= '<option value="'.$valor.'">'.$valor.'</option>';
				}
				$html .= '</select>';
				echo $html;
				?>
				<label for="familia">Familia</label>
			</div>
			<div class="input-field">
				<input type="text" value="" id="familiaa" name="familiaa"/>
				<label for="familiaa">Escriu família si no apareix al llistat</label>
			</div>
			<div class="input-field">
				<?php
				$html = '<select name="nivell" id="nivell">
				<option value="" disabled selected>Selecciona nivell</option>';
				foreach ($nivell as $valor => $text) {
					$html .= '<option value="'.$valor.'">'.$valor.' - '.$text.'</option>';
				}
				$html .= '</select>';
				echo $html;
				?>
				<label for="nivell">Nivell</label>
			</div>
			<div class="input-field">
				<input name="codi" id="codi" type="text" value=""  onkeyup="this.value = this.value.toUpperCase();"/>
				<label for="codi">Codi</label>
			</div>
			<div class="input-field">
				<input name="nom" id="nom" type="text" value=""/>
				<label for="nom">Nom</label>
			</div>
			<div class="input-field center">
				<input type="hidden" name="oid" value="0">
				<button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons right">send</i>Envia</button>
			</div>
		</form>
	</div>
</div>
</main>
<?php
include("footer.php");
include("footerform.php");
?>
</body>
</html>