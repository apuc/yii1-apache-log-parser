<?php

class m200426_112238_create_user_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('user', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'email' => 'string',
            'password_hash' => 'string  NOT NULL',
            'role' => 'integer NOT NULL',
            'timestamp' => 'timestamp',
        ));
	}
}