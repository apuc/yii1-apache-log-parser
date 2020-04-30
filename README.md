<h4>Установка</h4>
1) Клонировать yii с репозитория https://github.com/yiisoft/yii
2) Bыполнить команду: composer install
3) Рядом с папкой yii клонировать logparser с репозитория https://github.com/apuc/yii1-apache-log-parser
4) Создать базу данных logparser. В файле logparser/protected/config/database.php можна настроить параметры подключения к бд.
5) Находясь в папке logparser/protected выполнить команду <b>php yiic migrate</b>
6) В файле logparser/protected/config/main.php и console.php нужно настроить путь к логам:
  
  <code>  
  'params' => array(
        'logPath' => '/var/log/apache/',
  )
  </code>
  
 <h4>Консольное чтение логов</h4>
Находясь в папке logparser/protected выполнить команду <b>php yiic readlogs</b>

<h4>Инструкция к Api</h4>

Выборка по Ip: <b>домен/api/ip?ip=127.0.0.1</b>

Выборка по дате: <b>домен/api/date?date=2020-04-24</b>

Выборка по промежутку дат: <b>домен/api/dateinterval?date1=2020-04-24&date2=2020-04-25</b>

Сгруппировать по ip: <b>домен/api/groupip</b>

Сгруппировать по дате: <b>домен/api/groupdate</b>