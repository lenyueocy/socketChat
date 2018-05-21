<?php
/**
 * author by OCY, ${YEAR}/${MONTH}/${DAY} ${HOUR}:${MINUTE}.
 */
class DB{
    public $mysqli;
    public function __construct(&$mysqli)
    {
        $config = config::get('DB');
        $mysqli = new mysqli($config['localhost'], $config['name'], $config['pwd'],$config['dbname']);
        if (mysqli_connect_errno()) {
            echo '连接数据库出错!';
            exit;
        }
    }
}