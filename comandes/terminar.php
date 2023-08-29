<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
</head>
<body>
<div style='position: fixed; top: 45%; left: 40%;'>Has tancat la sessió...</div>
<script>
Url='index.php'
Win='_self'
Time=2000
setTimeout("open(Url,Win)",Time);
</script>
</body>
</html>