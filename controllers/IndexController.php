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
               
//               $attr=Mage::getModel('eav/entity_attribute')->loadByCode(9,'city_id');
//               var_dump($attr->getData());exit;
//               
//               $model=Mage::getModel('eav/entity_attribute');
//               $attribute=$model->loadByCode('warehouse','total_space');
//
//               var_dump($attribute->getData()) ;
//
//            $entityTypeCode='warehouse';
//            $action=new \Martin_EavAttribute\Action\ImportAttrsForEntityFromCfg($entityTypeCode);
//            $action->execute();

            echo __FILE__;
               
               exit;
               
               
               
               
               $collection=Mage::getModel('eav/entity_attribute')->getCollection()
                       ->addFieldToFilter('entity_type_id',9)
                       ->setOrder('sort_order',Varien_Data_Collection::SORT_ORDER_ASC);
               var_dump(get_class($collection));
               echo $collection->getSelect();
               foreach($collection as $item)
               {
                   var_dump($item->getData("attribute_code"),$item->getData("sort_order"));
                  // $item->delete();
               }
               
        } catch (Exception $ex) {
              var_dump($ex);
        }

        echo 'breakpoint';exit;
        
        
        
        
        try{
           try{

               
               
               
//               $entityTypeCode=\Martin_Warehouse_Model_Warehouse::ENTITY_TYPE_CODE;
//               
//               $action = new Martin_EavAttribute\Action\CreateEntityFormAttributeTable($entityTypeCode,true);
//               $action->undo();
//               
//                $action=new CreateBackendTypesTable($entityModelClass);
//                $action->undo();
//                
//               echo 'ok';
//               exit;
               
               
               
               $model=Mage::getModel('martindata/setup');
               $model->load('supplier_setup');
               var_dump($model->getId());

               echo 'breakpoint';exit;
               
               
               
               

                   
               
               
               
               
               $entityType=Mage::getModel('eav/entity_type')->loadByCode('warehouse');
               $entityType->setData('additional_attribute_table',Martin_Warehouse_Model_Warehouse::ADDITIONAL_ATTRIBUTE_TABLE);
               $entityType->save();
               exit;
               
               
               
               $action = new \Martin_Warehouse\Action\CreateTableAttributeAddition();
               $action->execute();
               
               
               echo 'ok';exit;
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
               
        $entityTypeId=Mage::getModel('eav/entity_type')->loadByCode(Martin_Supplier_Model_Supplier::ENTITY_TYPE_CODE)
                ->getId();
        $data=array(
                 'entity_type_id'=>$entityTypeId ,
                 'attribute_set_id'=>'0' ,
                 'website_id'=>'' ,
                 'email'=>'test@qq.com' ,
                 'store_id'=>'0' ,
                 'is_active'=>'1' ,
                 'company'=>'test Compony' ,
                 'password'=>'123456' ,
                 'confirmation'=>'123456',
                 'telephone'=>'18588764879' ,
         );
        $supplier=Mage::getModel('supplier/supplier');
        $supplier->setData($data);
        if(!Mage::helper('supplier')->isSupplierExisted($supplier))
        {
            $request=$this->getRequest();
            $request->setPost($data);
            $action = new Martin_Supplier\Action\AddSupplier($request);
            $action->execute(); 
        }else{
            return $supplier->getId();
        }
        echo 'ok';exit;
               
               
               
               
               
               
               
               
               
               
               $entityTypeId='10';
               $data=array(
                        'entity_type_id'=>$entityTypeId ,
                        'attribute_set_id'=>'0' ,
                        'website_id'=>'' ,
                        'email'=>'test2@qq.com' ,
                        'store_id'=>'0' ,
                        'is_active'=>'1' ,
                        'company'=>'test Compony' ,
                        'password'=>'123456' ,
                        'confirmation'=>'123456',
                        'telephone'=>'222' ,
                );
            $request=$this->getRequest();
            $request->setPost($data);
            $action = new Martin_Supplier\Action\AddSupplier($request);
            $action->execute();  exit;
//               
//               
            $model=Mage::getModel('supplier/supplier')->load(1);
            echo $this->_formatAsArrayString($model->getData());
            exit;
            
            
            

            $model=Mage::getModel('warehouse/warehouse')->load(7);
            var_dump($model->getData());
            $model->setData('supplier_id',1);
            $model->save();
            var_dump($model->getData());
            
            exit;
            
            
            
               

            
            echo 'ok'; exit;
               
               
               
               
               
               // Martin_Flexelooking_Block_Page_Header
               $block=$this->getLayout()->createBlock('page/html_header');
               var_dump($block->getLinks());exit;
               
               
               
               
               
               $group=Mage::getModel('core/store_group')->load(1);
               var_dump($group->getData());exit;
               
               $action = new \Martin_Initialization\Action\AddStores();
               $action->execute();              
               echo 'ok';
               
               
               $store=Mage::getModel('core/store')->load(1);
               var_dump($store->getData());exit;
        
        
        
        
               $banner=Mage::getModel('cms/block')->load('banner-wms-about-us','identifier');       
               var_dump($banner->getData());exit;
               
               
               $this->loadLayout();
               $rootBlock=$this->getLayout()->getBlock('root');
               $rootBlock->setTemplate('flexelooking/page/2columns-left.phtml');
               echo $rootBlock->toHtml();
               var_dump($rootBlock->getTemplateFile(),get_class_methods($rootBlock));exit;
               
               
               
               
               
               $action=new Martin_Cms\Action\UpdateCmsMenuItems();
               $action->execute();
               
               echo 'ok';exit;
               
               
               
               
               $helper=Mage::helper('martincms');
               $file=$helper->getHtmlFile('staticBlockContent','cms_menu');
               
               var_dump($file);exit;
               
               
               
//               $dir=Mage::getModuleDir('', 'Martin_Cms');
//               $dir.=DS.'PagesContent';
//
//               $identifier='about-us';
//               $file=$dir.DS.$identifier.'.phtml';
//              
//               echo file_get_contents($file);  exit;
               
               
//               $cfg=Mage::app()->getConfig()->getNode('cmsAutoImprt/pages');
//               foreach($cfg->asArray() as $pageData)
//               {
//                   $pageItem=new Varien_Object($pageData);
//                   var_dump($pageItem->getData());
//               }
//               var_dump($cfg->asArray());exit;
               
//               
//                $page=Mage::getModel('cms/page')->load(3);
//                var_dump($page->getData()); 
//                
//                $page=Mage::getModel('cms/page')->load(12);
//                var_dump($page->getData());exit;
//               

           } catch (Exception $ex) {
                var_dump($ex);
           }

           exit;
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            $action = new \Martin_Warehouse\Action\InitializationTablesForWarehouse();
            $action->execute();
            
            $action = new \Martin_Supplier\Action\InitializationTablesForSupplier();
            $action->execute();
            
            exit;           
            
            
            
            
            
            
            
            
            
            Mage::getConfig()->saveConfig('design/head/demonotice', 0); exit;

            
            
            
            
           $page= Mage::getModel('cms/page')->load('home','identifier');
            var_dump($page->getData());exit;
            
            $model=Mage::getModel('cms/page');
            $pages=$model->getCollection();
            var_dump(count($pages),get_class_methods($model));
            foreach($pages as $page)
            {
               var_dump($page->getData()) ;
            }
            exit;
            
            
            
            
            
            
            
            
            
            
            
            $city=Mage::getModel('warehouse/warehouse')->load('warehouse_1','name');
            var_dump($city->getData());exit;
            
            $warehouse=Mage::getModel('warehouse/warehouse')->load(18);
            echo $this->_formatAsArrayString($warehouse->getData(),"<br>"); exit;
            
            
            
            $model=Mage::getModel('eav/entity_type')->loadByCode('supplier2');
            
            
            var_dump($model->getData());exit;
            $data=
                array(
                    'entity_type_code'             => 'supplier2',
                    'entity_model'             => 'supplier2/supplier2',
                    'attribute_model'             => 'supplier2/attribute2',
                    'entity_table'             => 'supplier/entity',
                    'value_table_prefix'             => NULL,
                    'entity_id_field'             => NULL,
                    'is_data_sharing'             => 1,
                    'data_sharing_key'             => 'default',
                    'default_attribute_set_id'             => 1,
                    'increment_model'             => 'eav/entity_increment_numeric',
                    'increment_per_store'             => 0,
                    'increment_pad_length'             => 8,
                    'increment_pad_char'             => '0',
                    'additional_attribute_table'             => '',
                    'entity_attribute_collection'             => 'supplier/attribute_collection',
                );
            
            $model=Mage::getModel('eav/entity_type');
            $model->setData($data);
            $model->save();
            var_dump($model->getId());exit;
            
            
            
            
            
            $supplier=Mage::getModel('supplier/supplier')->load(18);
            var_dump($supplier->getData());exit;
            
            
            
            
            
            
            
            
            
            
            
            
          $entityType=  Mage::getModel('eav/entity_type')->loadByCode('supplier');
        $attributesInfo = Mage::getResourceModel($entityType->getEntityAttributeCollection());
       //  $attributesInfo   ->setEntityTypeFilter($entityType);
          $attributesInfo  ->getData();
        
        $collection=Mage::getResourceModel($entityType->getEntityAttributeCollection());
        var_dump(get_class($collection));
        echo $collection->getSelect();
            var_dump(count($attributesInfo));exit;
            
        $attributeCodes = Mage::getSingleton('eav/config');
          $attributeCodes  ->getEntityAttributeCodes('supplier');
var_dump('aiyou',$attributeCodes);exit;
            exit;
            
           $model=Mage::getModel('supplier/supplier')->load(7);
           var_dump($model->getEntityTypeId());exit;

           $test= Mage::helper('eavAttribute/entityType')->getEnitytResrouceIDField('warehouse');
           var_dump($test);exit;
            
            
            
            $class='supplier/supplier';
           // $class='warehouse/warehouse';
            $model=Mage::getModel($class);
            var_dump($model->getResource()->getIdFieldName());EXIT;
        
        
            $attrCode='longitude';
            $entity=Mage::getModel('warehouse/warehouse')->load(11);
            
            var_dump($entity->getData());exit;
            
            $attribute=Mage::getModel('eav/entity_attribute')->loadByCode('warehouse',$attrCode);

            
            $attribute->setEntity($entity);
            
            $handler=Mage::helper('warehouse/attribute')->getHandler($attribute);
            $handler->process();
            
            var_dump($entity->getData(),$attrCode,$entity->getData($attrCode));exit;
            
            
//            $attrs=Mage::getModel('warehouse/warehouse')->load(1)->getResource()->getAttributesByCode();
//            var_dump($attrs);exit;
//        $entityTypeId=Mage::getModel('eav/entity_type')->loadByCode('warehouse')->getEntityTypeId();
//        $cities=Mage::getModel('warehouse/city')->getCollection();
//        foreach($cities as $city)
//        {
//            $wrhs=array(
//                'name'=>'test'.$city->getId(),
//                'city_id'=>$city->getId(),
//                'entity_type_id'=>$entityTypeId,
//            );
//            Mage::getModel('warehouse/warehouse')->setData($wrhs)
//                    ->save();
//            
//        }

        
        
        
        
        var_dump($warehouses);
            
            
//             $collection=Mage::getModel('warehouse/warehouse')->getCollection();
//             foreach($collection as $item)
//             {
//                 echo $this->_formatAsArrayString($item,"<br>");
//             }
        } catch (Exception $ex) {
            var_dump($ex);
        }
        echo 'ok';exit;

         
//        $cfg=Mage::app()->getConfig()->getNode('initCities');
//        var_dump($cfg->asArray());exit;
        
        
        
        
        
//        $collection=Mage::getModel('warehouse/city')->getCollection();
//        foreach($collection as $item)
//        {
//           // var_dump($item->getData());
//            echo $this->_formatAsArrayString($item->getData(),'<br>'),"<br>";
//        }
//        exit;




        
        
        
        try{
            $entityTypeCode='warehouse';
            $warehouseId=2;
        $result=Mage::helper("eavAttribute/form")->getElesAndEntityData($entityTypeCode,$warehouseId);
        $else=$result['eles'];
        $invisibleItems=array('city_id');
        if($invisibleItems)
        {
            array_walk($else, function(&$item,$key) use($invisibleItems){
                if(in_array($key,$invisibleItems))
                {
                    $item['toHide']=true;
                }
            });
        }
        
        var_dump($else);exit;
            
            
            
            
            
            
            
            
            
            
            
            
            
                $customer=Mage::getModel('customer/customer')->load(24);
           // $address=Mage::getModel('customer/address')->load(18);
            foreach($customer->getAddresses() as $address)
            {
                var_dump($address->getData());
            }
            exit;
            
            
            
            
            
            
            
            
            
            
            
            $quote=Mage::getSingleton('checkout/session')->getQuote();
            
            $allItems=$quote->getAllItems();
            
            foreach( $quote->getAllAddresses() as $address)
            {
                foreach($address->getAllNonNominalItems()  as $item)
                {
                    var_dump($item->getResource()->getMainTable(),$item->getData());
                }
            }
//            var_dump($quote->getId());
//            foreach($allItems as $item)
//            {
//                 var_dump($item->getData());    
//            }
            exit;
            var_dump($quote->getId(),get_class_methods($quote),'breakpoint');exit;
            
            
            
            
            
            
            
            $sessionModel=Mage::getSingleton('supplier/session');
            
            $sessionModel->logout();exit;
            
            $login=$sessionModel->login('test@qq.com','123456');
            var_dump($login);
            $data=Mage::getResourceModel('core/session')->read('3jfdj9vu3dbfjtd6lc9h7k09b3');
            $data2=Mage::getResourceModel('core/session')->read('gdktv5rr5ee23ti2rvnu0hdf77');
            echo $data ,"<hr>",$data2;
            $debug=true;
            exit;
            
            
            
            
            
            
            
            $supplier=Mage::getModel('supplier/supplier');
            $customerEmail='test@qq.com';
            $model=$supplier->loadByEmailOrPhone($customerEmail );
            var_dump($model->getData());exit;
            
            
            
            
            $model=Mage::getModel('customer/attribute')->load(12);
            var_dump($model->getData());exit;
        //    $collection=Mage::getResourceModel('supplier/form_attribute_collection');


            
            
            
            $form=Mage::getModel('supplier/form');
            $form->setFormCode('supplier_account_create');
            $form->setEntity(Mage::getModel('supplier/supplier'));
            $form->validateData(array()); 
            
            var_dump('breakpoint');
            exit;
            
            
            
            $attribute=Mage::getModel('customer/attribute');
            $dataModel = Mage_Eav_Model_Attribute_Data::factory($attribute, Mage::getModel('customer/customer'));
            var_dump($dataModel);exit;

            
            
            
            
            
            
             $model=Mage::getModel('customer/customer');
             var_dump(get_class_methods($model));exit;
            
            
            
            $addAttr=new \Martin_Supplier\Action\AddAttributesForSupplier();
            $addAttr->execute();exit;
            
//            $model=Mage::getModel('eav/entity_type')->loadByCode('supplier');
//            var_dump($model->getData(),$model->getEntityTypeId(),get_class_methods($model));exit;
            
            
            
            
            
            
            
            $supplier=Mage::getModel('supplier/supplier');
            $supplier->load(4);
        
            var_dump($supplier->getData()); exit;
//            foreach($supplier->getResource()->getAttributesByCode() as $attrCode=>$attribute)
//            {
//                if('firstname'==$attrCode)
//                {
//                    var_dump($attrCode,$attribute->getData());exit;
//                }
//                
//            }
//            
//            exit;
            
            
            //var_dump($supplier->getResource());exit;
            $supplier=Mage::getModel('supplier/supplier');
            $data=array(
                'name_cpny'=>"itwo",
            );
            $supplier->setData($data);
            $supplier->save();
            var_dump($supplier->getId());
        } catch (Exception $ex) {
            var_dump($ex);
        }
        exit;

        
        
        
        
//       $resourceCustomer=Mage::getResourceModel('supplier/supplier');
//       var_dump(get_class_methods($resourceCustomer));
//       $resourceCustomer->loadAllAttributes();
//       var_dump($resourceCustomer->getDefaultAttributes());
       
       var_dump("haha====by code",array_keys($resourceCustomer->getAttributesByCode()));
//       var_dump("haha====by id",$resourceCustomer->getAttributesById());
//       var_dump("haha====by table",$resourceCustomer->getAttributesByTable());
       exit;

        
        
        try{
          $resourceModelClassType='supplier/attribute_collection'; //$entityType->getEntityAttributeCollection()
          $attributeSetId=0;
          $entityType=9;
          $storeId=1;
         $resourceModel = Mage::getResourceModel($resourceModelClassType);
         var_dump(get_class($resourceModel));
         $resourceModel       ->setEntityTypeFilter($entityType)
                ->setAttributeSetFilter($attributeSetId)
                ->addStoreLabel($storeId);
         echo $resourceModel->getSelect();
          var_dump($resourceModel    ->getData())  ;
        } catch (Exception $ex) {
                var_dump($ex);
        }


        exit;
//        
//        
//        
//        
//        
//        
//        
//        
//        
//        
////        $object=  new Varien_Object();
////        $attributeCodes = Mage::getSingleton('eav/config')
////            ->getEntityAttributeCodes("supplier", $object);
////        var_dump($attributeCodes);exit;
        
        
        $supplier=Mage::getModel('supplier/supplier');
        $supplier->load(1);
        var_dump($supplier->getData()) ;
        
                $supplier=Mage::getModel('customer/customer');
        $supplier->load(24);
        var_dump($supplier->getData()) ;exit;
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        var_dump(Mage::getResourceModel('supplier/eav_attribute'));exit;
       
//       $data=array(
//           "attribute_code"=>'company',
//           "frontend_input"=>"text",
//           "default_value_text"=>"",
//           "frontend_label"=>array('Company'),
//       );
       $data=array(
           "attribute_code"=>'company',
           "frontend_input"=>"text",
           "default_value_text"=>"",
           "frontend_label"=>array('Company'),
       );
       $attrResourceModel=Mage::getResourceModel("supplier/eav_attribute");

       

       $addNewAttrAct= new Martin_Supplier\Action\AddNewSupplierAttrEntity($data);
       try{
           $addNewAttrAct->execute();
       } catch (Exception $ex) {
          var_dump($ex->getMessage());
       }
       

       echo 'breakpoint';exit;
        $validator=new \Martin_EavAttribute\Validation\Required();
        var_dump($validator->isValid());exit;
        
        
        $config=Mage::getConfig()->getNode('martin_eav_attribute/attr_options');
        var_dump(get_class_methods($config));
        
        foreach($config->asArray() as $item)
        {
            $class=($item['validations']['required']);
            var_dump(new $class());
        }
        exit;
        

        
        
        $model = Mage::getModel('catalog/resource_eav_attribute');
        var_dump($model);exit;
        
        $prodModel=Mage::getModel('catalog/product');
        $cfgProdCollection=$prodModel ->getCollection();
        //$cfgProdCollection->addFieldToFilter('image',array("notnull"=>'haha') );
        //
        //$cfgProdCollection->addFieldToFilter('image',array("notnull"=>'/m/s/msj000t_1.jpg') );
       //  $cfgProdCollection->addFieldToFilter('image',array("notnull"=>'/m/s/msj000t_1.jpg') );
         $cfgProdCollection->addFieldToFilter('sku ',array("in"=>array('simple-2','awerw','shw003','Pwt005')) );
         echo "select sql:<br>" ,  $cfgProdCollection->getSelect(),"<br>";
         var_dump($cfgProdCollection->getSelect());
         
          exit;
        var_dump(count($cfgProdCollection)); echo "<br>"; exit;
        
        
       // Mage_Catalog_Block_Product_View_Media
        $layout=$this->getLayout();
        $block=$layout->createBlock('catalog/product_view_media');
        
       $product = Mage::getModel('catalog/product')->load(904);
       $data=$product->getMediaGalleryImages();
       //$data=$product->getMediaGallery('images');
       var_dump($data,$product->getData());exit;
        
        
        
        
        
        
        $categoryId=70;
        $storeId=2;
        $data=Mage::getResourceModel('merchandiser/merchandiser')->getCategoryValues($categoryId,$storeId);
        
        var_dump($data);exit;
        
        try{
            $adapter=Mage::getSingleton('core/resource')->getConnection('core_write');
            $adapter->beginTransaction(); 
            $newStore=Mage::getModel('core/store');
            var_dump(count($newStore->getCollection()));
            var_dump(count(Mage::getModel('core/store')->getCollection()));
            foreach(Mage::getModel('core/store')->getCollection() as $store)
            {
                var_dump($store->getData());
            }
            $storeData=array(
                "code"=>'test',
                'website_id'=>1,
                'name'=>'test',
                'is_active'=>1
            );
            $newStore->setData($storeData);
            $newStore->save();
            echo "<br>";
            var_dump(count(Mage::getModel('core/store')->getCollection()));
            foreach(Mage::getModel('core/store')->getCollection() as $store)
            {
                var_dump($store->getData());
            }
            $adapter->rollBack();
            echo "<br>";
            var_dump(count(Mage::getModel('core/store')->getCollection()));
            foreach(Mage::getModel('core/store')->getCollection() as $store)
            {
                var_dump($store->getData());
            }
        } catch (Exception $ex) {
            var_dump($ex);
        }

              

        exit;
        $emlTpltFilter=new Mage_Core_Model_Email_Template_Filter();
        $dataObj=new Varien_Object();
        $martin=new Varien_Object();
        $martin->setData('email','547249121@qq.com');
        $dataObj->setData(array('email-to'=>"martin","person"=>$martin));    
        $emlTpltFilter->setVariables(array(
                    'store'=>Mage::app()->getStore(),
                    'data'=>$dataObj,
                ));
        $tpl="{{var store.getFrontendName()}}";
        
        $tpl="{{var data.email-to}}";
        
        $tpl="{{var data.person.email}}";
        echo $emlTpltFilter->filter($tpl);exit;
        echo 'ok';exit;
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
