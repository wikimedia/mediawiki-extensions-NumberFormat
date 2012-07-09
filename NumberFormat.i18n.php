<?php
/**
 * Internationalization file for the NumberFormat extension.
 *
 * @file NumberFormat.i18n.php
 * @ingroup NumberFormat
 *
 * @author Pavel Astakhov < pastakhov@yandex.ru >
 */

$messages = array();

/** English
 * @author Patrick Nagel
 */
$messages['en'] = array(
	'numberformat_desc' => 'Format numbers: insert thousands separators, round to a given number of decimals',
	'numberformat_wrongnargs' => 'Wrong number of arguments to number_format.',
	'numberformat_firstargument' => 'First argument to number_format must be a number.',
);

/** Russian (Русский)
 * @author Pavel Astakhov
 */
$messages['ru'] = array(
	'numberformat_desc' => 'Формат числа: добавление разделителя разрядов и округление до указанного количества десятичных знаков',
	'numberformat_wrongnargs' => 'Неверное количесвто аргументов для number_format.',
	'numberformat_firstargument' => 'Первый аргумент для number_format должен быть числом.',
);
