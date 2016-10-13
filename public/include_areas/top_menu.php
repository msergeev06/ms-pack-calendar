<?
use MSergeev\Core\Lib;
$path = Lib\Tools::getSitePath(Lib\Loader::getPublic("calendar"));
?>
<table class="top_menu">
	<tr>
		<td><a href="<?=$path?>">Главная</a></td>
		<td><a href="<?=$path?>events/">События</a></td>
		<td><a href="<?=$path?>types/">Типы событий</a></td>
		<td><a href="<?=$path?>notice/">Напоминания</a></td>
		<td><a href="<?=$path?>actions/">Действия</a></td>
	</tr>
</table>