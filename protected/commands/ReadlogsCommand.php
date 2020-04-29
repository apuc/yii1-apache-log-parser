<?php


class ReadlogsCommand extends CConsoleCommand
{
    public function run($args) {
        Yii::import('application.modules.logs.models.Logs');
        Logs::consoleread();
    }
}