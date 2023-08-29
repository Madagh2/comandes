<?php
    echo 'Versión actual de PHP: ' . phpversion() . "<br>";

    phpinfo(INFO_ALL); 

    $gd=gd_info();
    foreach($gd as $key=>$value) {
        echo $key," -> ",$value,"<br>";
    }
?>
