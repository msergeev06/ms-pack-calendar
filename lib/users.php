<?php

namespace MSergeev\Packages\Calendar\Lib;

use MSergeev\Core\Lib as CoreLib;
use MSergeev\Packages\Calendar\Tables\UsersTable;

class Users
{
	/**
	 * Возвращает HEX-код цвета по-умолчанию
	 *
	 * @return bool|string
	 */
	public static function getDefaultColor ()
	{
		return CoreLib\Config::getConfig('CALENDAR_DEFAULT_COLOR');
	}

	/**
	 * Возвращаем HEX-код цвета пользователя или цвет по-умолчанию
	 *
	 * @param null|int $USER_ID ID пользователя (не указан - текущий, 0 - по-умолчанию, либо заданный)
	 *
	 * @return bool|string
	 */
	public static function getUserColor ($USER_ID=null)
	{
		if (is_null($USER_ID))
		{
			global $USER;
			$USER_ID = $USER->getID();
		}
		if ($USER_ID==0)
		{
			return self::getDefaultColor();
		}
		else
		{
			$res = UsersTable::getList(array(
				'select' => 'COLOR',
				'filter' => array('USER_ID' => $USER_ID),
				'limit' => 1
			));
			if (isset($res[0]['COLOR']))
			{
				return $res[0]['COLOR'];
			}
			else
			{
				return self::getDefaultColor();
			}
		}
	}

	/**
	 * Возвращает массив пользователей календаря
	 *
	 * @return array|bool
	 */
	public static function getList ()
	{
		$res = UsersTable::getList(array(
			'order' => array('USER_ID'=>'ASC')
		));
		if (isset($res[0]))
		{
			return $res;
		}
		else
		{
			return false;
		}
	}
}