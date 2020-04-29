<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 24.04.20
 * Time: 23:55
 */


class ApacheParser
{
    public $filePath;
    public $file;
    public $logs = [];

    public function __construct(string $filePath)
    {
        $this->setFile($filePath);
        $this->loadFile();
    }

    public function parse()
    {
        $this->logs = [];
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @param \Closure $closure
     */
    public function each(\Closure $closure)
    {
        if ($this->logs){
            foreach ($this->logs as $log){
                call_user_func_array($closure, [$log]);
            }
        }
    }

    /**
     * @param string $filePath
     */
    protected function setFile(string $filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Load file
     */
    protected function loadFile()
    {
        if ($this->filePath) {
            //Получаем файл
            $this->file = file_get_contents($this->filePath);

            //унификация делителя для разных ОС
            $this->file = preg_replace("#\r\n|\r|\n#", PHP_EOL, $this->file);

            $this->file = explode(PHP_EOL, $this->file);
            $this->file = array_reverse($this->file);
        }
    }


}