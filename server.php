<?php
header('Content-type: text/html; charset=utf-8');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ( isset($_POST['command']) && is_uploaded_file($_FILES['file']['tmp_name']) ) {
		echo "<pre>";
		
		$command = $_POST['command'];
		echo "Commande : ".$command."\n";
		
		if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
			echo "Fichier uploadé avec sucess\n";
			
			$file_name = $_FILES['file']['name'];
			$file_tmp_name = $_FILES['file']['tmp_name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			
			$document_root_dir = $_SERVER['DOCUMENT_ROOT'];
			$database_dir = "database/";
			$uploads_dir = "uploads/";
			$file_name_aleatory = MD5(microtime());
			$file_extention = ".jpg";
			
			$file_save_path = $document_root_dir.$uploads_dir.$file_name_aleatory.$file_extention;
			
			echo "Fichier nom  : ".$file_name."\n";
			echo "Fichier type : ".$file_type."\n";
			echo "Fichier taille : ".$file_size."\n";
			echo "Fichier tmp : ".$file_tmp_name."\n";
			echo "Fichier sauvegardé : ".$file_save_path."\n";
			
			move_uploaded_file($file_tmp_name, $file_save_path);
		} 
		else echo $_FILES['file']['error'] . "\n";
		
		echo "</pre>";
	}
}
?>