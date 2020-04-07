<?php

class Martin_Debug_Helper_Xdebug extends Mage_Core_Helper_Abstract{

    static public function designAsIphoneIfMyLocalDev()
    {
        //Mage_Core_Model_Design_Package::_checkUserAgentAgainstRegexps
//        Mage::log($_SERVER,null,'test.log');
        if($_SERVER['REMOTE_ADDR']=='127.0.0.1')
        {
            $_SERVER['HTTP_USER_AGENT']='iPhone';
        }
    }

    protected function _format(Array &$data)
    {
        foreach($data as $key=>$val)
        {
            if(is_object($val)) $data[$key]=get_class($val);
            if(is_array($val)) $this->_format ($data[$key]);
        }
    }
    protected function _formatBacktrace(&$backtrace)
    {
        foreach($backtrace as $key=>$val)
        {
            $this->_format($val);
            $backtrace[$key]=$val;
        }
    }
    public function logBackTrace($logfile='backtrace.log'){
        $backtrace=  debug_backtrace();
        array_shift($backtrace);
        $this->_formatBacktrace($backtrace);
        Mage::log($backtrace,null,$logfile);
    }
}
