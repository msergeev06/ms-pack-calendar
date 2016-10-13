<?
use MSergeev\Core\Lib;

header('Content-type: text/html; charset=utf-8');
Lib\Buffer::start("page");

?>
<!DOCTYPE html>
<html>
<head>
	<title>Семейный календарь - <?=Lib\Buffer::showTitle("Главная");?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<?=Lib\Buffer::showCSS()?>
	<?=Lib\Buffer::showJS()?>
</head>
<body>

<? include_once (Lib\Loader::getPublic("calendar")."include_areas/top_menu.php"); ?>

<h1><?=Lib\Buffer::showTitle("Главная");?></h1>


