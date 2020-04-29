<?php

/**
 * This is the model class for table "logs".
 *
 * The followings are the available columns in table 'logs':
 * @property integer $id
 * @property string $filename
 * @property string $type
 * @property string $datetime
 * @property string $ip
 * @property integer $status
 * @property integer $responseBytes
 * @property string $url
 * @property string $request
 * @property string $browser
 * @property integer $pid
 * @property string $msg
 */
class Logs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'logs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, responseBytes, pid', 'numerical', 'integerOnly'=>true),
			array('filename, type, ip, url, request, browser, msg', 'length', 'max'=>255),
			array('datetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, filename, type, datetime, ip, status, responseBytes, url, request, browser, pid, msg, created_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'filename' => 'Filename',
			'type' => 'Type',
			'datetime' => 'Datetime',
			'ip' => 'Ip',
			'status' => 'Status',
			'responseBytes' => 'Response Bytes',
			'url' => 'Url',
			'request' => 'Request',
			'browser' => 'Browser',
			'pid' => 'Pid',
			'msg' => 'Msg',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('datetime',$this->datetime,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('responseBytes',$this->responseBytes);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('request',$this->request,true);
		$criteria->compare('browser',$this->browser,true);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('msg',$this->msg,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function load($log)
    {
        $this->filename = $log['filename'];
        $this->type = (isset($log['type'])) ? 'error' : 'access';
        $this->datetime = $log['datetime'];
        $this->ip = (isset($log['client'])) ? $log['client'] : $log['host'];
        $this->status = (isset($log['status'])) ? $log['status'] : 0;
        $this->responseBytes = (isset($log['responseBytes'])) ? $log['responseBytes'] : 0;
        $this->url = (isset($log['url'])) ? $log['url'] : '';
        $this->request = (isset($log['request'])) ? $log['request'] : '';
        $this->browser = (isset($log['browser'])) ? $log['browser'] : '';
        $this->pid = (isset($log['pid'])) ? $log['pid'] : 0;
        $this->msg = (isset($log['msg'])) ? $log['msg'] : '';
        $this->save();
    }

    public static function getLatestLog($filename)
    {
        return Yii::app()->db->createCommand()
            ->select('datetime')
            ->from('logs')
            ->where('filename=:filename', array(':filename' => $filename))
            ->order('datetime desc')
            ->queryRow();
    }

    public static function read()
    {
        Yii::import('webroot.protected.components.apache_parser.ApacheParserError');
        Yii::import('webroot.protected.components.apache_parser.ApacheParserAccess');
        Yii::import('webroot.protected.components.apache_parser.ApacheParser');
        Yii::import('webroot.protected.components.apache_parser.IApacheParser');

        self::reading();
    }

    public static function consoleread()
    {

        Yii::import('application.components.apache_parser.ApacheParserError');
        Yii::import('application.components.apache_parser.ApacheParserAccess');
        Yii::import('application.components.apache_parser.ApacheParser');
        Yii::import('application.components.apache_parser.IApacheParser');

       self::reading();
    }

    public static function reading()
    {
        try {
            foreach (glob(Yii::app()->params['logPath'] . Yii::app()->params['accessMask']) as $docFile) {
                $file = new ApacheParserAccess($docFile);

                $filename = str_replace(Yii::app()->params['logPath'], '', $docFile);

                $latest = self::getLatestLog($filename);

                if($latest)
                    $latest_datetime = $latest['datetime'];
                else
                    $latest_datetime = '1970-01-01 00:00:00';

                $file->parse()->each(function ($log) use ($latest_datetime, $filename) {
                    $datetime = '';
                    foreach ($log['datetime'] as $value) {
                        $datetime = $value;
                        break;
                    }
                    $datetime = substr($datetime, 0, 19);
                    $log['datetime'] = $datetime;
                    $log['filename'] = $filename;

                    if($datetime > $latest_datetime) {
                        $logs = new Logs();
                        $logs->load($log);
                    }
                });
            }
            return 0;
        } catch (Exception $e) {
            return 1;
        }
    }

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Logs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
