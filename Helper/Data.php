<?php

class Xtwocn_Debug_Helper_Data extends Mage_Core_Helper_Abstract{
	CONST DEBUG_TRIGGER='debug';
	CONST LOG_LAYOUT_MERGING='XTW_DBG_LayoutFileMergingProcess.log';
	CONST LOG_ROUTER_MATCHING='XTW_DBG_RouterMatchingProcess.log';
	CONST LOG_LAYOUT_XML="XTW_DBG_LayoutXml.log";
	CONST LOG_REQUEST="XTW_DBG_Request.log";
	CONST LOG_HANDLES ="XTW_DBG_Handles.log";
	public function debugTriggered()
	{
		$params=$this->_getRequest()->getParams();
		if(isset($params[self::DEBUG_TRIGGER])){
		    return true;
		}else{
		    return false;
		}
	}
	public function xmlToHtml($xmlString){
	    return "<pre>".htmlentities($xmlString)."</pre>";
	}


	public function hintTemplate(){
	    return $this->debugTriggered()?true:false;

	}
    
//    public function showRouterMatching()
//    {
//        $request=$this->_getRequest();
//        $params=$request->getParams();
//        if(isset($params['logRouterMatchingInfoes'])){
//            return true;
//        }else{
//            return false;
//        }
//    }
//    public function showLayoutXml(){
//        $request=$this->_getRequest();
//        $params=$request->getParams();
//        if(isset($params['showLayoutXml'])){
//            return true;
//        }else{
//            return false;
//        }
//    }
//    public function showActionDetail()
//    {
//        $request=$this->_getRequest();
//        $params=$request->getParams();
//        if(isset($params['showAction'])){
//            return true;
//        }else{
//            return false;
//        }
//    }
//    public function showHandles()
//    {
//        $request=$this->_getRequest();
//        $params=$request->getParams();
//        if(isset($params['showHandles'])){
//            return true;
//        }else{
//            return false;
//        }
//    }


}
