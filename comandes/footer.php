  <footer class="footer-copyright <?php echo $colornav;?>">
  	<div class="container">
        <div class="row center red08 notranslate">
            &copy; 2020 <?php include "dades/centre.php";?> - <?php include "dades/adreca.php";?>, <?php include "dades/cp.php";?> <?php include "dades/localitat.php";?> (Illes Balears)&nbsp;ESPANYA. Telèfon <?php include "dades/tel.php";?>
        </div>
    </div>
  </footer>

  <!--JavaScript at end of body for optimized loading-->
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script src="js/init.js"></script>
  <script type="text/javascript">
      $(document).ready(function(){
        $('.sidenav').sidenav();
        $('.collapsible').collapsible();
        $('.collapsible.expandable').collapsible({
          accordion: false
        });
        $('.tooltipped').tooltip({html: true});
        M.updateTextFields();
      });
  </script>
