<? include_once(__DIR__."/include/header.php"); MSergeev\Core\Lib\Buffer::setTitle("Главная"); ?>
<?
use \MSergeev\Packages\Calendar\Lib;
$path = MSergeev\Core\Lib\Loader::getSitePublic("calendar");
?>
<a href="<?=$path?>events/add.php">Добавить событие</a><br><br>
<?=Lib\Calendar::showCalendar();?>


<? include_once(MSergeev\Core\Lib\Loader::getPublic("calendar")."include/footer.php"); ?>
