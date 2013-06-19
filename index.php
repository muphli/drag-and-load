<?php
	session_start();
	if ($_SESSION["loggedIn"] != "true"){
		header("Location: ../index.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Drag & Load</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8">
		<script src="http://code.jquery.com/jquery-1.10.1.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#uploader').on('dragover',function(e){
					e.preventDefault();
				    e.stopPropagation();
				    $('#uploader').css('background-color', 'rgba(0,0,0,0.1)');
			    });
				$('#uploader').on('dragenter',function(e){
					e.preventDefault();
					e.stopPropagation();
				});
				$('#uploader').on('dragleave',function(e){
					e.preventDefault();
					e.stopPropagation();
					$('#uploader').css('background-color', 'rgba(0,0,0,0.05)');

				});
				$('#uploader').on('drop',function(e){
					$('#uploader').css('background-color', 'rgba(0,0,0,0.05)');
					if(e.originalEvent.dataTransfer){
						if(e.originalEvent.dataTransfer.files.length){
							e.preventDefault();
							e.stopPropagation();
							upload(e.originalEvent.dataTransfer.files);
						}   
					}
				});
				function upload(files){
					var http = new XMLHttpRequest();
					if(typeof(FormData) != 'undefined'){
						var form = new FormData();
						form.append('path', '/');
	     
						for (var i = 0; i < files.length; i++) {
							form.append('file[]', files[i]);
						}
						
						http.onreadystatechange = function(){
							if (http.readyState == 4 && http.status == 200){
								var i = 22;
								if (files.length > 1){
									i = 23;
								}
								var textToPage = http.responseText.substring(0, i);
								$('#resultText').text(textToPage);
								var linkToClipboard = http.responseText.substring(i, http.responseText.length - 1);
								prompt("Link to file: ", linkToClipboard);
							}
						}
						
						http.open('POST', 'upload.php', true);
						http.send(form);
	      
				    }
				    else{
				        alert('Browser unterstützt Drag and Drop Dateiupload nicht');
				    }
				}
			});
		</script>

	</head>
	<body>
		<div id="uploader">
			<div id="texts">
				<span id="actionText">Drop files here</span>
				<span id="resultText">No uploads yet</span>
			</div>
		</div>
	</body>
</html>
