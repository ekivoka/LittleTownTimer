<?php

include_once ROOT . '/models/Kids.php';

class KidsController
{
    public function actionIndex()
    {
        $kidsList = array();
        $kidsList = Kids::getKids();
        //require_once(ROOT . "/views/Kids/index.php");
        print_r($kidsList);
        return true; 
    }
    
    public function actionStat()
    {
        echo " actionStat ";
        return true;
    }
}


?>