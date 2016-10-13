<?php

namespace MSergeev\Packages\Calendar\Lib;

use MSergeev\Core\Entity\Query;
use MSergeev\Core\Exception;
use MSergeev\Packages\Calendar\Tables;

class Events
{
	/**
	 * Выводит тег <SELECT> со списком типов событий
	 *
	 * @param string $strBoxName    Название тега select
	 * @param string $field1        Дополнительные поля тега select
	 *
	 * @return string               HTML-разметка
	 */
	public static function showSelectEventTypes ($strBoxName="TYPE_ID", $field1="id=\"type_id\"")
	{
		$arValues = self::getListEventTypes();

		return SelectBox($strBoxName, $arValues, "--- Выбрать ---", "null", $field1);
	}

	/**
	 * Обрабатывает поля формы добавления нового события
	 *
	 * @param array $post $_POST
	 *
	 * @return bool
	 */
	public static function addEventFromPost ($post)
	{
		//global $USER;

		//msDebug($post);
		$arPost = array();
		//Проверяем заполенность поля Активность
		if (!isset($post['ACTIVE']) || $post['ACTIVE']=='N')
		{
			$arPost['ACTIVE'] = false;
		}
		else
		{
			$arPost['ACTIVE'] = true;
		}

		//Проверяем заполенность поля Название
		if (!isset($post['NAME']))
		{
			return false;
		}
		else
		{
			$arPost['NAME'] = htmlspecialchars(trim($post['NAME']));
		}

		//Проверяем заполенность поля Тип события
		if (!isset($post['TYPE_ID']) || $post['TYPE_ID']==0)
		{
			return false;
		}
		else
		{
			$arPost['TYPE_ID'] = intval($post['TYPE_ID']);
		}

		//Добавляем значения поля День начала
		$arPost['DAY'] = intval($post['DAY']);

		//Добавляем значения поля Месяц начала
		$arPost['MONTH'] = intval($post['MONTH']);

		//Добавляем значения поля Год начала
		$arPost['YEAR'] = intval($post['YEAR']);

		//Добавляем значения поля Час начала
		if (intval($post['HOUR'])<0)
		{
			$arPost['HOUR'] = intval(date('H'));
		}
		else
		{
			$arPost['HOUR'] = intval($post['HOUR']);
		}

		//Добавляем значения поля Минута начала
		if (intval($post['MIN'])<0)
		{
			$arPost['MIN'] = intval(date('i'));
		}
		else
		{
			$arPost['MIN'] = intval($post['MIN']);
		}

		//Добавляем значения поля Плюс/Минус
		if (!isset($post['PLUSMINUSDAY']))
		{
			$arPost['PLUSMINUSDAY'] = 1;
		}
		else
		{
			$arPost['PLUSMINUSDAY'] = intval($post['PLUSMINUSDAY']);
		}

		//Добавляем значения поля Добавить/отнять дни
		$arPost['ADDDAY'] = intval($post['ADDDAY']);

		//Добавляем значения поля Начало события (дни недели)
		$arPost['STARTDAYOFWEEK'] = intval($post['STARTDAYOFWEEK']);

		//Добавляем значения поля Повторяемое событие
		if (!isset($post['REPEAT']) || $post['REPEAT']=='N')
		{
			$arPost['REPEAT'] = false;
		}
		else
		{
			$arPost['REPEAT'] = true;
		}

		//Добавляем значения поля Дни повтора
		$arPost['EVERY_DAY'] = intval($post['EVERY_DAY']);

		//Добавляем значения поля Месяцы повтора
		$arPost['EVERY_MONTH'] = intval($post['EVERY_MONTH']);

		//Добавляем значения поля Годы повтора
		$arPost['EVERY_YEAR'] = intval($post['EVERY_YEAR']);

		//Добавляем значения поля Часы повтора
		$arPost['EVERY_HOUR'] = intval($post['EVERY_HOUR']);

		//Добавляем значения поля Повтор по понедельникам
		if (!isset($post['EVERY_MONDAY']) || $post['EVERY_MONDAY']=='N')
		{
			$arPost['EVERY_MONDAY'] = false;
		}
		else
		{
			$arPost['EVERY_MONDAY'] = true;
		}
		//Добавляем значения поля Повтор по вторникам
		if (!isset($post['EVERY_TUESDAY']) || $post['EVERY_TUESDAY']=='N')
		{
			$arPost['EVERY_TUESDAY'] = false;
		}
		else
		{
			$arPost['EVERY_TUESDAY'] = true;
		}

		//Добавляем значения поля Повтор по средам
		if (!isset($post['EVERY_WEDNESDAY']) || $post['EVERY_WEDNESDAY']=='N')
		{
			$arPost['EVERY_WEDNESDAY'] = false;
		}
		else
		{
			$arPost['EVERY_WEDNESDAY'] = true;
		}

		//Добавляем значения поля Повтор по четвергам
		if (!isset($post['EVERY_THURSDAY']) || $post['EVERY_THURSDAY']=='N')
		{
			$arPost['EVERY_THURSDAY'] = false;
		}
		else
		{
			$arPost['EVERY_THURSDAY'] = true;
		}

		//Добавляем значения поля Повтор по пятницам
		if (!isset($post['EVERY_FRIDAY']) || $post['EVERY_FRIDAY']=='N')
		{
			$arPost['EVERY_FRIDAY'] = false;
		}
		else
		{
			$arPost['EVERY_FRIDAY'] = true;
		}

		//Добавляем значения поля Повтор по субботам
		if (!isset($post['EVERY_SATURDAY']) || $post['EVERY_SATURDAY']=='N')
		{
			$arPost['EVERY_SATURDAY'] = false;
		}
		else
		{
			$arPost['EVERY_SATURDAY'] = true;
		}

		//Добавляем значения поля Повтор по воскресеньям
		if (!isset($post['EVERY_SUNDAY']) || $post['EVERY_SUNDAY']=='N')
		{
			$arPost['EVERY_SUNDAY'] = false;
		}
		else
		{
			$arPost['EVERY_SUNDAY'] = true;
		}

		//Добавляем значения поля Повтор по рабочим дням
		if (!isset($post['EVERY_WORKDAY']) || $post['EVERY_WORKDAY']=='N')
		{
			$arPost['EVERY_WORKDAY'] = false;
		}
		else
		{
			$arPost['EVERY_WORKDAY'] = true;
		}

		//Добавляем значения поля Повтор по выходным дням
		if (!isset($post['EVERY_WEEKEND']) || $post['EVERY_WEEKEND']=='N')
		{
			$arPost['EVERY_WEEKEND'] = false;
		}
		else
		{
			$arPost['EVERY_WEEKEND'] = true;
		}

		//Добавляем значение поля Повторять до даты
		if (!isset($post['REPEATE_DATE']))
		{
			$arPost['REPEAT_STOP_DATE'] = '';
		}
		else
		{
			$arPost['REPEAT_STOP_DATE'] = htmlspecialchars(trim($post['REPEATE_DATE']));
		}
		if ($arPost['REPEAT_STOP_DATE']=='') $arPost['REPEAT_STOP_DATE'] = NULL;

		//Добавляем значения полня Приватный статус
		$arPost['PRIVATE_STATUS'] = intval($arPost['PRIVATE_STATUS']);

		//Добавляем значения поля Основной участник события
		$arPost['USER_ID'] = intval($post['USER_ID']);

		//Добавляем значения поля Дополнительные участники события
		if (isset($post['MEMBERS']) && !empty($post['MEMBERS']))
		{
			$arPost['MEMBERS'] = $post['MEMBERS'];
		}


		$res = self::addEventFromPostToDB($arPost);
		if ($res!==false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public static function showListUsers ($name="MEMBERS[]")
	{
		global $USER;
		$echo = "<table><tr><td>";
		$echo .= InputType('checkbox',$name,'0','',false, "", "", "members-0");
		$echo .= "</td><td><div style=\"margin: 6px 3px; width: 16px; height: 16px;"
			." -moz-border-radius: 8px; -webkit-border-radius: 8px;border-radius: 8px; display: block;float: left;"
			." background: ".Users::getUserColor(0).";color: ".Users::getUserColor(0)."; \">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Общий</b></div></td></tr>";
		if ($arUsers = Users::getList())
		{
			foreach ($arUsers as $arUser)
			{
				if ($USER->getID()!=$arUser['USER_ID'])
				{
					$echo .= "<tr><td>";
					$echo .= InputType('checkbox',$name,strval($arUser['USER_ID']),'',false, "", "", "members-".$arUser['USER_ID']);
					$echo .= "</td><td><div style=\"margin: 6px 3px; width: 16px; height: 16px;"
						." -moz-border-radius: 8px; -webkit-border-radius: 8px;border-radius: 8px; display: block;"
						."float: left; background: ".$arUser['COLOR'].";color: ".$arUser['COLOR']."; \">"
						."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>".$arUser['NAME']."</b></div></td></tr>";
				}
			}
		}
		$echo .= "</table>";

		return $echo;
	}

	public static function showSelectListUsers ($name="USER_ID")
	{
		$arValues = array();
		$arValues[] = array(
			'NAME' => 'Общий',
			'VALUE' => 0
		);
		global $USER;
		if ($arUsers = Users::getList())
		{
			foreach ($arUsers as $arUser)
			{
				$arValues[] = array(
					'NAME' => $arUser['NAME'],
					'VALUE' => $arUser['USER_ID']
				);
			}
		}
		return SelectBox($name,$arValues,'',$USER->getID());
	}

	/**
	 * Добавляет новое событие в DB
	 *
	 * @param array $arPost
	 *
	 * @return bool|int
	 */
	protected static function addEventFromPostToDB ($arPost=null)
	{
		try
		{
			if (is_null($arPost))
			{
				throw new Exception\ArgumentNullException('$arPost');
			}
			elseif (!is_array($arPost))
			{
				throw new Exception\ArgumentTypeException('$arPost','array');
			}
		}
		catch (Exception\ArgumentNullException $e1)
		{
			$e1->showException();
			return false;
		}
		catch (Exception\ArgumentTypeException $e2)
		{
			$e2->showException();
		}

		$query = new Query('insert');
		$query->setInsertParams(
			$arPost,
			Tables\EventsTable::getTableName(),
			Tables\EventsTable::getMapArray()
		);
		$res = $query->exec();
		if ($res->getInsertId()>0)
		{
			return $res->getInsertId();
		}
		else
		{
			return false;
		}
	}

	/**
	 * Возвращает массив со спиком типов событий
	 *
	 * @return array|bool
	 */
	protected static function getListEventTypes ()
	{
		$res = Tables\TypesTable::getList(array(
			'select' => array(
				'ID' => 'VALUE',
				'NAME'
			),
			'filter' => array(
				'ACTIVE' => true
			),
			'order' => array('SORT'=>'ASC')
		));
		if ($res)
		{
			return $res;
		}
		else
		{
			return false;
		}
	}


}