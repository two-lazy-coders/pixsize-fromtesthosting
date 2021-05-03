<?php
include 'inc/header.php';

if( !isset($_POST["process"]) && isset($_POST["submit"])  ){
	
	//var_dump($_POST);
	//var_dump($_FILES);
	$num = count($_FILES['images']['name']);
	
	
	
    //+сохранить файлы,
    //переименовать,
    for($i = 0; $i<$num; $i++){
		$file = $_FILES["images"]["tmp_name"][$i];
		$file_name = $_FILES["images"]["name"][$i];
		//echo $file_name."\n";
		copy($file, "Upload/$file_name");
	}
    
    
    //сгенерировать страницу,
    //вложить сценарий со страницей
    include 'inc/liner.php';
}
elseif( isset($_POST["process"]) ){
	echo "Processing\n";
    //декодировать json
    	$values = json_decode($_POST["process"], true);
    //пройтись циклом по файлам
    	$files = scandir("Upload");
		$count = 0;
	//в соответствии с параметрами
    //разрезать и сохранить нужные файлы
  	foreach($files as $file){
	    if(substr($file, 0, 1) != "." ){
			$filename = "./Upload/".$file;
			$size = getimagesize($filename);
			$width = $size[0];
			$height = $size[1];
			$row = $values[$count]["row"];
			$col = $values[$count]["col"];
			$img_width = round(($width/100)*($values[$count]["width"]/$col));
			$img_height = round(($height/100)*($values[$count]["height"]/$row));
			$img_left = round(($width/100)*($values[$count]["left"]));
			$img_top = round(($height/100)*($values[$count]["top"]));
			// Создание изображений
			$src = imagecreatefromjpeg($filename);
			$l = $img_left;
			$t = $img_top;
			if(mkdir("./Upload/".$count) == false){echo "mkdir false";};
			for($i=0;$i<$values[$count]["row"]; $i++){
				for($j=0; $j<$values[$count]["col"];$j++){
					$dest = imagecreatetruecolor($img_width, $img_height);
					// Копирование
					imagecopy($dest, $src, 0, 0, $l, $t, $img_width, $img_height);
					// Сохраняем изображение в 'simpletext.jpg'
					imagejpeg($dest, ("./Upload/$count/".$i."-".$j.".jpg") );
					imagedestroy($dest);
					$l+=$img_width;
				}
				$t+=$img_height;
				$l = $img_left;
			}						
			//mkdir($d);
		    $count++;
		    imagedestroy($src);
		    if(unlink($filename) == false){echo "unlink false";}
	    }
		
  	}

	$folders = scandir("./Upload");
	$zip = new ZipArchive();
	$filename = "./Zips/".time().".zip";

	if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
	    exit("Невозможно открыть <$filename>\n");
	}
	foreach($folders as $folder){
		if(is_dir("./Upload/".$folder) && substr($folder, 0, 1) != "."){
			$images = scandir("./Upload/".$folder);
			$zip->addEmptyDir($folder);
			foreach($images as $image){
				if(substr($image, 0, 1) != "."){
					$zip->addFile("./Upload/$folder/$image","$folder/$image");
				}
			}
		}
		//rmdir("Upload/".$folder);
	}
	//echo "numfiles: " . $zip->numFiles . "\n";
	//echo "status:" . $zip->status . "\n";
	$zip->close();
	
	
	foreach($folders as $folder){
		if(is_dir("Upload/".$folder) && substr($folder, 0, 1) != "."){
			$images = scandir("./Upload/".$folder);
			foreach($images as $image){
				if(substr($image, 0, 1) != "."){
					if(unlink("./Upload/$folder/$image") == false) {echo "unlink false";}
				}
			}
			if(rmdir("./Upload/".$folder) == false) {echo "rmdir false";}
		}
		
	}	
    //заархивировать файлы и отдать пользователю
    //удалить все к херам
    
    // Будем передавать PDF

// Который будет называться downloaded.pdf

// Исходный PDF файл original.pdf
//unlink($filename);




 echo '<div class="w3-card-4 w3-grey w3-padding w3-round-large" style="margin:10% 10%">
 	<a href="'.$filename.'"><h3>Архив</h3></a>
 </div>';
$zips = scandir("./Zips"); 
 foreach($zips as $zip){
		if(substr($folder, 0, 1) != "." && ){
			$images = scandir("./Upload/".$folder);
			foreach($images as $image){
				if(substr($image, 0, 1) != "."){
					if(unlink("./Upload/$folder/$image") == false) {echo "unlink false";}
				}
			}
			if(rmdir("./Upload/".$folder) == false) {echo "rmdir false";}
		}
		
}	
 /*header ("Content-Type: application/octet-stream");
 header ("Accept-Ranges: bytes");
 header ("Content-Length: ".filesize($filename));  
 header ("Content-Disposition: attachment; filename=".time() );  
 readfile($filename);*/
}
else
{
    #Отобразить форму загрузки файла
    include 'inc/loadpage.php';
}

include 'inc/footer.php';