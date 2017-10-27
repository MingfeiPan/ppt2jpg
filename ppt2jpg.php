<?php

$path = $argv[1];
$name = $argv[2];
$pdfname = $path.'/'.md5(microtime()).'.pdf';
$order = "unoconv -f pdf -o ".$pdfname." /tmp/test.ppt";
exec($order);

$ret = pdf2jpg($pdfname, $path, $name);


function pdf2jpg($pdf, $path, $name){
    if(!extension_loaded('imagick')){
        return false;   
    }
    $IM = new imagick();
    $IM->setResolution(120,120);
    $IM->setCompressionQuality(80);
    $IM->readImage($pdf);
    $i = 0;
    foreach ($IM as $Key => $Var){
        $i++;
        $Var->setImageFormat('jpg');
        $Filename = $path.'/'.$name.$i.'.jpg';
        if($Var->writeImage($Filename) == true){
            $Return[] = $Filename;
        }
    }
    return $Return;
}

