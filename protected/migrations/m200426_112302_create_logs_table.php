<?php

class m200426_112302_create_logs_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('logs', array(
            'id' => 'pk',
            'filename' => 'string',
            'type' => 'string',
            'datetime' => 'datetime',
            'ip' => 'string',
            'status' => 'integer',
            'responseBytes' => 'integer',
            'url' => 'string',
            'request' => 'string',
            'browser' => 'string',
            'pid' => 'integer',
            'msg' => 'string',
        ));
	}
}