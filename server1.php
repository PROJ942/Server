<?php
header('Content-type: text/html; charset=utf-8'); // encodage utf-8 du script 
echo "<pre>";
// Test si les demmandes sont faites par la methode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// On test si les champs POST 'ImageName' et 'base64'
	if ( isset($_POST['ImageName']) && isset($_POST['base64']) ) {
		
		// Récupération de la commande
		$command = $_POST['ImageName'];
		echo "Commande : ".$command."\n";
		
		// Prétratement de la commande on enleve l'eventuel ".JPG" ou ".jpg" à la fin de la commande
		if (strstr($command, ".jpg") != FALSE) {
			$command = explode(".jpg",$command)[0];
			echo "Commande prétraitée : ".$command."\n";
		} else if (strstr($command, ".JPG") != FALSE) {
			$command = explode(".JPG",$command)[0];
			echo "Commande prétraitée : ".$command."\n";
		}
		
		// Traitement de la commande dans la cas d'un ajout
		if (stristr($command, "add") != FALSE) {
			$command_split = explode("_",$command);
			$command_choice = $command_split[0];
			$command_add_prenom = $command_split[1];
			$command_add_nom = $command_split[2];
			
			echo "Commande choix : ".$command_choice."\n";
			echo "Commande ajout prenom : ".$command_add_prenom."\n";
			echo "Commande ajout nom : ".$command_add_nom."\n";
		} // Traitement de la commande dans la cas d'une reconnaissance
		else {
			$command_choice = "reco";
			echo "Commande choix : ".$command_choice."\n";
		}
		
		// Traitement du fichier envoyer en base64
		// Gestion de dossiers et génération du nom de fichier
		$html_dir = "/var/www/html/";
		$database_dir = "bdd_img/";
		$uploads_dir = "uploads/";
		$image_name_aleatory = MD5(microtime());
		$image_extention = ".jpg";
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			$image_save_path = "C:\\wamp\\www\\uploads\\".$image_name_aleatory.$image_extention;
		} else {
			$image_save_path = $html_dir.$uploads_dir.$image_name_aleatory.$image_extention;
		}
		
		// Enregistrement du fichier dans le répertoire d'upload sous le nom spécifié
		$image_data = base64_decode($_POST['base64']);
		$fp = fopen($image_save_path, 'w');
		if(fwrite($fp, $image_data) != false){
			echo "Image uploaded : ".$image_save_path."\n";
			$image_successfully_updated = true;
		}
		else{
			echo "Error uploading image";
			$image_successfully_updated = false;
		}
		fclose($fp);
		
		$prog_name = "recovisage1";
		$base_used = "csv.ext";
		if ($image_successfully_updated == true) {
			if (stristr($command_choice, "add") == true) {
				$exec_command = "$html_dir$prog_name $html_dir$base_used $image_save_path add $command_add_prenom'_'$command_add_nom";
			} else if (stristr($command_choice, "reco") == true){
				$exec_command = "$html_dir$prog_name $html_dir$base_used $image_save_path reco";
			}
			echo "exec_command ".$command_choice." : ".$exec_command."\n";
			$return = exec($exec_command, $output, $return_var);
			echo "return : ".$return."\n";
			echo "output : ";
			print_r($output);
			echo "\n";
		}
		
	}
	// on attend les champs POST 'ImageName' et 'base64'
	else {
		echo "Nécessite champs POST : 'ImageName' et 'base64'";
	}
}
// Les demmandes doivent être faites par la methode POST
else {
	echo "Utiliser la méthode POST";
}

echo "</pre>";
?>