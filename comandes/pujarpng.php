<?php
function imgcard($logo, $txt, $obs, $url, $width) {
    global $colorweb;
    global $colortit;?>
	<div class="card horizontal">
      <div class="card-image">
        <img src="img/<?php echo $logo;?>.png" style="max-height: 120px">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p><?php echo $txt;?></p>
		  <p class="red08">* L'actualització d'imatges necessita esborrar la caché del navegador per veure els canvis.</p>
        </div>
        <div class="card-action">
		  <form method="POST" action="imgact.php" name="<?php echo $logo;?>" id="<?php echo $logo;?>" ENCTYPE="multipart/form-data">
		    <div class="file-field input-field">
		      <div class="btn-small <?php echo $colorweb;?>">
		        <i class="material-icons">image_search</i>
		        <input type="file" name="archivo" accept="image/png">
		      </div>
		      <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
                <label>Adjuntar imatge PNG<?php echo $obs;?></label>
		      </div>
		      <i class="material-icons right pointer <?php echo $colortit;?>" onclick="document.getElementById('<?php echo $logo;?>').submit();">send</i>
		      <input type="hidden" name="img" value="<?php echo $logo;?>">
		      <input type="hidden" name="width" value="<?php echo $width;?>">
		      <input type="hidden" name="url" value="<?php echo $url;?>">
		    </div>
		  </form>
        </div>
      </div>
    </div>
<?php }?>
