<?php
/**
 * author by OCY, 2018/05/18 18:00.
 */
class log{
    public static function debug($content){
        if(!is_array($content)){
            file_put_contents(config::get('chat')['logpath'] . 'errlog.log', date('Y/m/d H:i:s').PHP_EOL.$content.PHP_EOL.PHP_EOL.'----------------------------'.PHP_EOL,FILE_APPEND);
        }else{
            file_put_contents(config::get('chat')['logpath'] . 'errlog.log', date('Y/m/d H:i:s').PHP_EOL.var_export($content,TRUE).PHP_EOL.PHP_EOL.'----------------------------'.PHP_EOL,FILE_APPEND);
        }
    }
}