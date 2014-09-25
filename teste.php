<?php
$type = explode('/',$_FILES['img']['type']);
$img  = $_FILES['img']['tmp_name'];
echo $img .'.'.$type[0].'</br>';
echo $type[1].'</br>';
var_dump($_FILES);
?>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="img">
<button type="submit">submeter</button>

</form>