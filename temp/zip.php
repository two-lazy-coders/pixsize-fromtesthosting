<?php
$file="Zips/1490451708.zip";
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="text.zip"');
fopen($file);
unlink($file);