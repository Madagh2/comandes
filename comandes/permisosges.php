<?php include ("seguridad.php");
if ($_SESSION['nivell']!='0') {header ("Location: menu.php");}?>
<!DOCTYPE html>
<html lang="ca">
<head>
<?php include ("head.php");
function dec2bin($dec) {
    // Better function for dec to bin. Support much bigger values, but doesn’t support signs
    for($b='',$r=$dec;$r>1;){
        $n = floor($r/2); $b = ($r-$n*2).$b; $r = $n; // $r%2 is inaccurate when using bigger values (like 11.435.168.214)!
    }
    return ($r%2).$b;
}?>
</head>
<body>
<?php include("conexion.php");
$titol="Gestió de permisos individuals";
include ("capg.php");?>

<main>
<div class="container">
    <a href="permisosqui.php">Veure permisos per acció</a>
</div>

<div class="container">
  <div class="card">
    <form name="permisgesact" action="permisgesact.php" method="POST">
    <!-- Permisos varis -->
        <h5 class="header <?php echo $colortit;?>">Permisos</h5>
        <p class="red08">* La modificació d'aquests permisos requereix modificar l'aplicació. La seva supresió pot suposar que deixi de funcionar correctament.</p>
        <table class="stripped">
            <tr>
                <th style="width: 1%;">Id</th><th style="width: 1%;">Codi</th><th>Descripció</th><th style="width: 1%;">Esborrar</th>
            </tr>
            <?php $sqlp="SELECT * FROM permisos order by id";
            $queryp = mysqli_query($link,$sqlp);
            while ($rowp = mysqli_fetch_assoc($queryp)) {?>
                <tr>
                    <td><?php echo $rowp['id'];?></td>
                    <td><?php echo $rowp['codi'];?></td>
                    <td>
                        <div class="input-field">
                            <input type="text" value="<?php echo $rowp['descr'];?>" id="descr<?php echo $rowp['id'];?>" name="descr<?php echo $rowp['id'];?>" pattern="[^&quot;]*" title="Caràcter dobles cometes (&quot;) no està permés" oninvalid="alert('El caràcter dobles cometes (&quot;) no està permés a la descripció.');"/>
                        </div>
                    </td>
                    <td class="center">
                        <label>
                            <input type="checkbox" id="esb<?php echo $rowp['id'];?>" name="esb<?php echo $rowp['id'];?>" value="1" />
                            <span></span>
                        </label>
                    </td>
                </tr>
            <?php }?>
            <tr>
                <td><i>Nova</i></td>
                <td>
                    <div class="input-field">
                        <input type="text" value="" id="codi" name="codi" pattern="[a-z]+" title="Només lletres minúscules" oninvalid="alert('Codi només amb lletres minúscules');" />
                        <label for="codi">Codi</label>
                    </div>
                </td>
                <td>
                    <div class="input-field">
                        <input type="text" value="" id="descr" name="descr" pattern="[^&quot;]*" title="Caràcter dobles cometes (&quot;) no està permés" oninvalid="alert('El caràcter dobles cometes (&quot;) no està permés a la descripció.');" />
                        <label for="descr">Descripció</label>
                    </div>
                </td>
                <td></td>
            </tr>
        </table>
        <div class="row">
            <div class="input-field col s12 center">
                <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons">send</i></button>
            </div>
        </div>
    </form>
  </div>
</div>
</main>
<?php include("footer.php");?>
</body>
</html>
