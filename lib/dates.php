<?php

namespace MSergeev\Packages\Calendar\Lib;
use MSergeev\Core\Lib\Loader;

class Dates {
	/**
	 * getDayOfWeekShortName
	 * Возвращает краткое наименование дня недели (Пн., Вт., Ср. и т.д.)
	 *
	 * @param int $dayofweek
	 *
	 * @return string
	 */
	public static function getDayOfWeekShortName ($dayofweek=0)
	{
		switch (intval($dayofweek)) {
			case 1:
				$dayOfWeekName = 'Пн.';
				break;
			case 2:
				$dayOfWeekName = 'Вт.';
				break;
			case 3:
				$dayOfWeekName = 'Ср.';
				break;
			case 4:
				$dayOfWeekName = 'Чт.';
				break;
			case 5:
				$dayOfWeekName = 'Пт.';
				break;
			case 6:
				$dayOfWeekName = 'Сб.';
				break;
			case 7:
				$dayOfWeekName = 'Вс.';
				break;
			default:
				$dayOfWeekName = '???';
				break;
		}
		return $dayOfWeekName;
	}

	/**
	 * getNearestDate
	 * Возвращает ближайшую будущую дату к указанной
	 *
	 * @param array $arDate
	 *
	 * @return array
	 */
	public static function getNearestDate ($arDate)
	{
		if (
			!isset($arDate['day'])
			|| !isset($arDate['month'])
			|| !isset($arDate['year'])
		)
		{
			return false;
		}

		if (!isset($arDate['hour'])) $arDate['hour'] = 0;
		if (!isset($arDate['minute'])) $arDate['minute'] = 0;

		//day, month, year, hour, minute
		$arNow = array(
			'day' => intval(date('d')),
			'month' => intval(date('m')),
			'year' => intval(date('Y')),
			'hour' => intval(date('H')),
			'minute' => intval(date('i'))
		);
		$arSet = array();
		$arNow['mktime'] = mktime($arNow['hour'],$arNow['minute'],0,$arNow['month'],$arNow['day'],$arNow['year']);
		if ($arDate['year']<$arNow['year'])
		{
			$arSet['year'] = $arNow['year'];
		}
		else
		{
			$arSet['year'] = $arDate['year'];
		}
		$arSet['month'] = $arDate['month'];
		$arSet['day'] = $arDate['day'];
		$arSet['hour'] = $arDate['hour'];
		$arSet['minute'] = $arDate['minute'];
		$arSet['mktime'] = mktime($arSet['hour'],$arSet['minute'],0,$arSet['month'],$arSet['day'],$arSet['year']);
		while ($arSet['mktime']<$arNow['mktime'])
		{
			$arSet['year'] += 1;
			$arSet['mktime'] = mktime($arSet['hour'],$arSet['minute'],0,$arSet['month'],$arSet['day'],$arSet['year']);
		}

		return array(
			'day' => $arSet['day'],
			'month' => $arSet['month'],
			'year' => $arSet['year'],
			'hour' => $arSet['hour'],
			'minute' => $arSet['minute']
		);

	}

	/**
	 * getDateByForm
	 * Получает дату из заполненной формы даты
	 *
	 * @param null|array $arParams
	 *
	 * @return array
	 */
	public static function getDateByForm ($arParams = null)
	{
		//Может использовать данных другого пакета
		if (Loader::issetPackage("dates"))
		{
			Loader::IncludePackage("dates");
		}

		/*
		$arParams["eyear"]
		$arParams['emonth']
		$arParams['eday']
		$arParams['eaddday']
		$arParams['emin']
		$arParams['ehour']
		$arParams['eplusminus']
		$arParams["enoday"]
		$arParams["emonday"]
		$arParams["etuesday"]
		$arParams["ewednesday"]
		$arParams["ethursday"]
		$arParams["efriday"]
		$arParams["esaturday"]
		$arParams["esunday"]
		$arParams["eworkday"]
		$arParams["eweekend"]

		*/

		if (!is_array($arParams)) return false;

		$arReturn = array();

		if ($arParams["eyear"] > 0) //Если год указан - берем указанный
		{
			$arReturn['year'] = $arParams['eyear'];
			$arReturn['Y'] = $arParams['eyear'];
		}
		else //Если не указан - берем текущий
		{
			$arReturn['year'] = date('Y');
			$arReturn['Y'] = date('Y');
		}

		if ($arParams['emonth'] > 0) //Если месяц указан - берем указанный
		{
			$arReturn['month'] = $arParams['emonth'];
			$arReturn['n'] = $arParams['emonth'];
		}
		else //Если не указан - берем текущий
		{
			$arReturn['month'] = date("n");
			$arReturn['n'] = date("n");
		}

		if ($arParams['eday'] > 0) //Если день указан - берем указанный
		{
			$arReturn['day'] = $arParams['eday'];
			$arReturn['j'] = $arParams['eday'];
		}
		else //Если не указан
		{
			if ($arParams['eaddday'] > 0) //Если задано количество дней
			{
				$arReturn['day'] = 1;
				$arReturn['j'] = 1;
			}
			else
			{
				$arReturn['day'] = date('j');
				$arReturn['j'] = date('j');
			}
		}

		if ($arParams['emin'] > -1) //Если минуты установлены - берем указанные
		{
			$arReturn['minute'] = $arParams['emin'];
			$arReturn['i'] = $arParams['emin'];
			if ($arParams['ehour'] > -1) //Если часы указаны - берем указанные
			{
				$arReturn['hour'] = $arParams['ehour'];
				$arReturn['G'] = $arParams['ehour'];
			}
			else //Если нет - принимаем час за 0
			{
				$arReturn['hour'] = 0;
				$arReturn['G'] = 0;
			}
		}
		else //Если минуты не установлены
		{
			if ($arParams['ehour'] > -1) //Если час установлен - принимаем час
			{
				$arReturn['hour'] = $arParams['ehour'];
				$arReturn['G'] = $arParams['ehour'];
				$arReturn['minute'] = 0;
				$arReturn['i'] = 0;
			}
			else //Если час не установлен - берем текущее время
			{
				$arReturn['hour'] = date('G');
				$arReturn['G'] = date('G');
				$arReturn['minute'] = date('i');
				$arReturn['i'] = date('i');
			}
		}

		$arReturn["log"] = $arReturn;

		if ($arParams['eaddday'] > 0) //Если задано количество дней
		{
			if ($arParams['eplusminus'] > 0) {
				self::setDayDifference($arReturn,intval($arParams['eaddday']));
			}
			else {
				self::setDayDifference($arReturn,intval($arParams['eaddday']),'-');
			}
		}


		self::addDateInfo($arReturn);

		if (!$arParams["enoday"]) {
			if ($arParams["emonday"]) $dayofweek = 1;
			elseif ($arParams["etuesday"]) $dayofweek = 2;
			elseif ($arParams["ewednesday"]) $dayofweek = 3;
			elseif ($arParams["ethursday"]) $dayofweek = 4;
			elseif ($arParams["efriday"]) $dayofweek = 5;
			elseif ($arParams["esaturday"]) $dayofweek = 6;
			elseif ($arParams["esunday"]) $dayofweek = 7;
			else $dayofweek = 0;

			if ($dayofweek > 0) {
				$dayDifference = $dayofweek-$arReturn['dayofweek'];
				if ($dayDifference > 0) {
					self::setDayDifference ($arReturn, $dayDifference);
				}
				elseif ($dayDifference < 0) {
					self::setDayDifference ($arReturn, (7+$dayDifference));
				}
			}
			else {
				if ($arParams["eworkday"]) $dayofweek = 8;
				elseif ($arParams["eweekend"]) $dayofweek = 9;
				else $dayofweek = 0;

				if (Loader::issetPackage("dates")) {
					$bLoadDates = true;
				}
				else
				{
					$bLoadDates = false;
				}
				if ($dayofweek == 8) {
					if (!$bLoadDates) {
						if ($arReturn['dayofweek'] >= 1 && $arReturn['dayofweek'] <= 5) {
							$dayDifference = 0;
						} elseif ($arReturn['dayofweek'] == 6) {
							$dayDifference = 2;
						} elseif ($arReturn['dayofweek'] == 7) {
							$dayDifference = 1;
						}
						if ($dayDifference > 0) {
							self::setDayDifference($arReturn, $dayDifference);
						}
					}
					else
					{
						$arDates = \MSergeev\Packages\Dates\Lib\WorkCalendar::getNearestDates($arReturn);
						$arReturn['dates'] = $arDates;
						for ($i=0; $i<count($arDates); $i++)
						{
							$date = $arReturn['day'].'.'.$arReturn['month'].'.'.$arReturn['year'];
							if ($arDates[$date] == "X")
							{
								$mktime = mktime(0,0,0,$arReturn['month'],$arReturn['day'],$arReturn['year']);
								$dayofw = date('w',$mktime);
								if ($dayofw==0) $dayofw = 7;
								if ($dayofw >= 1 && $dayofw <= 5) $bWorkDay = true;
								else $bWorkDay = false;

								if ($bWorkDay) break;
							}
							elseif ($arDates[$date] == "N")
							{
								break;
							}
							self::setDayDifference($arReturn,1);
						}
					}
				}
				elseif ($dayofweek == 9) {
					if (!$bLoadDates) {
						if ($arReturn['dayofweek'] >= 1 && $arReturn['dayofweek'] <= 5) {
							$dayDifference = 6 - $arReturn['dayofweek'];
						} else {
							$dayDifference = 0;
						}
						if ($dayDifference > 0) {
							self::setDayDifference($arReturn, $dayDifference);
						}
					}
					else
					{
						$arDates = \MSergeev\Packages\Dates\Lib\WorkCalendar::getNearestDates($arReturn);
						for ($i=0; $i<count($arDates); $i++)
						{
							$date = $arReturn['day'].'.'.$arReturn['month'].'.'.$arReturn['year'];
							if ($arDates[$date] == "X")
							{
								$mktime = mktime(0,0,0,$arReturn['month'],$arReturn['day'],$arReturn['year']);
								$dayofw = date('w',$mktime);
								if ($dayofw==0) $dayofw = 7;
								if ($dayofw >= 1 && $dayofw <= 5) $bWorkDay = true;
								else $bWorkDay = false;

								if (!$bWorkDay) break;
							}
							elseif ($arDates[$date] == "Y")
							{
								break;
							}
							self::setDayDifference($arReturn,1);
						}
					}
				}

			}
		}


		return $arReturn;
	}

	/**
	 * addDateInfo
	 * Дополняет существующую дату всеми значениями функции date()
	 *
	 * @param array $arDate
	 * @param bool  $rewrite
	 */
	public static function addDateInfo (&$arDate, $rewrite=false) {

		if (
			!isset($arDate['hour'])
			|| !isset($arDate['minute'])
			|| !isset($arDate['month'])
			|| !isset($arDate['day'])
			|| !isset($arDate['year'])
		)
		{
			return false;
		}

		if (!isset($arDate['timestamp']) || $rewrite)
		{
			$arDate['timestamp'] = mktime(
				$arDate["hour"],
				$arDate["minute"],
				0,
				$arDate["month"],
				$arDate["day"],
				$arDate["year"]
			);
		}
		if (!isset($arDate['U']) || $rewrite) $arDate['U'] = $arDate['timestamp'];
		if (!isset($arDate['dayofweek']) || $rewrite) $arDate['dayofweek'] = (intval(date('w',$arDate['timestamp']))==0)?7:intval(date('w',$arDate['timestamp']));
		if (!isset($arDate['w']) || $rewrite) $arDate['w'] = date('w',$arDate['U']);

		if (!isset($arDate['a']) || $rewrite) $arDate['a'] = date('a',$arDate['U']);
		if (!isset($arDate['A']) || $rewrite) $arDate['A'] = date('A',$arDate['U']);
		if (!isset($arDate['B']) || $rewrite) $arDate['B'] = date('B',$arDate['U']);
		if (!isset($arDate['c']) || $rewrite) $arDate['c'] = date('c',$arDate['U']);
		if (!isset($arDate['d']) || $rewrite) $arDate['d'] = date('d',$arDate['U']);
		if (!isset($arDate['D']) || $rewrite) $arDate['D'] = date('D',$arDate['U']);
		if (!isset($arDate['F']) || $rewrite) $arDate['F'] = date('F',$arDate['U']);
		if (!isset($arDate['g']) || $rewrite) $arDate['g'] = date('g',$arDate['U']);
		if (!isset($arDate['G']) || $rewrite) $arDate['G'] = date('G',$arDate['U']);
		if (!isset($arDate['h']) || $rewrite) $arDate['h'] = date('h',$arDate['U']);
		if (!isset($arDate['H']) || $rewrite) $arDate['H'] = date('H',$arDate['U']);
		if (!isset($arDate['i']) || $rewrite) $arDate['i'] = date('i',$arDate['U']);
		if (!isset($arDate['I']) || $rewrite) $arDate['I'] = date('I',$arDate['U']);
		if (!isset($arDate['j']) || $rewrite) $arDate['j'] = date('j',$arDate['U']);
		if (!isset($arDate['l']) || $rewrite) $arDate['l'] = date('l',$arDate['U']);
		if (!isset($arDate['L']) || $rewrite) $arDate['L'] = date('L',$arDate['U']);
		if (!isset($arDate['m']) || $rewrite) $arDate['m'] = date('m',$arDate['U']);
		if (!isset($arDate['M']) || $rewrite) $arDate['M'] = date('M',$arDate['U']);
		if (!isset($arDate['n']) || $rewrite) $arDate['n'] = date('n',$arDate['U']);
		if (!isset($arDate['O']) || $rewrite) $arDate['O'] = date('O',$arDate['U']);
		if (!isset($arDate['r']) || $rewrite) $arDate['r'] = date('r',$arDate['U']);
		if (!isset($arDate['s']) || $rewrite) $arDate['s'] = date('s',$arDate['U']);
		if (!isset($arDate['S']) || $rewrite) $arDate['S'] = date('S',$arDate['U']);
		if (!isset($arDate['t']) || $rewrite) $arDate['t'] = date('t',$arDate['U']);
		//if (!isset($arDate['U']) || $rewrite) $arDate['U'] = date('U',$arDate['U']);
		if (!isset($arDate['w']) || $rewrite) $arDate['w'] = date('w',$arDate['U']);
		if (!isset($arDate['W']) || $rewrite) $arDate['W'] = date('W',$arDate['U']);
		if (!isset($arDate['Y']) || $rewrite) $arDate['Y'] = date('Y',$arDate['U']);
		if (!isset($arDate['y']) || $rewrite) $arDate['y'] = date('y',$arDate['U']);
		if (!isset($arDate['z']) || $rewrite) $arDate['z'] = date('z',$arDate['U']);
		if (!isset($arDate['Z']) || $rewrite) $arDate['Z'] = date('Z',$arDate['U']);

	}

	/**
	 * setDayDifference
	 * Смещает заданную дату на указанное количество дней вперед или назад
	 *
	 * @param array  $arDate
	 * @param int    $diff
	 * @param string $plus_minus
	 */
	public static function setDayDifference (&$arDate, $diff=0, $plus_minus = "+")
	{
		if ($plus_minus!="+" && $plus_minus!="-") $plus_minus="+";

		if ($diff > 0) {
			$mktime = mktime(
				$arDate["hour"],
				$arDate["minute"],
				0,
				$arDate["month"],
				$arDate["day"],
				$arDate["year"]
			);
			$setTime = strtotime($plus_minus.$diff." day",$mktime);
			$arDate['day'] = intval(date("j",$setTime));
			$arDate['month'] = intval(date('n',$setTime));
			$arDate['year'] = intval(date('Y',$setTime));
			$arDate['hour'] = intval(date('G',$setTime));
			$arDate['minute'] = intval(date('i',$setTime));
			self::addDateInfo($arDate, true);
		}
	}

	/**
	 * getFormattedDate
	 * Форматирует переданную дату по указанному формату, аналог функции date()
	 *
	 * @param array  $arDate
	 * @param string $format
	 *
	 * @return string
	 */
	public static function getFormattedDate ($arDate, $format="")
	{
		if (isset($arDate['a'])) $format = str_replace('a',$arDate['a'],$format);
		if (isset($arDate['A'])) $format = str_replace('A',$arDate['A'],$format);
		if (isset($arDate['B'])) $format = str_replace('B',$arDate['B'],$format);
		if (isset($arDate['c'])) $format = str_replace('c',$arDate['c'],$format);
		if (isset($arDate['d'])) $format = str_replace('d',$arDate['d'],$format);
		if (isset($arDate['D'])) $format = str_replace('D',$arDate['D'],$format);
		if (isset($arDate['F'])) $format = str_replace('F',$arDate['F'],$format);
		if (isset($arDate['g'])) $format = str_replace('g',$arDate['g'],$format);
		if (isset($arDate['G'])) $format = str_replace('G',$arDate['G'],$format);
		if (isset($arDate['h'])) $format = str_replace('h',$arDate['h'],$format);
		if (isset($arDate['H'])) $format = str_replace('H',$arDate['H'],$format);
		if (isset($arDate['i'])) $format = str_replace('i',$arDate['i'],$format);
		if (isset($arDate['I'])) $format = str_replace('I',$arDate['I'],$format);
		if (isset($arDate['j'])) $format = str_replace('j',$arDate['j'],$format);
		if (isset($arDate['l'])) $format = str_replace('l',$arDate['l'],$format);
		if (isset($arDate['L'])) $format = str_replace('L',$arDate['L'],$format);
		if (isset($arDate['m'])) $format = str_replace('m',$arDate['m'],$format);
		if (isset($arDate['M'])) $format = str_replace('M',$arDate['M'],$format);
		if (isset($arDate['n'])) $format = str_replace('n',$arDate['n'],$format);
		if (isset($arDate['O'])) $format = str_replace('O',$arDate['O'],$format);
		if (isset($arDate['r'])) $format = str_replace('r',$arDate['r'],$format);
		if (isset($arDate['s'])) $format = str_replace('s',$arDate['s'],$format);
		if (isset($arDate['S'])) $format = str_replace('S',$arDate['S'],$format);
		if (isset($arDate['t'])) $format = str_replace('t',$arDate['t'],$format);
		if (isset($arDate['U'])) $format = str_replace('U',$arDate['U'],$format);
		if (isset($arDate['w'])) $format = str_replace('w',$arDate['w'],$format);
		if (isset($arDate['W'])) $format = str_replace('W',$arDate['W'],$format);
		if (isset($arDate['Y'])) $format = str_replace('Y',$arDate['Y'],$format);
		if (isset($arDate['y'])) $format = str_replace('y',$arDate['y'],$format);
		if (isset($arDate['z'])) $format = str_replace('z',$arDate['z'],$format);
		if (isset($arDate['Z'])) $format = str_replace('Z',$arDate['Z'],$format);

		return $format;

	}

}