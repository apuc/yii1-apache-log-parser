<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 25.04.20
 * Time: 1:19
 */


class ApacheParserAccess extends ApacheParser implements IApacheParser
{

    public function parse()
    {
        parent::parse();
        if ($this->file){
            foreach ($this->file as $item){
                if(!$item){
                    continue;
                }
                preg_match_all('/\[(.+?)\]/', $item, $datetime,PREG_SET_ORDER);
                preg_match_all('/\"(.+?)\"/', $item, $params,PREG_SET_ORDER);
                preg_match_all('/\d{3} \d*/', $item, $status_size);
                $host = explode(' ', $item);
                $host = $host[0];

                $date = \DateTime::createFromFormat('d/M/Y:H:i:s O', $datetime[0][1]);
                list($status, $size) = explode(' ', $status_size[0][0]);

                $this->logs[] = [
                    'datetime' => $date,
                    'host' => $host,
                    'status' => $status,
                    'responseBytes' => $size,
                    'url' => $params[1][1],
                    'request' => $params[0][1],
                    'browser' => $params[2][1],
                ];
            }
        }

        return $this;
    }

}