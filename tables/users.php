<?php

namespace MSergeev\Packages\Calendar\Tables;

use MSergeev\Core\Entity;
use MSergeev\Core\Lib;

class UsersTable extends Lib\DataManager
{
	public static function getTableName ()
	{
		return 'ms_calendar_users';
	}

	public static function getTableTitle ()
	{
		return 'Пользователи календаря';
	}

	public static function getMap ()
	{
		return array(
			new Entity\IntegerField('ID',array(
				'primary' => true,
				'autocomplete' => true,
				'title' => 'ID записи о пользователе'
			)),
			new Entity\IntegerField('USER_ID',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'ID пользователя в системе'
			)),
			new Entity\StringField('NAME',array(
				'required' => true,
				'title' => 'Имя пользователя'
			)),
			new Entity\StringField('COLOR',array(
				'required' => true,
				'size' => 7,
				'default_value' => Lib\Config::getConfig('CALENDAR_DEFAULT_COLOR'),
				'title' => 'HEX-код цвета пользователя'
			))
		);
	}
}
