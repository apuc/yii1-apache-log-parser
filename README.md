Установка:
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
  
7) Чтение логов из консоли: находясь в папке logparser/protected выполнить команду <b>php yiic readlogs</b>