<?php include ("seguridad.php");?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php //include ("head.php");
  include("conexion.php");?>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Editor Summernote -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script type="text/javascript">
    function mostrardiv(id) {
      div = document.getElementById(id);
      if (div.style.display == 'none') {div.style.display = '';} else {div.style.display = 'none'}
    }
  </script>
  <style type="text/css">
    h4.item {
      text-align: center;
      font-weight: bolder;
      color: #006EBE;
    }
    .material-icons {
      color: #ffffff;
      background-color: #006EBE;
    }
  </style>
</head>
<body>
<main>
<?php
$id=$_GET['id'];
if ($id=="") {?>
  <h4 class="item"><?php echo $estil;?>>Ítem no existent</h4>
<?php } else {
  $estil="";
  if ($_SESSION['nivell']<'1') {$estil=" onclick='javascript:mostrardiv(1);' style='cursor: pointer;'";}
  $sql = "select * from ajuda where pagina='".$id."'";
  $res = mysqli_query($link,$sql);
  $num = mysqli_num_rows($res);
  if ($num==0) {?>
    <h4 class="item"<?php echo $estil;?>>Ítem no existent</h4>
    <div class="container">
      <i>No existeix ajuda sobre aquesta pàgina.</i>
    </div>
  <?php } else {
    $row = mysqli_fetch_array($res);?>
    <h4 class="item"<?php echo $estil;?>><?php echo stripslashes($row['item']);?></h4>
    <div class="container">
      <?php echo stripslashes($row['text']);?>
    </div>
  <?php }
  if ($_SESSION['nivell']<'1' OR permis('ajuda')==1) {?>
    <hr>
    <a onclick='javascript:mostrardiv(1);' style='cursor: pointer;'><span class="material-icons">edit</span> Edita l'ajuda d'aquesta pàgina</a>
    <div id="1" style="display: none;" class="container">
      <form name="nouajuda" action="ajudanou.php" method="POST">
        <input name="item" type="text" value="<?php if ($num!=0) {echo stripslashes($row['item']);}?>" style="width: 100%;"/><br />
        <textarea id="summernote" name="text" rows="10" style="width: 100%;">
        <?php if ($num!=0) {echo stripslashes($row['text']);}?>
        </textarea>
        <input type="hidden" name="id" value="<?php echo $id;?>" />
        <input type="hidden" name="num" value="<?php echo $num;?>" />
        <input type="submit" name="Actualitzar" value="Actualitzar" style="width: 100%;"/>
      </form>
    </div>
  <?php }
}?>
<hr>
<a href="javascript:self.close()">Tanca l'ajuda</a>
</main>
<?php //include("footer.php");?>
<script type="text/javascript">
  $('#summernote').summernote({
    height: 300,                 // set editor height
    minHeight: 200,             // set minimum height of editor
    maxHeight: 600             // set maximum height of editor
  });
</script>
</body>
</html>
