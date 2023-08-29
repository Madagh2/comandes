<?php
echo "Creant arxiu de connexió";
	$file="conexion.php";
	$fh = fopen($file, 'w');
	$content = "<?php".PHP_EOL;
    $content .= "  \$host_name = '".$_POST['host']."';".PHP_EOL;
    $content .= "  \$db = '".$_POST['db']."';".PHP_EOL;
    $content .= "  \$user_name = '".$_POST['user']."';".PHP_EOL;
    $content .= "  \$password = '".$_POST['pass']."';".PHP_EOL;
    $content .= "  \$link = new mysqli(\$host_name, \$user_name, \$password, \$db);".PHP_EOL;
    $content .= "  if (\$link->connect_error) {".PHP_EOL;
    $content .= "    die('<p>Error conectant amb el servidor MySQL: '. \$link->connect_error .'</p>');".PHP_EOL;
    $content .= "  } else {}".PHP_EOL;
    $content .= ';?>';
	fwrite($fh, $content);
	fclose($fh);

    include("conexion.php");

echo "CREANT TAULES:";
echo "Creant taula usuaris...";
    $sql="CREATE TABLE `usuaris` (
        `uid` mediumint(8) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        `user` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
        `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        `pass` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        `departament` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
        `nivell` tinyint(4) NOT NULL,
        `capdep` tinyint(1) NOT NULL DEFAULT '0',
        `autoritzat` tinyint(1) NOT NULL DEFAULT '1',
        `permis` bigint(20) NOT NULL,
        `passcheck` date NOT NULL DEFAULT '2023-09-01',
        `altacentre` date NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);  

echo "Creant usuari administrador...";
    $sql="INSERT INTO `usuaris` (`uid`, `nom`, `user`, `email`, `pass`, `departament`, `nivell`, `capdep`, `autoritzat`, `permis`, `passcheck`, `altacentre`) VALUES
    (1, 'Administrador', 'admin', '', '21232f297a57a5a743894a0e4a801fc3', 'Altres', 0, 0, 2, 0, '2023-09-01', '0000-00-00');";
    $res = mysqli_query($link,$sql);
    $sql="ALTER TABLE `usuaris` AUTO_INCREMENT=2";
    $res = mysqli_query($link,$sql);
    

echo "Creant taula ajuda...";
    $sql="CREATE TABLE `ajuda` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `pagina` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
        `item` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `text` longtext COLLATE utf8mb4_unicode_ci,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);   

    $sql="INSERT INTO `ajuda` (`id`, `pagina`, `item`, `text`) VALUES
    (1, 'comand', 'Realització de comandes', '                <p><font color=\"#085294\"><span style=\"font-weight: 700;\">Llistat de comandes</span></font></p><p>El llistat mostrarà les comandes realitzades pel departament corresponent. El color indica l\'estat de la comanda i les accions disponibles:</p><ul><li><span style=\"background-color: rgb(231, 156, 156);\">Vermell</span>: pendent d\'autorització per part del cap de departament<ul><li><span style=\"text-align: justify;\">El/la professor/a que realitza la comanda pot realitzar canvis amb el botó&nbsp;<span class=\"material-icons\">edit</span>.</span></li><li><span style=\"text-align: justify;\">El cap de departament pot realitzar canvis.</span></li><li><span style=\"text-align: justify;\">El cap de departament ha d\'autoritzar la comanda amb l\'interruptor.</span></li></ul></li><li><span style=\"background-color: rgb(255, 255, 153);\">Groc</span>: pendent d\'aprovació per part de l\'equip directiu<ul><li><span style=\"text-align: justify;\">El/la professor/a que realitza la comanda&nbsp;<span style=\"font-weight: 700;\">no&nbsp;</span>pot realitzar canvis.</span></li><li><span style=\"text-align: justify;\">El cap de departament pot realitzar canvis.</span></li><li><span style=\"text-align: justify;\">L\'equip directiu&nbsp;</span><span style=\"text-align: justify;\">ha d\'autoritzar la comanda amb l\'interruptor.</span></li><li><span style=\"text-align: justify;\">L\'equip directiu pot introduir comentaris.</span></li></ul></li><li><span style=\"text-align: justify;\">​</span><span style=\"background-color: rgb(153, 255, 153);\">Verd</span>: la comanda està autoritzada<ul><li><span style=\"text-align: justify;\">El/la professor/a que realitza la comanda i el cap de departament&nbsp;</span><span style=\"font-weight: 700; text-align: justify;\">no&nbsp;</span><span style=\"text-align: justify;\">poden realitzar canvis</span></li><li><span style=\"text-align: justify;\">El/la professor/a que realitza la comanda i el cap de departament poden imprimir el val de compra amb el botó&nbsp;<span class=\"material-icons\">assignment</span>.</span></li><li><span style=\"text-align: justify;\">S\'ha de comprovar que les dades i signatures del val de compra siguin correctes.</span></li></ul></li></ul><p>Al principi de la pàgina hi ha un interruptor per filtrar les comandes.</p><ul><li><span class=\"material-icons\">toggle_off</span>&nbsp;<span style=\"font-weight: 700;\">Pendents</span>. Mostra les comandes vermelles i grogues, i les verds de les quals no s\'ha imprès el val de compra.</li><li><span class=\"material-icons\">toggle_on</span>&nbsp;<span style=\"font-weight: 700;\">Totes</span>. Mostra totes les comandes del departament, o de tots els departaments en cas de tenir permisos.</li></ul><p></p><p><font color=\"#085294\"><span style=\"font-weight: 700;\">Formulari de comanda</span></font></p><p>El/la professor/a que realitza la comanda ha d\'emplenar els camps següents:</p><ul><li><span style=\"font-weight: 700;\">Comunicada per</span>, apareix automàticament el nom del usuari actual i la data</li><li><span style=\"font-weight: 700;\">Departament</span>, per defecte apareix el departament. Determinats càrrecs unipersonals poden realitzar comandes de Centre, en aquest cas cal seleccionar&nbsp;<span style=\"font-weight: 700;\">Centre&nbsp;</span>per no carregar la comanda al seu departament.</li><li><span style=\"font-weight: 700;\">Curs</span>, seleccioneu el curs al llistat o deixar en blanc si no procedeix.</li><li><span style=\"font-weight: 700;\">Mòdul</span>, s\'ha de seleccionar al desplegable el mòdul del curs triat al qual es farà servir el material comanat, o deixar en blanc si no procedeix. En cas que no aparegui al desplegable s\'escriurà al camp següent.</li><li><span style=\"font-weight: 700;\">Proveïdor</span>, s\'ha de seleccionar al desplegable el proveïdor. En cas que no aparegui al desplegable s\'escriurà al camp següent. No es pot realitzar una comanda per més d\'un proveïdor.</li><li><span style=\"font-weight: 700;\">Full de comanda</span>. Per comandes amb molts d\'ítems es pot adjuntar un document amb els detalls. Només s\'admeten arxius&nbsp;<span style=\"font-weight: 700;\">PDF</span>&nbsp;amb una mida màxima de 5Mb.</li></ul><p>Feu clic a&nbsp;<span style=\"font-weight: 700;\">Continuar amb la sol·licitud</span>&nbsp;per introduir el detall de la comanda.</p>\r\n                '),
    (2, 'xmlcreatablas', 'Administració de bases de dades MySQL', '                        <p><span style=\"font-weight: 700;\"><font color=\"#085294\">Fitxer exportacioDadesCentreXXXX.xml</font></span></p><ul><li>L\'arxiu XML es genera al Gestib al menú&nbsp;<font color=\"#085294\"><span style=\"font-weight: 700; color: rgb(51, 51, 51);\">Alumnat - Importació/exportació SGD</span><span style=\"font-weight: 400; color: rgb(51, 51, 51);\">. L\'arxiu generat es diu&nbsp;</span><span style=\"font-weight: 700; color: rgb(51, 51, 51);\">exportacioDadesCentre.xml</span><span style=\"font-weight: 400; color: rgb(51, 51, 51);\">&nbsp;i s\'ha de pujar regularment amb el formulari corresponent, sobretot quan hi ha canvis de professorat.</span></font></li></ul><p><b style=\"\"><font color=\"#085294\">Taules del fitxer exportacioDadesCentreXXXX.xml que s\'han d\'actualitzar al llarg del curs</font></b></p><ul><li>Aquestes taules s\'han d\'actualitzar quan s\'acualitza&nbsp;el fitxer exportacioDadesCentreXXXX.xml</li></ul><p><font color=\"#085294\"><b>Taules que es creen una única vegada a començament del curs</b></font></p><ul><li>Aquestes taules es creen a partir del fitxer exportacioDadesCentreXXXX.xml al començament del curs.</li><li>El link només està actiu si la taula no existeix, quan la taula ja està creada està deshabilitat per seguretat</li></ul><p><b><font color=\"#085294\">Taules permanents</font></b></p><ul><li>Aquestes taules contenen dades de la aplicació i només es creen una vegada, no depenen del curs acadèmic però es pot modificar el seu contingut des de l\'aplicació</li><li>El link només està actiu si la taula no existeix, quan la taula ja està creada està deshabilitat per seguretat</li></ul><p><b><font color=\"#085294\">Utilitats</font></b></p><ul><li><b>Crear còpia de seguretat</b>. Genera fitxers .sql amb les taules que s\'han modificat des de la darrera còpia</li><li><b>Crear còpia de seguretat completa</b>. Genera fitxers .sql amb les taules que s\'han modificat des de la darrera còpia</li><li><b>Panell de control servidor</b>. Accedeix al panell de control del servidor on està allotjada la intranet. Es pot modificar al menú <b>Configuració - Dades del centre</b>.</li><li><b>PHPmyAdmin</b>.&nbsp;Accedeix a l\'administrador de bases de dades MySQL de la intranet. Es pot modificar al menú <b>Configuració - Dades del centre</b>.</li><li><b>Informació PHP</b>. Mostra la versió i configuració de PHP.</li></ul><p><br></p>\r\n\r\n<p></p>                        '),
    (3, 'signatures', 'Gestió de signatures', '                <p>Aquesta pàgina mostra les signatures que apareixen als vals de compres.</p><p>Corresponen a l\'administrador del centre amb el segell i als caps de les famílies professionals.</p><p>S\'han d\'actualitzar quan canvien els càrrecs.</p><p>La imatge ha d\'estar en format PNG. Les imatges seran redimensionades automàticament a un ample de 640px i altura proporcional.</p><p>Per actualitzar-les cal cercar la imatge amb el botó&nbsp;<i class=\"material-icons\">image_search</i> del formulari corresponent i enviar-la.</p><p>Una vegada actualitzada una signatura és possible que sigui necessari esborrar les dades de navegació del navegador on es vol imprimir el val de compra, ja que la caché guarda les imatges durant un temps i podria no mostrar la signatura correcta.</p>                '),
    (4, 'dades', 'Dades del centre', '                                <p><b style=\"\"><font color=\"#085294\">Dades del centre</font></b></p><p>Aquesta pàgina permet modificar les dades bàsiques de l\'aplicació sobre el centre i el servidor on està allotjat.</p><p>Aquestes dades són emprades per l\'aplicació en diferents parts con el peu de pàgina, els títols, les etiquetes <meta> o els vals de compra impresos.</p><p><b><font color=\"#085294\">Imatges</font></b></p><ul><li><b>Logotip sense text</b>. Logotip quadrat del centre, sense text. Apareix als encapçalaments de l\'aplicació.</li><li><b>Logotip amb text</b>.&nbsp;Logotip del centre amb text, amb format apaïsat. Apareix als vals de compra.</li><li><b>Fons menú lateral</b>. Imatge que apareix al menú desplegable lateral. La imatge es redimensionarà a 300px d\'ample. Quant a l\'altura, convé que tingui una relació 3:2. Així i tot, l\'altura de la imatge es veurà retallada en funció del contingut.</li></ul><p>Totes les imatges ha de ser en format PNG. És important seguir les especificacions assenyalades pel bon funcionament de l\'aplicació.</p><p>Una vegada actualitzada una imatge és possible que sigui necessari esborrar les dades de navegació del navegador, ja que la caché guarda les imatges durant un temps i podria no mostrar la imatge correcta.</p>                                '),
    (5, 'permisosqui', 'Permisos de l\'aplicació.', '<p>Aquesta pàgina mostra el llistat de permisos de l\'aplicació i quins usuaris tenen cada un d\'ells.</p><p>Per revocar o concedir permisos s\'ha d\'anar a la pàgina de dades de l\'usuari, fent clic sobre l\'usuari en pantalla o amb el menú <b>Gestió d\'usuaris</b>.&nbsp;</p>');";
    $res = mysqli_query($link,$sql);   
    $sql="ALTER TABLE `ajuda` AUTO_INCREMENT=6";
    $res = mysqli_query($link,$sql);
 
echo "Creant taula activitat...";    
    $sql="CREATE TABLE `activitat` (
        `id_act` int(11) NOT NULL AUTO_INCREMENT,
        `user` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `obs` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `data` datetime DEFAULT NULL,
        PRIMARY KEY (`id_act`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);   

echo "Creant taula backup...";   
    $sql="CREATE TABLE `backup` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `copia` varchar(25) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    $res = mysqli_query($link,$sql);   

echo "Creant taula dades...";
    $sql="CREATE TABLE `dades` (
        `id` tinyint(4) NOT NULL AUTO_INCREMENT,
        `camp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
        `valor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);   
    $sql="INSERT INTO `dades` (`id`, `camp`, `valor`) VALUES
    (1, 'centre', ' '),
    (2, 'codi', ' '),
    (3, 'cif', ' '),
    (4, 'tel', ' '),
    (5, 'adreca', ' '),
    (6, 'cp', ' '),
    (7, 'localitat', ' '),
    (8, 'fax', ' '),
    (9, 'email', ' '),
    (10, 'web', ' '),
    (11, 'servidor', ' '),
    (12, 'phpmyadmin', ' '),
    (13, 'color', 'indigo');";
    $res = mysqli_query($link,$sql);   
    $sql="ALTER TABLE `dades` AUTO_INCREMENT=14";
    $res = mysqli_query($link,$sql);

echo "Creant taula oferta...";
    $sql="CREATE TABLE `oferta` (
        `familia` varchar(35) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `nivell` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
        `codi` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL UNIQUE,
        `nom` varchar(77) COLLATE utf8mb4_unicode_ci DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);   

echo "Creant taula permisos...";
    $sql="CREATE TABLE `permisos` (
        `id` tinyint(4) NOT NULL AUTO_INCREMENT,
        `codi` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
        `descr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;";
    $res = mysqli_query($link,$sql);   
    $sql="INSERT INTO `permisos` (`id`, `codi`, `descr`) VALUES
    (1, 'usuaris', 'Administració d\'usuaris'),
    (2, 'comand', 'Autorització de comandes'),
    (3, 'centre', 'Comandes de centre'),
    (4, 'dades', 'Administració de dades, imatges i signatures'),
    (5, 'ajuda', 'Editar l\'ajuda en pantalla de l\'aplicació');";
    $res = mysqli_query($link,$sql);   
    $sql="ALTER TABLE `permisos` AUTO_INCREMENT=6";
    $res = mysqli_query($link,$sql);

    // Afegeix registre d'activitat i tanca la connexió 
    $sqlact = "INSERT INTO activitat (user, obs, data) VALUES ('', 'Creació de la conexió i la base de dades', NOW())";
    $resultact = mysqli_query($link,$sqlact);


    $tornar="index.php";
    header("Location: $tornar");
?>