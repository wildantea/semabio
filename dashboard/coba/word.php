<?php
include "vendor/autoload.php";
// Read contents
$source = "baru.docx";

use Gears\String as Str;
use SGH\PdfBox\PdfBox;


$document = new Gears\Pdf('hasil.docx');
$document->converter = function()
{
	return new Gears\Pdf\Docx\Converter\Unoconv();
};
$document->save('data.pdf');


/* $this->converter = function()
{
    return new Gears\Pdf\Docx\Converter\Unoconv();
};


Gears\Pdf::convert('coba.docx', 'data.pdf', ['converter' => $this->converter]);

 */