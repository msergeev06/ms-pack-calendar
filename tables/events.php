<?php

namespace MSergeev\Packages\Calendar\Tables;

use MSergeev\Core\Entity;
use MSergeev\Core\Lib\DataManager;
use MSergeev\Core\Lib\TableHelper;

class EventsTable extends DataManager
{
	public static function getTableName ()
	{
		return 'ms_calendar_events';
	}

	public static function getTableTitle ()
	{
		return 'События календаря';
	}

	public static function getMap ()
	{
		return array(
			new Entity\IntegerField("ID",array(
				'primary' => true,
				'autocomplete' => true,
				'title' => 'ID события'
			)),
			TableHelper::activeField(),
			new Entity\StringField('NAME',array(
				'required' => true,
				'title' => 'Название события'
			)),
			new Entity\IntegerField('TYPE_ID',array(
				'required' => true,
				'default_value' => 7, //Персональная задача
				'link' => 'ms_calendar_types.ID',
				'title' => 'ID типа события'
			)),
			new Entity\IntegerField('USER_ID',array(
				'required' => true,
				'default_value' => 1,
				'title' => 'ID владельца события'
			)),
			new Entity\IntegerField('PRIVATE_STATUS',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Статус приватности события' //0 - общее, 1 - только для участников, 2 - персональное
			)),
			new Entity\TextField('MEMBERS',array(
				'serialized' => true,
				'title' => 'Дополнительные участники события'
			)),
			new Entity\IntegerField('DAY',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'День начала события'
			)),
			new Entity\IntegerField('MONTH',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Месяц начала события'
			)),
			new Entity\IntegerField('YEAR',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Год начала события'
			)),
			new Entity\IntegerField('HOUR',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Час начала события'
			)),
			new Entity\IntegerField('MIN',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Минута начала события'
			)),
			new Entity\IntegerField('ADDDAY',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Добавить/отнять дни'
			)),
			new Entity\IntegerField('STARTDAYOFWEEK',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Начало события (день недели)'
			)),
			new Entity\BooleanField('REPEAT',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяемое событие'
			)),
			new Entity\IntegerField('EVERY_DAY',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Дни повтора'
			)),
			new Entity\IntegerField('EVERY_MONTH',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Месяцы повтора'
			)),
			new Entity\IntegerField('EVERY_YEAR',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Годы повтора'
			)),
			new Entity\IntegerField('EVERY_HOUR',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Часы повтора'
			)),
			new Entity\IntegerField('EVERY_MIN',array(
				'required' => true,
				'default_value' => 0,
				'title' => 'Минуты повтора'
			)),
			new Entity\BooleanField('EVERY_MONDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Понедельникам'
			)),
			new Entity\BooleanField('EVERY_TUESDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Вторникам'
			)),
			new Entity\BooleanField('EVERY_WEDNESDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Средам'
			)),
			new Entity\BooleanField('EVERY_THURSDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Четвергам'
			)),
			new Entity\BooleanField('EVERY_FRIDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Пятницам'
			)),
			new Entity\BooleanField('EVERY_SATURDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Субботам'
			)),
			new Entity\BooleanField('EVERY_SUNDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Воскресеньям'
			)),
			new Entity\BooleanField('EVERY_WORKDAY',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Рабочим дням'
			)),
			new Entity\BooleanField('EVERY_WEEKEND',array(
				'required' => true,
				'default_value' => false,
				'title' => 'Повторяется по Выходным дням'
			)),
			new Entity\DateField('REPEAT_STOP_DATE',array(
				'title' => 'Когда произойдет последнее событие'
			))
		);
	}
}