<?
ini_set('display_errors', 0);
ini_set ( "include_path","/home3/colfa/public_html/pear/PEAR" );
require_once 'Image/Barcode.php';
Image_Barcode::draw($_GET[NUM], $_GET[TYP], $_GET[IMG]);
?>
