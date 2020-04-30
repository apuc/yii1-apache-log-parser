<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

?>

<h3>Консольное чтение логов</h3>
<p>Находясь в папке logparser/protected выполнить команду <b>php yiic readlogs</b></p>

<h3>Инструкция к Api</h3>

<p>Выборка по Ip: <b>домен/api/ip?ip=127.0.0.1</b></p>

<p>Выборка по дате: <b>домен/api/date?date=2020-04-24</b></p>

<p>Выборка по промежутку дат: <b>домен/api/dateinterval?date1=2020-04-24&date2=2020-04-25</b></p>

<p>Сгруппировать по ip: <b>домен/api/groupip</b></p>

<p>Сгруппировать по дате: <b>домен/api/groupdate</b></p>