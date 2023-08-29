    <?php include "meta.php";?>
    
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen"/>

    <?php 
    include ('dades/color.php');
    $colorbut=$colorweb." darken-4";
    $colortit=$colorweb."-text text-darken-4";
    $colornav=$colorweb." lighten-3";
    include ('tablaexiste.php');
    ?>

    <script>
    function mostrardiv(id) {
        div = document.getElementById(id);
        if (div.style.display == 'none') {div.style.display = '';}
        else {div.style.display = 'none';}
    }
    function ajuda(pagina) {
        window.open(pagina,'Ajuda','height=500,width=600,resizable=yes,scrollbars=yes,status=no,toolbar=no,menubar=no,location=no,marginweight=0,screenX=1500,screenY=0,left=1500,top=0');
    }
    </script>
