<?php
$file = './config/config.php';
if(!file_exists($file)) {
?>
<html>
    <body>
        <form action="" method="post">
            数据库地址：<input type="text" name="localhost" value="127.0.0.1">
            <br />
            <br />
            用户：<input type="text" name="name" value="root">
            <br />
            <br />
            密码：<input type="text" name="pwd" value="">
            <br />
            <br />
            <input type="submit" value="确定">
        </form>
    </body>
</html>

<?php
    if(!empty($_POST)) {
        $config = $_POST;
        //连接数据库
        $mysqli = new mysqli($config['localhost'], $config['name'], $config['pwd']);
        if (mysqli_connect_errno()) {
            echo '连接数据库出错!';
            exit;
        }
        //获取sql语句
        $sql_txt = file_get_contents('./sql/install.sql');
        $sqls = explode(';', $sql_txt);
        array_pop($sqls);
        foreach ($sqls as $key => $val) {
            $result = $mysqli->query($val . ';') or die(mysqli_error($mysqli));
        }
        $mysqli->close();
        $config_c = "<?php
return [
        'DB'=>[
            'localhost' => '".$config['localhost']."',
            'name' => '".$config['name']."',
            'pwd' => '".$config['pwd']."',
        ],
        'chat'=>[
            'port'=>'9090'
        ]
    ];
        ";
        file_put_contents('./config/config.php',$config_c) or die('配置文件写入失败！');
        echo "<script type='text/javascript'>location.href='index.php';</script>";
    }
}else{
    echo "<script>location.href='index.php';</script>";
}
