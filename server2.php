<?php
header('Content-type: text/html; charset=utf-8');
echo "<pre>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ( isset($_POST['ImageName']) && isset($_POST['base64']) ) {

		$command = $_POST['ImageName'];
		echo "Commande : ".$command."\n";
		
		// on enleve l'eventuel ".JPG" ou ".jpg" à la fin de la commande
		if (strstr($command, ".jpg") != FALSE) {
			echo "Commande : ".explode(".jpg",$command)[0]."\n";
		} else if (strstr($command, ".JPG") != FALSE) {
			echo "Commande : ".explode(".JPG",$command)[0]."\n";
		}
		
		$html_dir = "/var/www/html/";
		$database_dir = "database/";
		$uploads_dir = "uploads/";
		$image_name_aleatory = MD5(microtime());
		$image_extention = ".jpg";
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$image_save_path = "C:\\wamp\\www\\uploads\\".$image_name_aleatory.$image_extention;
		} else {
			$image_save_path = $html_dir.$uploads_dir.$image_name_aleatory.$image_extention;
		}
		
		$image_data = base64_decode($_POST['base64']);
		$fp = fopen($image_save_path, 'w');
		if(fwrite($fp, $image_data) != false){
			echo "Image uploaded";
		}
		else{
			echo "Error uploading image";
		}
		fclose($fp);
	}
	else {
		echo "Nécessite champs POST : 'ImageName' et 'base64'";
	}
}
else {
	echo "Utiliser la méthode POST";
}

echo "</pre>";
?>