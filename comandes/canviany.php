<?PHP
    session_start();
    $_SESSION['anyacad']= $_GET['curs'];
    header ("Location: ".$_SERVER['HTTP_REFERER']);
?>
