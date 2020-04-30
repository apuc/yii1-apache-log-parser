<?php


class ApiController extends Controller
{
    public function actionIp()
    {
        if(isset($_GET['ip'])) {
            $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('logs')
                ->where('ip=:ip', array(':ip' => $_GET['ip']))
                ->queryAll();

            echo json_encode($data);
        } else
            echo json_encode(['error' => 'empty data']);
    }

    public function actionDate()
    {
        if(isset($_GET['date']))
            echo json_encode($this->rawSql($_GET['date'], '00:00:00', $_GET['date'], '23:59:59'));
        else
            echo json_encode(['error' => 'empty data']);
    }

    public function actionDateinterval()
    {
        if(isset($_GET['date1']) && isset($_GET['date2']))
            echo json_encode($this->rawSql($_GET['date1'], '00:00:00', $_GET['date2'], '23:59:59'));
        else
            echo json_encode(['error' => 'empty data']);
    }

    public function actionGroupip()
    {
        $data = Yii::app()->db->createCommand()->select('*')->from('logs')->group('ip')->queryAll();

        echo json_encode($data);
    }

    public function actionGroupdate()
    {
        $data = $this->rawGroupSql();

        echo json_encode($data);
    }

    public function rawSql($date1, $time1, $date2, $time2)
    {
        $sql = 'SELECT * FROM logs WHERE datetime BETWEEN "'
            . $date1 . ' ' . $time1 . '" AND "' . $date2 . ' ' . $time2 . '"';

        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function rawGroupSql()
    {
        $sql = 'SELECT * FROM logs GROUP BY DATE(datetime)';

        return Yii::app()->db->createCommand($sql)->queryAll();
    }
}