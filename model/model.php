<?php
    class model extends DB{
        private $table;
        public $mysqli;
        public function __construct(){
            //连接数据库
            $DB = new DB($this->mysqli);
        }
        public function __destruct()
        {
            //关闭数据库连接
            $this->mysqli->close();
        }
        public function getRow($col,$where = ' '){

            $sql = "select {$col} from {$where}";
        }
        public static function insert($table = null,$data = null,$file=null){
            /*$this->set_table($table);
            $col = implode(',',$this->get_column());
            $data = implode(',',$data);
            $sql = "INSERT INTO {$table}({$col}) value({$data})";
            $res=$this->query($sql);*/
        }
        public function save(&$data,$where=null){
            $priKey = $this->primary_key();
            if(array_key_exists($priKey,$data)){
                $str_resetData = $this->reset_data($data,'update');
                $sql = "update {$this->table} set {$str_resetData} where {$priKey}={$data[$priKey]};";
                $result = $this->query($sql);
            }else{
                $str_resetData = $this->reset_data($data,'insert');
                $sql = "insert into {$this->table}({$str_resetData[0]}) VALUE({$str_resetData[1]});";
                $result = $this->query($sql);
                $res_insertId = $this->query("select LAST_INSERT_ID();");
                $arr_insertId = $res_insertId->fetch_assoc();
                $data[$priKey] = $arr_insertId['LAST_INSERT_ID()'];
            }
            return $result;
        }
        public function query($sql){
            $result = $this->mysqli->query($sql);
            return $result;
        }

        /**
         * 获取数据表的自增主键
         * @author by O.C.Y
         */
        public function primary_key(){
            $sql = "describe {$this->table}";
            $res = $this->query($sql);
            $primary_key = false;
            while ($row=$res->fetch_assoc()){
                if($row['Key'] == 'PRI'){
                    $primary_key = $row['Field'];
                    break;
                }
            }
            return $primary_key;
        }
        /**
         * 重组data数据
         * @author by O.C.Y
         */
        public function reset_data($data,$type){
            if($type == 'update') {
                $priKey = $this->primary_key();
                if (array_key_exists($priKey, $data))
                    unset($data[$priKey]);
                $count = 0;
                foreach ($data as $key => $val) {
                    $and = ',';
                    if ($count == 0)
                        $and = ' ';
                    $str .= " {$and} {$key}='{$val}' ";
                    $count++;
                }
                return $str;
            }else if($type == 'insert'){
                $count = 0;
                foreach ($data as $key=>$val){
                    $and = ',';
                    if ($count == 0)
                        $and = ' ';
                    $str0 .= $and.$key;
                    $str1 .= " {$and} '{$val}' ";
                    $count++;
                }
                $str[0] = $str0;
                $str[1] = $str1;
                return $str;
            }else{
                return false;
            }
        }
        //获取表中列字段
        public function get_column(){
            $sql = "SHOW FULL COLUMNS FROM {$this->dbname}.{$this->table}";
            $data=$this->query($sql);
            while ($row = $data->fetch_array()){
                $col_arr[]=$row[0];
            }
            return $col_arr;
        }

        public function set_table($table){
            $this->table = $table;
        }
        public static function table($name){
            $nameModel = $name."Model";
            include "./model/".$nameModel.".php";
            $tableModel = new $nameModel();
            $tableModel -> set_table($name);
            return $tableModel;
        }
        public function ceshi(){
            return new self;
        }
        public function ceshi1(){
            return new self;
        }
        public function ceshi2(){
            return new self;
        }
        public function ceshi3(){
            return new self;
        }
        public function ceshi4(){
            echo "<pre>";
            print_r(111);
            exit;
            return new self;
        }
    }
