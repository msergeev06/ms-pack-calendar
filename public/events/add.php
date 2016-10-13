<? include_once(__DIR__."/../include/header.php"); MSergeev\Core\Lib\Buffer::setTitle("Добавление события"); ?>
<?
use \MSergeev\Packages\Calendar\Lib;
$path = MSergeev\Core\Lib\Loader::getPublic("calendar");
if (isset($_POST["action"]))
{
	if (Lib\Events::addEventFromPost($_POST))
	{
		echo "Данные успешно добавлены!";
	}
	else
	{
		echo "Ошибка добавления данных!";
	}
}
else
{
	?>
<form name="event-add" action="" method="POST">
	<table class="event-add-table">
	<tr>
		<td class="td-name">Событие активно<span class="require">*</span></td>
		<td class="td-input"><input id="active" type="checkbox" name="ACTIVE" value="Y" checked="checked"></td>
		<td style="width: 100px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Имя события<span class="require">*</span></td>
		<td><input id="name" type="text" name="NAME" value=""></td>
		<td id="event_name">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Тип события<span class="require">*</span></td>
		<td><?= Lib\Events::showSelectEventTypes () ?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Начало события<span class="require">*</span></td>
		<td>
			<table>
				<tr>
					<td><input id="day" type="text" size="5" name="DAY" value=""></td>
					<td>
						<select id="month" name="MONTH">
							<option value="0" selected>-- Выбрать --</option>
							<option value="1">01 - Январь</option>
							<option value="2">02 - Февраль</option>
							<option value="3">03 - Март</option>
							<option value="4">04 - Апрель</option>
							<option value="5">05 - Май</option>
							<option value="6">06 - Июнь</option>
							<option value="7">07 - Июль</option>
							<option value="8">08 - Август</option>
							<option value="9">09 - Сентябрь</option>
							<option value="10">10 - Октябрь</option>
							<option value="11">11 - Ноябрь</option>
							<option value="12">12 - Декабрь</option>
						</select>
					</td>
					<td><input id="year" type="text" size="5" name="YEAR" value=""></td>
					<td>
						<select id="hour" name="HOUR">
							<option value="-1" selected>--</option>
							<? for ($i = 0; $i <= 23; $i++): ?>
								<option value="<?= $i ?>"><?= $i ?></option>
							<? endfor; ?>
						</select>
					</td>
					<td>
						<select id="min" name="MIN">
							<option value="-1" selected>--</option>
							<? for ($i = 0; $i <= 59; $i++): ?>
								<option value="<?= $i ?>"><?= $i ?></option>
							<? endfor; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="center">день</td>
					<td class="center">месяц</td>
					<td class="center">год</td>
					<td class="center">час</td>
					<td class="center">минута</td>
				</tr>
				<tr>
					<td colspan="2">
						<select id="plusminusday" name="PLUSMINUSDAY">
							<option value="1" selected>Плюс</option>
							<option value="0">Минус</option>
						</select>
					</td>
					<td colspan="2"><input type="text" id="addday" name="ADDDAY" value=""></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">прибавить/отнять</td>
					<td colspan="2">дни к дате/от даты</td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table style="table-layout: fixed;">
				<tr>
					<td><input id="noday" type="radio" name="STARTDAYOFWEEK" value="0" title="нет" checked></td>
					<td><input id="monday" type="radio" name="STARTDAYOFWEEK" value="1" title="Пн."></td>
					<td><input id="tuesday" type="radio" name="STARTDAYOFWEEK" value="2" title="Вт."></td>
					<td><input id="wednesday" type="radio" name="STARTDAYOFWEEK" value="3" title="Ср."></td>
					<td><input id="thursday" type="radio" name="STARTDAYOFWEEK" value="4" title="Чт."></td>
					<td><input id="friday" type="radio" name="STARTDAYOFWEEK" value="5" title="Пт."></td>
					<td><input id="saturday" type="radio" name="STARTDAYOFWEEK" value="6" title="Сб."></td>
					<td><input id="sunday" type="radio" name="STARTDAYOFWEEK" value="7" title="Вс."></td>
				</tr>
				<tr>
					<td class="center">нет</td>
					<td class="center"><span class="workday">Пн.</span></td>
					<td class="center"><span class="workday">Вт.</span></td>
					<td class="center"><span class="workday">Ср.</span></td>
					<td class="center"><span class="workday">Чт.</span></td>
					<td class="center"><span class="workday">Пт.</span></td>
					<td class="center"><span class="weekend">Сб.</span></td>
					<td class="center"><span class="weekend">Вс.</span></td>
				</tr>
				<tr>
					<td class="center" colspan="4"><input id="workday" type="radio" name="STARTDAYOFWEEK" value="8"
					                                      title="будние дни"></td>
					<td class="center" colspan="4"><input id="weekend" type="radio" name="STARTDAYOFWEEK" value="9"
					                                      title="выходные дни"></td>
				</tr>
				<tr>
					<td class="center" colspan="4"><span class="workday">будние&nbsp;дни</span></td>
					<td class="center" colspan="4"><span class="weekend">выходные&nbsp;дни</span></td>
				</tr>
			</table>
		</td>
		<td style="vertical-align: top;">
			<table style="width: 100%;">
				<tr>
					<td><a id="clearstrtevent" href="#">Очистить поля</a></td>
				</tr>
				<tr>
					<td class="nearest_event"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Повторяемое событие</td>
		<td><input id="repeat" class="repeat" type="checkbox" name="REPEAT" value="Y"></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr class="every hidden">
		<td>Повторяется каждые<span class="require">*</span></td>
		<td>
			<table>
				<tr>
					<td><input id="every_day" type="text" size="5" name="EVERY_DAY" value=""></td>
					<td><input id="every_month" type="text" size="5" name="EVERY_MONTH" value=""></td>
					<td><input id="every_year" type="text" size="5" name="EVERY_YEAR" value=""></td>
					<td><input id="every_hour" type="text" size="5" name="EVERY_HOUR" value=""></td>
					<td><input id="every_min" type="text" size="5" name="EVERY_MIN" value=""></td>
				</tr>
				<tr>
					<td class="center">день</td>
					<td class="center">месяц</td>
					<td class="center">год</td>
					<td class="center">час</td>
					<td class="center">минута</td>
				</tr>
			</table>
			<table>
				<tr>
					<td><input id="every_monday" type="checkbox" name="EVERY_MONDAY" value="Y"></td>
					<td><input id="every_tuesday" type="checkbox" name="EVERY_TUESDAY" value="Y"></td>
					<td><input id="every_wednesday" type="checkbox" name="EVERY_WEDNESDAY" value="Y"></td>
					<td><input id="every_thursday" type="checkbox" name="EVERY_THURSDAY" value="Y"></td>
					<td><input id="every_friday" type="checkbox" name="EVERY_FRIDAY" value="Y"></td>
					<td><input id="every_saturday" type="checkbox" name="EVERY_SATURDAY" value="Y"></td>
					<td><input id="every_sunday" type="checkbox" name="EVERY_SUNDAY" value="Y"></td>
				</tr>
				<tr>
					<td class="center"><span class="workday">Пн.</span></td>
					<td class="center"><span class="workday">Вт.</span></td>
					<td class="center"><span class="workday">Ср.</span></td>
					<td class="center"><span class="workday">Чт.</span></td>
					<td class="center"><span class="workday">Пт.</span></td>
					<td class="center"><span class="weekend">Сб.</span></td>
					<td class="center"><span class="weekend">Вс.</span></td>
				</tr>
				<tr>
					<td class="center" colspan="3"><input id="every_workday" type="checkbox" name="EVERY_WORKDAY"
					                                      value="Y"></td>
					<td>&nbsp;</td>
					<td class="center" colspan="3"><input id="every_weekend" type="checkbox" name="EVERY_WEEKEND"
					                                      value="Y"></td>
				</tr>
				<tr>
					<td class="center" colspan="3"><span class="workday">будние&nbsp;дни</span></td>
					<td>&nbsp;</td>
					<td class="center" colspan="3"><span class="weekend">выходные&nbsp;дни</span></td>
				</tr>
			</table>
		</td>
		<td>
			<table style="width: 100%;">
				<tr>
					<td class="next_event"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr class="every hidden">
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr class="repeate-date hidden">
		<td>Повторяется до:</td>
		<td><?=InputCalendar("REPEATE_DATE",null,"placeholder='".date("d.m.Y")."'","repeate-date-input")?></td>
		<td>&nbsp;</td>
	</tr>
	<tr class="repeate-date hidden">
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Приватность события<span class="require">*</span>:</td>
		<td>
			<select name="PRIVATE_STATUS">
				<option value="0" selected>Видимое для всех</option>
				<option value="1">Видимое только для списка участников</option>
				<option value="2">Видимое только для создателя (персональное)</option>
			</select>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Основной участник события<span class="require">*</span>:</td>
		<td>
			<?=Lib\Events::showSelectListUsers()?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>Дополнительные участники события:</td>
		<td>
			<?=Lib\Events::showListUsers()?>
		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">
			<hr>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<input type="hidden" name="action" value="1"></td>
		<td>
			<input type="submit" name="submit_event" value="Добавить событие">
			<? /*<button id="submit_event" name="submit_event"></button>*/ ?>
		</td>
	</tr>
	</table>
</form>
	<script type="text/javascript">
	$(document).ready(function () {
/*
		if ($('#repeat').prop('checked')) {
			$('.every').removeClass('hidden');
		}
		else {
			$('.every').addClass('hidden');
		}
*/
		$('#repeat').on("click", function () {
			if ($(this).prop('checked')) {
				$('.every').removeClass('hidden');
				$('.repeate-date').removeClass('hidden');

			}
			else {
				$('.every').addClass('hidden');
				$('.repeate-date').addClass('hidden');
			}
		});


		$('#clearstrtevent').on('click', function () {
			$('#day').val(0);
			$('#month').val(0);
			$('#year').val(0);
			$('#hour').val(-1);
			$('#min').val(-1);
			$('#addday').val(0);
			$('#plusminusday').val(1);
			$('[name=STARTDAYOFWEEK]').removeAttr("checked");
			$('#noday').attr("checked", true);
			nearestEvent();
		});

		$('#name').on('keyup', function () {
			console.log($(this).val());
			$('#event_name').text($(this).val());
		});

		$('#day').on('keyup', function () {
			//console.log(this.value);
			this.value = Number(this.value);
			if (this.value >= 1 && this.value <= 31) {
				//console.log(this.value);
				nearestEvent();
			}
			else {
				this.value = 0;
				nearestEvent();
			}
		});
		$('#month').on('change', function () {
			nearestEvent();
		});
		$('#year').on('keyup', function () {
			this.value = Number(this.value);
			if (this.value >= 0) {
				nearestEvent();
			}
			else {
				this.value = 0;
				nearestEvent();
			}
		});
		$('#hour').on('change', function () {
			nearestEvent();
		});
		$('#min').on('change', function () {
			nearestEvent();
		});
		$('#addday').on('keyup', function () {
			this.value = Number(this.value);
			if (this.value >= 0 && this.value <= 366) {
				nearestEvent();
			}
			else {
				this.value = 0;
				nearestEvent();
			}
		});
		$('[name=STARTDAYOFWEEK]').on("change", function () {
			nearestEvent();
		});

		function nearestEvent() {
			var eday, emonth, eyear, ehour, emin,
				eplusminus, eaddday,
				enoday, emonday, etuesday, ewednesday, ethursday, efriday, esaturday, esunday,
				eworkday, eweekend;
			var ntimezone, nday, ndayofweek, nmonth, nyear, nhour, nmin;
			var now = new Date();
			eday = Number($('#day').val());
			emonth = Number($('#month').val());
			eyear = Number($('#year').val());
			ehour = Number($('#hour').val());
			emin = Number($('#min').val());
			eplusminus = Number($('#plusminusday').val());
			eaddday = Number($('#addday').val());
			enoday = $('#noday').prop('checked');
			emonday = $('#monday').prop('checked');
			etuesday = $('#tuesday').prop('checked');
			ewednesday = $('#wednesday').prop('checked');
			ethursday = $('#thursday').prop('checked');
			efriday = $('#friday').prop('checked');
			esaturday = $('#saturday').prop('checked');
			esunday = $('#sunday').prop('checked');
			eworkday = $('#workday').prop('checked');
			eweekend = $('#weekend').prop('checked');
			ntimezone = -now.getTimezoneOffset() / 60;
			nday = now.getUTCDate();
			ndayofweek = now.getUTCDay();
			nmonth = now.getUTCMonth() + 1;
			nyear = now.getUTCFullYear();
			nhour = now.getUTCHours() + ntimezone;
			nmin = now.getUTCMinutes();
			/*
			 console.log(eday + "." + emonth + "." + eyear + " " + ehour + ":" + emin
			 + "(Пн-" + emonday + ", Вт-" + etuesday + ", Ср-" + ewednesday + ", Чт-" + ethursday + ", Пт-" + efriday
			 + ", Сб-" + esaturday + ", Вс-" + esunday + ", Буд-" + eworkday + ", Вых-" + eweekend + ")");
			 console.log(nday + "." + nmonth + "." + nyear + " " + nhour + ":" + nmin + " " + ntimezone + "(" + ndayofweek + ")");
			 */

			$.post(
				"<?=\MSergeev\Core\Lib\Config::getConfig("CALENDAR_TOOLS_ROOT").'get_nearest_date.php'?>",
				{
					eday: eday,
					emonth: emonth,
					eyear: eyear,
					ehour: ehour,
					emin: emin,
					eplusminus: eplusminus,
					eaddday: eaddday,
					enoday: enoday,
					emonday: emonday,
					etuesday: etuesday,
					ewednesday: ewednesday,
					ethursday: ethursday,
					efriday: efriday,
					esaturday: esaturday,
					esunday: esunday,
					eworkday: eworkday,
					eweekend: eweekend,
					ntimezone: ntimezone,
					nday: nday,
					ndayofweek: ndayofweek,
					nmonth: nmonth,
					nyear: nyear,
					nhour: nhour,
					nmin: nmin
				},
				function (data) {
					console.log(data);
					$('.nearest_event').html("<br>Установленная<br>дата:<br>" + data.date.day + "." + data.date.month + "." + data.date.year + "<br>" + data.date.hour + ":" + data.date.minute + "&nbsp;(" + data.date.dayofweekname + ")<br>"
					+ "<br>Ближайная<br>дата&nbsp;события:<br>" + data.nearestDate.day + "." + data.nearestDate.month + "." + data.nearestDate.year + "<br>" + data.nearestDate.hour + ":" + data.nearestDate.minute + "&nbsp;(" + data.nearestDate.dayofweekname + ")");
				},
				"json"
			);
		}

		$('body').append('<div id="blackout"></div>');

		var boxWidth = 700;
		$(window).resize(centerBox);
		$(window).scroll(centerBox);
		centerBox();

		function centerBox() {

			/* определяем нужные данные */
			var winWidth = $(window).width();
			var winHeight = $(document).height();
			var scrollPos = $(window).scrollTop();

			/* Вычисляем позицию */

			var disWidth = (winWidth - boxWidth) / 2
			var disHeight = scrollPos + 150;

			/* Добавляем стили к блокам */
			$('.popup-box').css({'width': boxWidth + 'px', 'left': disWidth + 'px', 'top': disHeight + 'px'});
			$('#blackout').css({'width': winWidth + 'px', 'height': winHeight + 'px'});

			return false;
		}

		$('[class*=popup-link]').click(function (e) {

			/* Предотвращаем действия по умолчанию */
			e.preventDefault();
			e.stopPropagation();

			/* Получаем id (последний номер в имени класса ссылки) */
			var name = $(this).attr('class');
			var id = name[name.length - 1];
			var scrollPos = $(window).scrollTop();

			/* Корректный вывод popup окна, накрытие тенью, предотвращение скроллинга */
			$('#popup-box-' + id).show();
			$('#blackout').show();
			$('html,body').css('overflow', 'hidden');

			/* Убираем баг в Firefox */
			$('html').scrollTop(scrollPos);
		});

		$('[class*=popup-box]').click(function (e) {
			/* Предотвращаем работу ссылки, если она являеться нашим popup окном */
			e.stopPropagation();
		});

		$('html').click(function () {
			var scrollPos = $(window).scrollTop();
			/* Скрыть окно, когда кликаем вне его области */
			$('[id^=popup-box-]').hide();
			$('#blackout').hide();
			$("html,body").css("overflow", "auto");
			$('html').scrollTop(scrollPos);
		});

		$('.close').click(function () {
			var scrollPos = $(window).scrollTop();
			/* Скрываем тень и окно, когда пользователь кликнул по X */
			$('[id^=popup-box-]').hide();
			$('#blackout').hide();
			$("html,body").css("overflow", "auto");
			$('html').scrollTop(scrollPos);
		});
	});


	</script>
<?
}
?>

<? include_once(MSergeev\Core\Lib\Loader::getPublic("calendar")."include/footer.php"); ?>
