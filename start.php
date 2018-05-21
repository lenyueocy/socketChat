<?php
 class start{
     public static function run(){
         global $ctl;
         global $act;
         $control = new $ctl();
         $control ->$act();
     }
 }