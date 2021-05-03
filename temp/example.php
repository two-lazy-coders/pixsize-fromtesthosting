<?php

mkdir("example");
$fh = fopen("example/file.txt", "w+");
fwrite($fh, 'example text'.time());
fclose($fh);
$file = "example/file.txt";
//stuff
$zip = new ZipArchive();
$filename = "example/".time().".zip";
if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
exit("Невозможно открыть <$filename>\n");
}
$zip->addFile($file,$file);
$zip->close();
unlink($file);

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="text.zip"');
readfile($filename);
unlink($filename);