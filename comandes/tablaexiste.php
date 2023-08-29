<?php 
function tabla_existe($nombre_tb,$link,$db) {
    $sqltb = "SHOW TABLE STATUS FROM $db LIKE '$nombre_tb'";
    echo "<!--",$sqltb,"-->";
    $resulttb = $link->query($sqltb);
    echo "<!-- ",$resulttb->num_rows," -->";
    if (mysqli_num_rows($resulttb)==0) {
        return ("Taula no existent");
    } else {
        $rowtb = mysqli_fetch_assoc($resulttb);
        return ("Taula creada el ".$rowtb['Create_time']);
    }
}
?>