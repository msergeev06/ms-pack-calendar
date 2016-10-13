<?php

namespace MSergeev\Packages\Calendar\Lib;

use MSergeev\Core\Exception;
use MSergeev\Core\Lib as CoreLib;
use MSergeev\Packages\Calendar\Tables;

class Calendar
{
	public static function showCalendar ($month=null, $year=null)
	{
		if (is_null($month))
		{
			$month = date("m");
		}
		if (is_null($year))
		{
			$year = date("Y");
		}
		$month = intval($month);
		$year = intval($year);

		$arCalendar = self::getCalendar($month, $year);
		//msDebug($arCalendar);
		$echo = "<table class=\"calendar\"><thead><tr><th>";
		$echo .= "Понедельник";
		$echo .= "</th><th>";
		$echo .= "Вторник";
		$echo .= "</th><th>";
		$echo .= "Среда";
		$echo .= "</th><th>";
		$echo .= "Четверг";
		$echo .= "</th><th>";
		$echo .= "Пятница";
		$echo .= "</th><th class=\"red\">";
		$echo .= "Суббота";
		$echo .= "</th><th class=\"red\">";
		$echo .= "Воскресение";
		$echo .= "</th></tr></thead><tbody>";

		$day = 0;
		$echo .= "<tr>";
		if (isset($arCalendar["PREV_MONTH"]))
		{
			foreach ($arCalendar["PREV_MONTH"] as $date=>$arData)
			{
				if ($day == 7)
				{
					$echo .= "<tr>";
					$day = 0;
				}
				$day++;
				$echo .= "<td>";
				$echo .= "<span class=\"day";
				if (intval($arData["DAY_OF_WEEK"])==6 || intval($arData["DAY_OF_WEEK"])==7)
				{
					$echo .= " light-red";
				}
				else
				{
					$echo .= " grey";
				}
				$echo .= "\">";
				$echo .= $arData["TEXT"];
				$echo .= "</span>";
				$echo .= "</td>";
				if ($day == 7)
				{
					$echo .= "</tr>";
					$day = 0;
				}
			}
		}
		foreach ($arCalendar["NOW_MONTH"] as $date=>$arData)
		{
			if ($day == 7)
			{
				$echo .= "<tr>";
				$day = 0;
			}
			$day++;
			$echo .= "<td>";
			$echo .= "<span class=\"day";
			if (intval($arData["DAY_OF_WEEK"])==6 || intval($arData["DAY_OF_WEEK"])==7)
			{
				$echo .= " red";
			}
			$echo .= "\">";
			$echo .= $arData["TEXT"];
			$echo .= "</span>";
			if ($date == "1.9.2016")
			{
				//Показываем тестовые данные
				$echo .= self::addTestData();
			}
			$echo .= "</td>";
			if ($day == 7)
			{
				$echo .= "</tr>";
				$day = 0;
			}
		}
		if (isset($arCalendar["NEXT_MONTH"]))
		{
			foreach ($arCalendar["NEXT_MONTH"] as $date=>$arData)
			{
				if ($day == 7)
				{
					$echo .= "<tr>";
					$day = 0;
				}
				$day++;
				$echo .= "<td>";
				$echo .= "<span class=\"day";
				if (intval($arData["DAY_OF_WEEK"])==6 || intval($arData["DAY_OF_WEEK"])==7)
				{
					$echo .= " light-red";
				}
				else
				{
					$echo .= " grey";
				}
				$echo .= "\">";
				$echo .= $arData["TEXT"];
				$echo .= "</span>";
				$echo .= "</td>";
				if ($day == 7)
				{
					$echo .= "</tr>";
					$day = 0;
				}
			}
		}


		$echo .= "</tbody></table>";

		return $echo;
	}

	protected static function addTestData ()
	{
		$echo = "";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(0).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(0).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/celebration.png');\"></div>";
		$echo .= "<div class=\"name\"><b>День знаний</b></div>";
		$echo .= "<div class=\"popup\" id=\"event1\" style=\"display: none;\"></div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(0).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(0).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/birthday.png');\"></div>";
		$echo .= "<div class=\"name\"><b>(28 лет) День рождения</b></div>";
		$echo .= "<div class=\"popup\" id=\"event1\" style=\"display: none;\"></div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(3).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(3).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/school.png');\"></div>";
		$echo .= "<div class=\"name\"><b>8:30 Школа</b> (5 уроков)</div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(1).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(1).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/work.png');\"></div>";
		$echo .= "<div class=\"name\"><b>9:30 На работе</b></div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(3).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(3).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/books.png');\"></div>";
		$echo .= "<div class=\"name\"><b>13:00 Дополнительные занятия</b></div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(2).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(2).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/personal.png');\"></div>";
		$echo .= "<div class=\"name\"><b>14:30</b> Персональная задача</div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(3).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(3).";\"></div>";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(2).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/music.png');\"></div>";
		$echo .= "<div class=\"name\"><b>15:00 Музыка</b></div>";
		$echo .= "</div>";

		$echo .= "<div class=\"event\" style=\"border-color: ".Users::getUserColor(2).";\">";
		$echo .= "<div class=\"circle\" style=\"background: ".Users::getUserColor(2).";\"></div>";
		$echo .= "<div class=\"label\" style=\"background: url('".CoreLib\Loader::getSiteTemplate("calendar")."images/locked.png');\"></div>";
		$echo .= "<div class=\"name\">Скрытая задача</div>";
		$echo .= "</div>";

		return $echo;
	}

	protected static function getCalendar ($month, $year)
	{
		//В коде может использоваться другой пакет
		if (CoreLib\Loader::issetPackage('dates'))
		{
			//Если пакет установлен, подключаем его
			CoreLib\Loader::IncludePackage('dates');
		}
		//$month = 2; $year = 2017; //Для теста
		$arCalendar = array();
		$dateHelper = new CoreLib\DateHelper();
		$arCalendar["INFO"]["MONTH"] = $month;
		$arCalendar["INFO"]["YEAR"] = $year;
		//Получаем timestamp на первое число заданного месяца и года
		$arCalendar["INFO"]["START_DATE"] = "1.".$month.".".$year;
		$arCalendar["INFO"]["START_TIMESTAMP"] = $dateHelper->getDateTimestamp($arCalendar["INFO"]["START_DATE"]);
		//Получаем количество дней в месяце
		$arCalendar["INFO"]["NUMBER_OF_DAYS"] = intval(date("t",$arCalendar["INFO"]["START_TIMESTAMP"]));
		//Получаем timestamp на последнее число заданного месяца и года
		$arCalendar["INFO"]["LAST_DATE"] = $arCalendar["INFO"]["NUMBER_OF_DAYS"].".".$month.".".$year;
		$arCalendar["INFO"]["LAST_TIMESTAMP"] = $dateHelper->getDateTimestamp($arCalendar["INFO"]["LAST_DATE"]);
		//Получаем день недели для 1го числа месяца
		$arCalendar["INFO"]["START_DAY_OF_WEEK"] = intval(date("w",$arCalendar["INFO"]["START_TIMESTAMP"]));
		if ($arCalendar["INFO"]["START_DAY_OF_WEEK"] == 0)
		{
			$arCalendar["INFO"]["START_DAY_OF_WEEK"] = 7;
		}
		//Получаем день недели для последнего числа месяца
		$arCalendar["INFO"]["LAST_DAY_OF_WEEK"] = intval(date("w",$arCalendar["INFO"]["LAST_TIMESTAMP"]));
		if ($arCalendar["INFO"]["LAST_DAY_OF_WEEK"] == 0)
		{
			$arCalendar["INFO"]["LAST_DAY_OF_WEEK"] = 7;
		}
		//Если 1е число не понедельник - нужно получить несколько дней предыдущего месяца
		if ($arCalendar["INFO"]["START_DAY_OF_WEEK"] != 1)
		{
			$arCalendar["INFO"]["DAY_PREV_MONTH"] = $arCalendar["INFO"]["START_DAY_OF_WEEK"] - 1;
			$arCalendar["INFO"]["FIRST_DAY_PREV_MONTH"] = $dateHelper->strToTime(
				$arCalendar["INFO"]["START_DATE"],
				"-".$arCalendar["INFO"]["DAY_PREV_MONTH"]." day"
			);
			list(
				$arCalendar["INFO"]["PREV_MONTH_DAY"],
				$arCalendar["INFO"]["PREV_MONTH_MONTH"],
				$arCalendar["INFO"]["PREV_MONTH_YEAR"]
				) = explode(".",$arCalendar["INFO"]["FIRST_DAY_PREV_MONTH"]);
			for ($i=0; $i<$arCalendar["INFO"]["DAY_PREV_MONTH"]; $i++)
			{
				if ($i==0)
				{
					$dayOfWeek = date("w",$dateHelper->getDateTimestamp(
						intval($arCalendar["INFO"]["PREV_MONTH_DAY"])."."
						.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
						.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])
					));
					if ($dayOfWeek == 0) $dayOfWeek = 7;
					//Использование пакета "Даты"
					if (CoreLib\Loader::issetPackage('dates'))
					{
						$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(
							intval($arCalendar["INFO"]["PREV_MONTH_DAY"])."."
							.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
							.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])
						);
						if ($isDayOff)
							$dayOfWeek = 6;
						else
							$dayOfWeek = 1;
					}
					$arCalendar["PREV_MONTH"][intval($arCalendar["INFO"]["PREV_MONTH_DAY"])."."
					.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
					.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])] = array(
						"TEXT" => intval($arCalendar["INFO"]["PREV_MONTH_DAY"])
							." ".self::getMonthName(intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])),
						"DAY_OF_WEEK" => $dayOfWeek
					);
				}
				else
				{
					$dayOfWeek = date("w",$dateHelper->getDateTimestamp(
						(intval($arCalendar["INFO"]["PREV_MONTH_DAY"])+$i)."."
						.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
						.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])
					));
					if ($dayOfWeek == 0) $dayOfWeek = 7;
					//Использование пакета "Даты"
					if (CoreLib\Loader::issetPackage('dates'))
					{
						$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(
							(intval($arCalendar["INFO"]["PREV_MONTH_DAY"])+$i)."."
							.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
							.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])
						);
						if ($isDayOff)
							$dayOfWeek = 6;
						else
							$dayOfWeek = 1;
					}
					$arCalendar["PREV_MONTH"][(intval($arCalendar["INFO"]["PREV_MONTH_DAY"])+$i)."."
					.intval($arCalendar["INFO"]["PREV_MONTH_MONTH"])."."
					.intval($arCalendar["INFO"]["PREV_MONTH_YEAR"])] = array(
						"TEXT" => (intval($arCalendar["INFO"]["PREV_MONTH_DAY"])+$i),
						"DAY_OF_WEEK" => $dayOfWeek
					);
				}
			}
		}
		//Вносим информацию по заданному месяцу
		for ($i=0; $i<$arCalendar["INFO"]["NUMBER_OF_DAYS"]; $i++)
		{
			if ($i==0)
			{
				$dayOfWeek = date("w",$dateHelper->getDateTimestamp(($i+1).".".$month.".".$year));
				if ($dayOfWeek == 0) $dayOfWeek = 7;
				//Использование пакета "Даты"
				if (CoreLib\Loader::issetPackage('dates'))
				{
					$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(($i+1).".".$month.".".$year);
					if ($isDayOff)
						$dayOfWeek = 6;
					else
						$dayOfWeek = 1;
				}
				$arCalendar["NOW_MONTH"][($i+1).".".$month.".".$year] = array(
					"TEXT" => ($i+1)." ".self::getMonthName($month),
					"DAY_OF_WEEK" => $dayOfWeek
				);
			}
			else
			{
				$dayOfWeek = date("w",$dateHelper->getDateTimestamp(($i+1).".".$month.".".$year));
				if ($dayOfWeek == 0) $dayOfWeek = 7;
				//Использование пакета "Даты"
				if (CoreLib\Loader::issetPackage('dates'))
				{
					$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(($i+1).".".$month.".".$year);
					if ($isDayOff)
						$dayOfWeek = 6;
					else
						$dayOfWeek = 1;
				}
				$arCalendar["NOW_MONTH"][($i+1).".".$month.".".$year] = array(
					"TEXT" => ($i+1),
					"DAY_OF_WEEK" => $dayOfWeek
				);
			}
		}
		//Если последний день заданного месяца не воскресение - нужно добавить несколько дней следующего месяца
		if ($arCalendar["INFO"]["LAST_DAY_OF_WEEK"] != 7)
		{
			$arCalendar["INFO"]["FIRST_DAY_NEXT_MONTH"] = $dateHelper->strToTime(
				$arCalendar["INFO"]["LAST_DATE"],
				"+1 day"
			);
			list(
				$arCalendar["INFO"]["NEXT_MONTH_DAY"],
				$arCalendar["INFO"]["NEXT_MONTH_MONTH"],
				$arCalendar["INFO"]["NEXT_MONTH_YEAR"]
				) = explode(".",$arCalendar["INFO"]["FIRST_DAY_NEXT_MONTH"]);
			$arCalendar["INFO"]["DAY_NEXT_MONTH"] = 7 - $arCalendar["INFO"]["LAST_DAY_OF_WEEK"];
			for ($i=0; $i<$arCalendar["INFO"]["DAY_NEXT_MONTH"]; $i++)
			{
				if ($i==0)
				{
					$dayOfWeek = date("w",$dateHelper->getDateTimestamp(
						($i+1)."."
						.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
						.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])
					));
					if ($dayOfWeek == 0) $dayOfWeek = 7;
					//Использование пакета "Даты"
					if (CoreLib\Loader::issetPackage('dates'))
					{
						$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(
							($i+1)."."
							.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
							.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])
						);
						if ($isDayOff)
							$dayOfWeek = 6;
						else
							$dayOfWeek = 1;
					}
					$arCalendar["NEXT_MONTH"][($i+1)."."
					.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
					.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])] = array(
						"TEXT" => ($i+1)." ".self::getMonthName(intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])),
						"DAY_OF_WEEK" => $dayOfWeek
					);
				}
				else
				{
					$dayOfWeek = date("w",$dateHelper->getDateTimestamp(
						($i+1)."."
						.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
						.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])
					));
					if ($dayOfWeek == 0) $dayOfWeek = 7;
					//Использование пакета "Даты"
					if (CoreLib\Loader::issetPackage('dates'))
					{
						$isDayOff = \MSergeev\Packages\Dates\Lib\WorkCalendar::isDayOff(
							($i+1)."."
							.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
							.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])
						);
						if ($isDayOff)
							$dayOfWeek = 6;
						else
							$dayOfWeek = 1;
					}
					$arCalendar["NEXT_MONTH"][($i+1)."."
					.intval($arCalendar["INFO"]["NEXT_MONTH_MONTH"])."."
					.intval($arCalendar["INFO"]["NEXT_MONTH_YEAR"])] = array(
						"TEXT" => ($i+1),
						"DAY_OF_WEEK" => $dayOfWeek
					);
				}
			}
		}

		return $arCalendar;
	}

	protected static function getMonthName ($month)
	{
		switch (intval($month))
		{
			case 1:
				return 'января';
			case 2:
				return 'февраля';
			case 3:
				return 'марта';
			case 4:
				return 'апреля';
			case 5:
				return 'мая';
			case 6:
				return 'июня';
			case 7:
				return 'июля';
			case 8:
				return 'августа';
			case 9:
				return 'сентября';
			case 10:
				return 'октября';
			case 11:
				return 'ноября';
			case 12:
				return 'декабря';
			default:
				return '';
		}
	}
}