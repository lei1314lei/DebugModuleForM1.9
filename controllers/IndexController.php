<?php

class Martin_Debug_IndexController extends Mage_Core_Controller_Front_Action
{
    public function deletePageAction()
    {
               $identifiers=array('wms-about-us','wms-resources','wms-solutions');
               $pages=Mage::getModel('cms/page')->getCollection()
                ->addFieldToFilter('identifier',array('in'=>$identifiers));
               foreach($pages as $page)
               {
                   $page->delete();
               }
               echo 'ok';
    }
    public function indexAction(){
        try{
        } catch (Exception $ex) {
              var_dump($ex);
        }

        echo 'breakpoint';exit;
        
        
        
        

            
    }
    
    
    public function backtraceAction(){
        $backtrace=  debug_backtrace();
      //  var_dump($backtrace);exit;
        $str='';
        $timer=0;
        function handleArray($array,$prefix){
            $prefix.='--';
            
            foreach($array as $key=>$item){
                $str.=$prefix."$key=>\r\n";
                if(is_object($item)){
                    $item="object:".get_class($item);
                }elseif(is_array($item)){
                    $item=handleArray($item, $prefix);
                }
                
                $str.=$prefix.$item."\r\n";
            }
            return $str;
        }
        $obj=Mage::getModel('catalog/product');
        $arr=array(
            'niah',
            array(
                'shide',
                $obj
                ),
        );
        echo "<pre>",handleArray($arr),"</pre>";
        exit;   
        foreach($backtrace as $item){
            $str.="\r\n\r\n $timer";
            foreach($item as $key=>$data){
                if(is_object($data)){
                    $str.="\r\n$key => ".get_class($data);
                }elseif(is_array($data)){
                    $str.="\r\n$key : \r\n   ";
//                    foreach($data as $argsItem){
//                        
//                    }
                    $str.=json_encode($data);
                }else{
                   $str.="\r\n$key => $data";
                }
                
            }
            $timer++;
        }
        echo "<pre>",$str,"</pre>";exit;
    }
    
    
    public function demoAction(){
        
        $write=Mage::getSingleton('core/resource')->getConnection('write');
                    $select = $write->select()
                ->from(
                    array('l' => $write->getTableName('catalog/product_relation')),
                    'parent_id')
                ->join(
                    array('e' => $write->getTableName('catalog/product')),
                    'e.entity_id = l.parent_id',
                    array('type_id'))
                ->where('l.child_id IN(?)', array(1,2,3));
                    
        echo $select;exit;
                    
        Mage::getResourceModel('catalog/product_indexer_price')->reindexProductIds(418);
        echo 'demo';
        exit;
       var_dump(get_class_methods(Mage::getSingleton('core/resource')),Mage::getSingleton('core/resource')->getConnection()) ;
       
      
      exit;
       $product = Mage::getModel('index/event')->load(306);
       var_dump($product->getDataObject());exit;
//        $layout=Mage::app()->getLayout();
//        echo $layout->createBlock("core/template", "shipping")
//                ->setTemplate('martin/shipping/shippingtablerate.phtml')
//                ->toHtml();

    }
    protected $_addedFlag="blockId";
    
    public function testAction(){
        var_dump(get_class_methods('Mage_Catalog_Model_Product'));exit;
        
        $order=Mage::getModel('sales/order')->load(122);
        var_dump($order->debug());
        echo "<br>";
        foreach(get_class_methods($order) as $method){
            var_dump($method);
        }
        exit;
        
        $customer=Mage::getModel('customer/customer')->load('206793');
        var_dump($customer->debug(),get_class_methods($customer));

        echo 'ok';
      
    }
    public function getDataFromTxt(){
        $path=Mage::app()->getConfig()->getNode('global/auto/cms/datafolder');
        if($path){
            $path=Mage::getBaseDir().DS.$path.DS."block";
            if(is_dir($path)){
                $dir=dir($path);
                while(false!==($entry=$dir->read())){
                    if(!preg_match('/^\.{1,2}$/',$entry)){
                        $files[]=$path.DS.$entry;
                    }
                    
                }
                if(!empty($files)){
                    foreach($files as $file){
                        var_dump($file);
                        $data=trim(file_get_contents($file));
                        $data=json_decode($data,true);
                        $blocksData[]=$data;
                    }
                    var_dump($blocksData);
                }
            }
        }
    }
    public function shippingAction(){
        echo "nihao";
                $layout=Mage::app()->getLayout();
        echo $layout->createBlock("core/template", "shipping")
                ->setTemplate('martin/shipping/shippingtablerate.phtml')
                ->toHtml();
        
    }
    public function catAction(){
        try{
            $model=Mage::getModel('catalog/category');
            $cat=$model->load(125);

            $cat->setData('landing_page',150);
            $cat->save();
            var_dump($cat->getData());
        echo 'ok';exit;
        }catch(Exception $e){
            var_dump($e);exit;
        }
    }
}
