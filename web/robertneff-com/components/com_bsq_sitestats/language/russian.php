<?php

/*
BSQ_Sitestats is written by Brent Stolle (c) 2005
Brent can be contacted at dev@bs-squared.com or at http://www.bs-squared.com/

This software is FREE. Please distribute it under the terms of the GNU/GPL License
See http://www.gnu.org/copyleft/gpl.html GNU/GPL for details.

If you fork this to create your own project, please make a reference to BSQ_Sitestats
someplace in your code and provide a link to http://www.bs-squared.com

BSQ_Sitestats is based on and made to operate along side of Shaun Inman's ShortStat
http://www.shauninman.com/
*/

/**
* HTML_com_bsq_sitestats Class
* @package bsq_sitestats
* @copyright 2005 Brent Stolle
* @license http://www.gnu.org/copyleft/gpl.html. GNU Public License
* @author Brent Stolle <dev@bs-squared.com>
*
*/

if (!defined('BSQ_LANGUAGE')) {
define('BSQ_LANGUAGE', true);

/* General */
define('_BSQ_YES', 'Да');
define('_BSQ_NO', 'Нет');

/* Report Titles */
define('_BSQ_SSS_TITLE', 'Общая статистика сайта');

/* Row and Column Titles */
define('_BSQ_TOTAL', 'Всего');
define('_BSQ_TODAY', 'Сегодня');
define('_BSQ_WEEK', 'Неделя');
define('_BSQ_MONTH', 'Месяц');
define('_BSQ_YEAR', 'Год');
define('_BSQ_COUNT', 'Количество');
define('_BSQ_HITS', 'Обращения');
define('_BSQ_DATE', 'Дата');
define('_BSQ_HOURS', 'Часов');
define('_BSQ_SUMMARY', 'Свод');
define('_BSQ_LATESTVISITORS', 'Последние посетители');
define('_BSQ_RESOURCEFREQ', 'Частота по ресурсу');
define('_BSQ_RESOURCE', 'Ресурс');
define('_BSQ_RESOURCES', 'Ресурсы');
define('_BSQ_BROWSER', 'Броузер');
define('_BSQ_BROWSERS', 'Броузеры');
define('_BSQ_BROWSERFREQ', 'Частота по броузеру');
define('_BSQ_REFERER', 'Адресат');
define('_BSQ_REFERERS', 'Адресаты');
define('_BSQ_RECENTREFERERS', 'Последние адресаты');
define('_BSQ_REFERERFREQ', 'Частота по адресу');
define('_BSQ_DOMAIN', 'Домен');
define('_BSQ_DOMAINS', 'Домены');
define('_BSQ_DOMAINFREQ', 'Частота по домену');
define('_BSQ_LANGUAGE', 'Язык');
define('_BSQ_LANGUAGES', 'Языки');
define('_BSQ_LANGUAGEFREQ', 'Частота по языку');
define('_BSQ_KEYWORDS', 'Слова');
define('_BSQ_KEYWORDFREQ', 'Частота по ключевому слову');
define('_BSQ_TOTALHITS', 'Всего обращений');
define('_BSQ_UNIQUEVISITORS', 'Уникальные посетители');
define('_BSQ_HITSTODAY', 'Обращения сегодня');
define('_BSQ_UNIQUEVISITORSTODAY', 'Уникальных IP сегодня');
define('_BSQ_VIEWSINWINDOW', "Views since %s per %d seconds");
define('_BSQ_AVERAGEHITSPERIP', 'Средние обращения/ip');
define('_BSQ_PLATFORM', 'Платформа');
define('_BSQ_PLATFORMFREQ', 'Частота по платформе');
define('_BSQ_CLIENTIP', 'IP клиента');
define('_BSQ_NOMATCHINGROWS', 'Нет подходящих строк');
define('_BSQ_SITESTATSSUMMARY', 'Сводная статистика сайта');
define('_BSQ_VISITORS', 'Посетители');
define('_BSQ_USER', 'Пользователь');
define('_BSQ_USERS', 'Пользователи');
define('_BSQ_USERFREQ', 'Частота по пользователю');
define('_BSQ_USERSRECENTHITS', 'Последние обращения пользователя\'ей');
define('_BSQ_LONGITUDE', 'Долгота');
define('_BSQ_LATITUDE', 'Широта');
define('_BSQ_HOSTNAME', 'Имя хоста');
define('_BSQ_CITY', 'Город');
define('_BSQ_COUNTRY', 'Страна');
define('_BSQ_COUNTRYFLAG', 'Флаг страны');
define('_BSQ_DATABASEUPGRADED', 'База данных была доведена до последней версии');
define('_BSQ_DATABASEUPTODATE', 'База данных уже новая');
define('_BSQ_NA', 'N/A');
define('_BSQ_IPADDRESS', 'IP адрес');
define('_BSQ_IPADDRESSLOOKUP', 'Поиск IP адреса');
define('_BSQ_USERSUSED', 'Users Used');
define('_BSQ_PRIVATEADDRESS', 'Частный адрес');
define('_BSQ_LASTNHITSFORIP', 'Последнее %d обращение для IP');

/* Front-end general stuff */
define('_BSQ_ALLREPORTSDISABLED', '<i>Все отчеты были выключены администратором</i>');

/* Back-end general stuff */
define('_BSQ_CFGNOTWRITEABLE', 'Файл конфигурации не записываемый!');
define('_BSQ_SETTINGSSAVED', 'Настройки сохранены');
define('_BSQ_INSTALLWORKED', 
           "<p>Это компонент ведения статистики сайта для Joomla сделан таким образом, чтобы быть легким и стабильным.</p>\n" . 
	       "<p><strong><font color=\"red\">Вы должны добавить следующие строки в index.php шаблона'ов Joomla для того чтобы
	        этот компонент регистрировал обращения. <u>Этот файл менялся между 1.3.0 и 1.4.0</u>.</font></strong></p>" .
	        '<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>');

/* Graphing Stuff */
define('_BSQ_NOTENOUGHFORLINECHART', 'Не достаточно данных для построения линейной диаграммы <strong>%s</strong>.');
define('_BSQ_NOTENOUGHFORBARCHART', 'Не достаточно данных для построения столбчатой диаграммы <strong>%s</strong>.');

define('_BSQ_BARCHARTNOTSUPPORTED', "<p>Столбчатая диаграмма не поддерживается для:<strong>%s</strong>. Пожалуйста выберите другой отчет или постройте его таблично.</p>\n");	        
define('_BSQ_JPGRAPHMISSING', 'Вы должны установить компонент JPGraph перед включением графики в BSQ Sitestats');
define('_BSQ_MUSTENABLEGRAPH', 'Вы должны включить графику среди параметров BSQ Sitestats\' компонента');
define('_BSQ_HITSPER', 'Обращения в');
define('_BSQ_MINUTE', 'Минуту');
define('_BSQ_MINUTES', 'Минуты');
define('_BSQ_HOUR', 'Час');
define('_BSQ_DAY', 'День');
define('_BSQ_DAYS', 'Дни');
define('_BSQ_WEEKS', 'Недели');
define('_BSQ_GRAPHWIDTH', 'Ширина графика');
define('_BSQ_GRAPHWIDTHDESC', 'Ширина рисунка для генерации при помощи JPGraph. Сделайте ее достаточно маленькой для умещения в ваш шаблон но достаточно широкой чтобы видеть все.');
define('_BSQ_GRAPHHEIGHT', 'Высота графика');
define('_BSQ_GRAPHHEIGHTDESC', 'Высота картинки для генерации при помощи JPGraph');
define('_BSQ_GRAPHFORCOMPONENT', 'Компонент графиков');
define('_BSQ_GRAPHFORCOMPONENTDESC', 'Использует JPGraph для генерации графиков для отчетов компонента которые поддерживают графику.');
define('_BSQ_GRAPHCACHETIME', 'Время кеширования');
define('_BSQ_GRAPHCACHETIMEDESC', 'Количество времени для кеширования графиков. Сделайте его большим поскольку генерация графиков занимает много процессорного времени.');
define('_BSQ_VISITORSGRAPHINTERVAL', 'Интервал графика посетителей');
define('_BSQ_VISITORSGRAPHINTERVALDESC', 'Временной интервал между тиков для использования в графике посетителей. Тик - это одна точка на оси X.');
define('_BSQ_BARCHARTVALUECOLOR', 'Цвет значения стобца');
define('_BSQ_BARCHARTVALUECOLORDESC', 'Цвет числового значения на праовй стороне каждого столбца Столбчатой Диаграммы. HTML цвет, начинающийся с #.');
define('_BSQ_BARCHARTFILLCOLOR', 'Цвет заливки столбца');
define('_BSQ_BARCHARTFILLCOLORDESC', 'Какого цвета должны быть столбцы на Столбчатой Диаграмме? HTML цвет, начинающийся с #.');

/* Остальное касается настроек административной части */
define('_BSQ_GRAPHING', 'Графика');
define('_BSQ_ENABLEGRAPHING', 'Включить графику');
define('_BSQ_ENABLEGRAPHINGDESC', 'Включить графику в BSQ Sitestats. Это зависит от компонента JPGraph.');
define('_BSQ_GRAPHTIMEFORMAT', 'Формат времени');
define('_BSQ_GRAPHTIMEFORMATDESC', 'date() совместимая строка определяющая как время должно отображаться на графиках.'); 
define('_BSQ_GRAPHDATEFORMAT', 'Формат даты');
define('_BSQ_GRAPHDATEFORMATDESC', 'date() совместимая строка определяющая как дата должна отображаться на графиках.'); 
define('_BSQ_REPORTING', 'Отчеты');
define('_BSQ_COMPRESSION', 'Сжатие');
define('_BSQ_HITTRACKING', 'Обращения');
define('_BSQ_TRACKHITS', 'Учет обращений?');
define('_BSQ_TRACKHITSDESC', 'Должен ли компонент учитывать обращения вообще? Установите в НЕТ для отключения bsq_sitestats');
define('_BSQ_DEBUGQUERIES', 'Отладка запросов');
define('_BSQ_DEBUGQUERIESDESC', 'Выводить запросы на станицу вместо выполнения их в базе данных (полезно для отладки)');
define('_BSQ_IPTOCOUNTRY', 'Страна по IP');
define('_BSQ_IPTOCOUNTRYDESC', 'Должен ли компонент устанваливать страну основываясь на IP адресе? (1 дополнительный <strong>медленный</strong> запрос на обращение)');
define('_BSQ_DOKEYWORDSNIFF', 'Поисковики');
define('_BSQ_DOKEYWORDSNIFFDESC', 'Должен ли компонент учитывать строки поисковых машин которые найдет? (2 запроса на обращение к странице)');
define('_BSQ_COMPRESSAGE', 'Минимальный возраст сжатия');
define('_BSQ_COMPRESSAGEDESC', 'Насколько старой должна быть статистика перед сжатием?');
define('_BSQ_HITSPERCOMPRESS', 'Обращений для сжатия');
define('_BSQ_HITSPERCOMPRESSDESC', 'Как много обращений должен компонент обрабатывать за одно сжатие. Установка этого параметра в слишком большое значение может стать причиной временных задержек.');
define('_BSQ_CACHETIME', 'Время кеширования');
define('_BSQ_CACHETIMEDESC', 'Как долго надо кешировать вывод компонента?');
define('_BSQ_ROWSPERREPORT', 'Строк в отчете');
define('_BSQ_ROWSPERREPORTDESC', 'Число строк на отчет. Увеличение этого числа сделает загрузку страниц более долгой и обращение к базе данных более тяжелым.');
define('_BSQ_CSSPREPEND', 'CSS приставка');
define('_BSQ_CSSPREPENDDESC', 'Что надо добавлять впереди всех классов BSQ Sitestats?');
define('_BSQ_DATEFORMAT', 'Формат даты');
define('_BSQ_DATEFORMATDESC', 'Введите совместимую с date() строку для форматирования даты.');
define('_BSQ_USEINTERNALCSS', 'Внутренняя CSS');
define('_BSQ_USEINTERNALCSSDESC', 'Использовать для форматирования включенный в комплект файл bsq_sitestats.css чтобы перекрыть CSS шаблона.');
define('_BSQ_USEDAYBOUNDARY', 'Округление до дня');
define('_BSQ_USEDAYBOUNDARYDESC', 'Выравнивать статистику до дня при формировании переодической статистики типа дневной, недельной, и месячной.');
define('_BSQ_REPORTHOURSOFFSET', 'Смещение времени');
define('_BSQ_REPORTHOURSOFFSETDESC', 'Количество часов сообщающих как NOW соответствует времени сервера. Если сервер на 1 час впереди вас, установите \'-1 час\'');
define('_BSQ_FRONTEND', 'Сайт');
define('_BSQ_SHOWONFRONTEND', 'Показываться следующие отчеты на сайте:');
define('_BSQ_VISITORGRAPH', 'График посетителей');
define('_BSQ_SHOWUSERSAS', 'Пользователь как');
define('_BSQ_SHOWUSERSASDESC', 'Как отображать пользователей в отчетах. Этот параметр может быть ID пользователя, логином пользователя, или ником пользователя');
define('_BSQ_ID', 'ID');
define('_BSQ_USERNAME', 'Логин');
define('_BSQ_NICKNAME', 'Ник');

/* Stats compression stuff */
define('_BSQ_SITESTATSCOMPRESSION', 'BSQ Sitestats сжатие');
define('_BSQ_COMPRESSCLICKAGAIN', "<p>Нажмите на это меню еще раз чтобы сжать больше строк.</p>\n");

/* Help stuff */
define('_BSQ_SHOWWELCOME', '
	<div style="font-size: 14px; text-align: left; width: 760px;">
	<h1>BSQ Sitestats</h1>
	<table>
		<tr<td colspan="2" style="font-size: 14px; font-weight: bolder;">The BSQ Sitestats Team</td></tr>
		<tr><td width="100">Brent Stolle</td><td>Lead Developer</td></tr>
		<tr><td width="100">Michiel Bijland</td><td>Developer</td></tr>
		<tr><td width="100">Markus R№ping</td><td>Translator (German)</td></tr>
		<tr><td width="100">Dennis Pleiter</td><td>Translator (Dutch)</td></tr>
		<tr><td width="100">Trond Bratli</td><td>Translator (Norwegian)</td></tr>
		<tr><td width="100">Paul Ishenin</td><td>Translator (Russian)</td></tr>
	</table>
	<p>Это программное обеспечение является свободным. Пожалуйста, распространяйте его под лицензией GNU/GPL<br />
	Посмотрите <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">http://www.gnu.org/copyleft/gpl.html</a> GNU/GPL для дополнительной информации.</p>
	
	<p>Если вы сделаете свой проект на основе этих компонент, пажалуйста сделайте ссылку на BSQ Sitestats
	где-либо в вашем коде и обеспечьте ссылку на http://www.bs-squared.com</p>

	<p>BSQ Sitestats is based on and made to operate along side of Shaun Inman\'s <b>ShortStat</b>
	<a href="http://www.shauninman.com/" target="_blank">http://www.shauninman.com/</a></p>
	<p>Brent can be contacted at <a href="mailto:dev@bs-squared.com">dev@bs-squared.com</a> or at <a href="http://www.bs-squared.com/mambo/index.php" target="_blank">http://www.bs-squared.com/</a></p>
	<hr width="100%" size="1px">
	</div>
        ');

define('_BSQ_SHOWHELPTEXT', '
		<div style="font-size: 14px; text-align: left; width: 760px;">
			<h3>BSQ Sitestats</h3>
			<p>Чтобы включить <strong>BSQ Sitestats</strong> в вашей Joomla, добавьте следующие строки в HTML шаблона\'ов:</p>
			<p style="font-size: 10px; font-weight: bolder;">
			    &lt;?php<br />
				if(file_exists($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;))<br />
				{<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;require_once($mosConfig_absolute_path.&quot;/components/com_bsq_sitestats/bsqtemplateinc.php&quot;);<br />
				}<br />
				?&gt;<br />
			</p>
			<p>Чтобы выполнять автоматическое сжатие статистики, добавьте следующее к заданиям cron:</p>');
define('_BSQ_SHOWHELPTEXT2', '			
			<p>Для получени Персональной Помощи, посетите форумы <a href="http://www.bs-squared.com/forum" target="_blank">BS-Squared</a>.</p>
			<hr width="100%" size="1px">
		</div>
		');

/* IP 2 Country */
define('_BSQ_IMPORTCOUNTRIESWORKED', 'Импорт IP в CSV файл стран выполнен успешно');
define('_BSQ_IMPORTCOUNTRIES',
                 "<h3>Как выполнить импорт IP в данные стран:</h3><p>\n" .
  			 	 "1. Скачайте последний iptocountry CSV файл с <a target=\"_blank\" ".
  			 	 "href=\"http://ip-to-country.webhosting.info/downloads/ip-to-country.csv.zip\">здесь</a>.<br />\n" .
  			 	 "2. Распакуйте .csv файл в <strong>");
define('_BSQ_IMPORTCOUNTRIES2',
  			 	 "</strong><br />\n" .
  			 	 "3. Запустите этот скрипт еще раз. Импорт займет около минуты, в зависимости от скорости вашего сервера базы данных.</p>\n"
				 );
				 
/* Ip2City */
define('_BSQ_CANTOPENFORREADING', "Не возможно открыть '%s' для чтения.");
define('_BSQ_CANTFOPENURLS', 'Ваш сервер не имеет возможности открытия URL через fopen(), который необходим для Ip2City. Установите <b>allow_url_fopen</b>=true в php.ini');
define('_BSQ_FLAGFORUSERSCOUNTRY', 'Флаг для страны пользователя\'ей');
define('_BSQ_IPTOSEARCHFOR', 'IP адрес для поиска:');
define('_BSQ_PLEASESPECIFYANIP', 'Пожалуйста, укажите IP выше.');
define('_BSQ_LOOKUPIP', 'Поиск IP');

} /* BSQ_LANGUAGE */
?>