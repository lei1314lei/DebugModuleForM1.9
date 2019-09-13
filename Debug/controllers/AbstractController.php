<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractController
 *
 * @author martin.tian
 */
class Xtwocn_Debug_AbstractController extends Mage_Core_Controller_Front_Action{
    /**
     * 
     * @param array|Varien_Object $arr
     * @param string $newlineChrctr
     * @return string  
     */
    protected function _formatAsArrayString($arr,$newlineChrctr="<br>")
    {
        $str=$newlineChrctr."array(";
        if($arr instanceof Varien_Object)
        {
            $arr=$arr->getData();
        }
        if(is_array($arr))
        {
            foreach($arr as $key=>$val)
            {

               $str.=$newlineChrctr."'{$key}'=>'{$val}' ,"   ;
            }
            $str.=$newlineChrctr." );";
            return $str;
        }
        return null;
    }
}
