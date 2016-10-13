<?php

namespace MSergeev\Packages\Calendar\Tables;

use MSergeev\Core\Lib\DataManager;
use MSergeev\Core\Entity;
use MSergeev\Core\Lib\TableHelper;

class TypesTable extends DataManager
{
	public static function getTableName ()
	{
		return 'ms_calendar_types';
	}

	public static function getTableTitle()
	{
		return 'Типы событий';
	}

	public static function getTableLinks()
	{
		return array(
			'ID' => array(
				'ms_calendar_events' => 'TYPES_ID'
			)
		);
	}

	public static function getMap() {
		return array(
			new Entity\IntegerField ('ID', array(
				'primary' => true,
				'autocomplete' => true,
				'title' => 'ID типа события'
			)),
			new Entity\StringField ('NAME', array(
				'required' => true,
				'title' => 'Название типа события'
			)),
			TableHelper::activeField(),
			TableHelper::sortField(),
			new Entity\StringField ('ICON', array(
				'title' => 'Иконка типа события'
			))
		);
	}

	public static function getArrayDefaultValues ()
	{
		return array(
			0 => array(
				'ID' => 1,
				'NAME' => 'День рождения',
				'SORT' => 10,
				'ICON' => 'birthday.png'
			),
			1 => array(
				'ID' => 2,
				'NAME' => 'Праздник',
				'SORT' => 20,
				'ICON' => 'celebration.png'
			),
			2 => array(
				'ID' => 3,
				'NAME' => 'Школа',
				'SORT' => 30,
				'ICON' => 'school.png'
			),
			3 => array(
				'ID' => 4,
				'NAME' => 'Работа',
				'SORT' => 40,
				'ICON' => 'work.png'
			),
			4 => array(
				'ID' => 5,
				'NAME' => 'Дополнительные занятия',
				'SORT' => 50,
				'ICON' => 'books.png'
			),
			5 => array(
				'ID' => 6,
				'NAME' => 'Музыка',
				'SORT' => 60,
				'ICON' => 'music.png'
			),
			6 => array(
				'ID' => 7,
				'NAME' => 'Персональная задача',
				'SORT' => 480,
				'ICON' => 'personal.png'
			),
			7 => array(
				'ID' => 8,
				'NAME' => 'Скрытая задача',
				'SORT' => 490,
				'ICON' => 'locked.png'
			)
		);
	}
}