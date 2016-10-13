<?php
include_once ($_SERVER["DOCUMENT_ROOT"]."/msergeev_config.php");
MSergeev\Core\Lib\Loader::IncludePackage("calendar");
use MSergeev\Packages\Calendar\Lib\Dates;


$arParams = array();

//Проверка переданных полей
if (true) {
	if (isset($_REQUEST["eday"])) {
		$arParams["eday"] = intval($_REQUEST["eday"]);
	}
	else {
		$arParams["eday"] = 0;
	}

	if (isset($_REQUEST["emonth"])) {
		$arParams["emonth"] = intval($_REQUEST["emonth"]);
	}
	else {
		$arParams["emonth"] = 0;
	}

	if (isset($_REQUEST["eyear"])) {
		$arParams["eyear"] = intval($_REQUEST["eyear"]);
	}
	else {
		$arParams["eyear"] = 0;
	}

	if (isset($_REQUEST["ehour"])) {
		$arParams["ehour"] = intval($_REQUEST["ehour"]);
	}
	else {
		$arParams["ehour"] = -1;
	}

	if (isset($_REQUEST["emin"])) {
		$arParams["emin"] = intval($_REQUEST["emin"]);
	}
	else {
		$arParams["emin"] = -1;
	}

	if (isset($_REQUEST['eplusminus']))
	{
		$arParams['eplusminus'] = intval($_REQUEST['eplusminus']);
	}
	else
	{
		$arParams['eplusminus'] = 1;
	}

	if (isset($_REQUEST['eaddday']))
	{
		$arParams['eaddday'] = intval($_REQUEST['eaddday']);
	}
	else
	{
		$arParams['eaddday'] = 0;
	}

	if (isset($_REQUEST["emonday"]) && $_REQUEST["emonday"] == "true") {
		$arParams["emonday"] = true;
	}
	else {
		$arParams["emonday"] = false;
	}

	if (isset($_REQUEST["etuesday"]) && $_REQUEST["etuesday"] == "true") {
		$arParams["etuesday"] = true;
	}
	else {
		$arParams["etuesday"] = false;
	}

	if (isset($_REQUEST["ewednesday"]) && $_REQUEST["ewednesday"] == "true") {
		$arParams["ewednesday"] = true;
	}
	else {
		$arParams["ewednesday"] = false;
	}

	if (isset($_REQUEST["ethursday"]) && $_REQUEST["ethursday"] == "true") {
		$arParams["ethursday"] = true;
	}
	else {
		$arParams["ethursday"] = false;
	}

	if (isset($_REQUEST["efriday"]) && $_REQUEST["efriday"] == "true") {
		$arParams["efriday"] = true;
	}
	else {
		$arParams["efriday"] = false;
	}

	if (isset($_REQUEST["esaturday"]) && $_REQUEST["esaturday"] == "true") {
		$arParams["esaturday"] = true;
	}
	else {
		$arParams["esaturday"] = false;
	}

	if (isset($_REQUEST["esunday"]) && $_REQUEST["esunday"] == "true") {
		$arParams["esunday"] = true;
	}
	else {
		$arParams["esunday"] = false;
	}

	if (isset($_REQUEST["eworkday"]) && $_REQUEST["eworkday"] == "true") {
		$arParams["eworkday"] = true;
	}
	else {
		$arParams["eworkday"] = false;
	}

	if (isset($_REQUEST["eweekend"]) && $_REQUEST["eweekend"] == "true") {
		$arParams["eweekend"] = true;
	}
	else {
		$arParams["eweekend"] = false;
	}

	if (isset($_REQUEST["ntimezone"])) {
		$arParams["ntimezone"] = intval($_REQUEST["ntimezone"]);
	}
	else {
		$arParams["ntimezone"] = 0;
	}

	if (isset($_REQUEST["ntimezone"])) {
		$arParams["ntimezone"] = intval($_REQUEST["ntimezone"]);
	}
	else {
		$arParams["ntimezone"] = 0;
	}



	if (isset($_REQUEST["ntimezone"])) {
		$arParams["ntimezone"] = intval($_REQUEST["ntimezone"]);
	}
	else {
		$arParams["ntimezone"] = 0;
	}

	if (isset($_REQUEST["nday"])) {
		$arParams["nday"] = intval($_REQUEST["nday"]);
		$arReturn["date"]["day"] = $arParams["nday"];
	}
	else {
		$arParams["nday"] = 0;
		$arReturn["date"]["day"] = date("j");
	}

	if (isset($_REQUEST["ndayofweek"])) {
		$arParams["ndayofweek"] = intval($_REQUEST["ndayofweek"]);
		if ($arParams["ndayofweek"] == 0) {
			$arParams["ndayofweek"] = 7;
		}
	}
	else {
		$arParams["ndayofweek"] = 0;
	}

	if (isset($_REQUEST["nmonth"])) {
		$arParams["nmonth"] = intval($_REQUEST["nmonth"]);
		$arReturn["date"]["month"] = $arParams["nmonth"];
	}
	else {
		$arParams["nmonth"] = 0;
		$arReturn["date"]["month"] = date("n");
	}

	if (isset($_REQUEST["nyear"])) {
		$arParams["nyear"] = intval($_REQUEST["nyear"]);
		$arReturn["date"]["year"] = $arParams["nyear"];
	}
	else {
		$arParams["nyear"] = 0;
		$arReturn["date"]["year"] = date("Y");
	}

	if (isset($_REQUEST["nhour"])) {
		$arParams["nhour"] = intval($_REQUEST["nhour"]);
		$arReturn["date"]["hour"] = $arParams["nhour"];
	}
	else {
		$arParams["nhour"] = 0;
		$arReturn["date"]["hour"] = date("G");
	}

	if (isset($_REQUEST["nmin"])) {
		$arParams["nmin"] = intval($_REQUEST["nmin"]);
		$arReturn["date"]["minute"] = $arParams["nmin"];
	}
	else {
		$arParams["nmin"] = 0;
		$arReturn["date"]["minute"] = intval(date("i"));
	}

}

/*
 * Обработка полей
 * eday = день начала события
 * emonth = месяц начала события
 * eyear = год начала события
 * ehour = час начала события
 * emin = минута начала события
 * eplusminus = прибавить или отнять дни от даты
 * eaddday = количество дней которые необходимо прибавить или отнять
 * enoday = начало события не задано днем недели
 * emonday = начало события в понедельник
 * etuesday = начало события во вторник
 * ewednesday = начало события в среду
 * ethursday = начало события в четверг
 * efriday = начало события в пятницу
 * esaturday = начало события в субботу
 * esunday = начало события в воскресенье
 * eworkday = начало события в будний день
 * eweekend = начало события в выходной день
 * ntimezone = текущая зона времени
 * nday = текущий день
 * ndayofweek = текущий день недели
 * nmonth = текущий месяц
 * nyear = текущий год
 * nhour = текущий час
 * nmin = текущая минута
*/


$arReturn['date'] = Dates::getDateByForm($arParams);
$arReturn['nearestDate'] = Dates::getNearestDate($arReturn['date']);
Dates::addDateInfo($arReturn['nearestDate']);

$arReturn['date']['day'] = $arReturn['date']['d'];
$arReturn['date']['month'] = $arReturn['date']['m'];
$arReturn['date']['hour'] = $arReturn['date']['H'];
$arReturn['date']['minute'] = $arReturn['date']['i'];
$arReturn['date']['dayofweekname'] = Dates::getDayOfWeekShortName($arReturn['date']['dayofweek']);
$arReturn['nearestDate']['day'] = $arReturn['nearestDate']['d'];
$arReturn['nearestDate']['month'] = $arReturn['nearestDate']['m'];
$arReturn['nearestDate']['hour'] = $arReturn['nearestDate']['H'];
$arReturn['nearestDate']['minute'] = $arReturn['nearestDate']['i'];
$arReturn['nearestDate']['dayofweekname'] = Dates::getDayOfWeekShortName($arReturn['nearestDate']['dayofweek']);

header('Content-Type: application/json');
echo json_encode($arReturn);
