<?php

class Xtwocn_Debug_EavController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        try{

            $warehouse=Mage::getModel('warehouse/warehouse');
            $resourceModel=$warehouse->getResource();

            $warehouse->load(12);
            var_dump($warehouse->getData());
        } catch (Exception $ex) {
            var_dump($ex);
        }
        exit;
        
        $warehouse=Mage::getModel('warehouse/warehouse');
        $warehouse->setData(
                    array(
                    'name'=>'test',
                    'city_id'=>'2',
                    'test_warehouse_attribute'=>'haha',
                    )
                );
        
        try{
            $warehouse->save();
            var_dump($warehouse->getId());
        } catch (Exception $ex) {
            var_dump($ex);
        }
        exit;
        
        
        
        
        $model=Mage::getModel('eav/entity_type')->loadByCode('warehouse');
//        $clct=$model->getAttributeCollection();
//        echo $clct->getSelect(), '<hr>';  
//        
//        $clct=$model->getEntityAttributeCollection();
//        var_dump($clct);
//        echo $clct->getSelect();
//        exit;
        
        
        
        
        var_dump(get_class_methods($model));
    }
    public function attributeAction()
    {
        $object=  new Varien_Object();
        $attributeCodes = Mage::getSingleton('eav/config')
            ->getEntityAttributeCodes("supplier", $object);
        var_dump($attributeCodes);exit;
        
        $model=Mage::getModel('customer/attribute')->load(150);
        var_dump($model->getData());exit;
    }
    
    public function supplierAction()
    {
                try{
            
            $datas=array(
                array(
                    'entity_type_id' => '9',
                    'attribute_code' => 'tel_cpny',
                    'attribute_model' => '',
                    'backend_model' => '',
                    'backend_type' => 'varchar',
                    'backend_table' => '',
                    'frontend_model' => '',
                    'frontend_input' => 'text',
                    'frontend_label' => 'Tel Number',
                    'frontend_class' => '',
                    'source_model' => '',
                    'is_required' => '',
                    'is_user_defined' => '',
                    'default_value' => '',
                    'is_unique' => '',
                    'note' => '',
                    'scope_website_id' => '',
                    'scope_is_visible' => '',
                    'scope_is_required' => '1',
                    'scope_default_value' => '',
                    'scope_multiline_count' => '',
                    'is_visible' => '',
                    'input_filter' => '',
                    'multiline_count' => '',
                    'validate_rules' => '',
                    'is_system' => '',
                    'sort_order' => '',
                    'data_model' => '',
                    'is_used_for_customer_segment' => '',
                ),
                array(
                    'entity_type_id' => '9',
                    'attribute_code' => 'name_cpny',
                    'attribute_model' => '',
                    'backend_model' => '',
                    'backend_type' => 'varchar',
                    'backend_table' => '',
                    'frontend_model' => '',
                    'frontend_input' => 'text',
                    'frontend_label' => 'Company',
                    'frontend_class' => '',
                    'source_model' => '',
                    'is_required' => '',
                    'is_user_defined' => '',
                    'default_value' => '',
                    'is_unique' => '',
                    'note' => '',
                    'scope_website_id' => '',
                    'scope_is_visible' => '',
                    'scope_is_required' => '1',
                    'scope_default_value' => '',
                    'scope_multiline_count' => '',
                    'is_visible' => '',
                    'input_filter' => '',
                    'multiline_count' => '',
                    'validate_rules' => '',
                    'is_system' => '',
                    'sort_order' => '',
                    'data_model' => '',
                    'is_used_for_customer_segment' => '',
                )
            );

            foreach($datas as $data)
            {
                $model=Mage::getModel('supplier/attribute');
                $model->setData($data);
                $model->save();
            }

        } catch (Exception $ex) {
            var_dump($ex);
        }
        exit;
    }
}

