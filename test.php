<?php
if (isset($_POST['action'])) { echo 'works';}
?>
<html>
<body>
<form id="f1" method="post" action="<?php $_PHP_SELF ?>" >
	<input type="text" value="UPDATE" id="action" name="action">
	<input type="submit" id="submit" >
</form>

</body>
</html>