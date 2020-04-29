<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 25.04.20
 * Time: 0:31
 */


class ApacheParserError extends ApacheParser implements IApacheParser
{

    /**
     * @return $this
     */
    public function parse()
    {
        parent::parse();
        if ($this->file){
            foreach ($this->file as $item){
                if(!$item){
                    continue;
                }
                preg_match_all('/\[(.+?)\]/', $item, $params,PREG_SET_ORDER);
                $res = preg_replace('/\[.*\]/', '', $item);

                $pid = explode(' ', $params[2][1]);

                $date = \DateTime::createFromFormat('D M d H:i:s.u Y', $params[0][1]);

                $type = explode(':', $params[1][1]);

                $ip = null;
                if (isset($params[3])){
                    $ip = explode(' ', $params[3][0]);
                    $ip = explode(':', $ip[1]);
                }

                $this->logs[] = [
                    'datetime' => $date,
                    'type' => $type[1],
                    'pid' => $pid[1],
                    'client' => $ip[0],
                    'msg' => trim($res),
                ];
            }
        }

        return $this;
    }

}