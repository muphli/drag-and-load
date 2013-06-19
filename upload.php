<?php
	// Require the bootstrap
	require_once('bootstrap.php');

	//Anzahl Dateien
	$count = count($_FILES['file']['name']);
	$link = "";
	for($i = 0; $i < $count; $i++){
	    try {
    		// Upload the file with an alternative filename
    		$put = $dropbox->putFile($_FILES['file']['tmp_name'][$i], $_FILES['file']['name'][$i]);
    		$array = (array) $dropbox->shares($_FILES['file']['name'][$i]);
    		$link = $array["body"]->url;
    	} catch (\Dropbox\Exception\BadRequestException $e) {
	    	// The file extension is ignored by Dropbox (e.g. thumbs.db or .ds_store)
	    	echo 'Invalid file extension';
	    }
	}
	$fileFiles = "";
    if ($count > 1){
	    $fileFiles = "files";
    }
    else $fileFiles = "file";
    echo "Great! Uploaded " . $count . " " . $fileFiles . $link;
?>


