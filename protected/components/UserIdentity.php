<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        $user = Yii::app()->db->createCommand()
            ->select('id, username, password_hash, role')
            ->from('user')
            ->where('username=:username', array(':username' => $this->username))
            ->queryRow();

        if(!isset($user['username']))
			$this->errorCode='ERROR: USERNAME_INVALID';
		elseif(!password_verify($this->password, $user['password_hash']))
			$this->errorCode='ERROR: PASSWORD_INVALID';
		else
			$this->errorCode=self::ERROR_NONE;

		return !$this->errorCode;
	}
}