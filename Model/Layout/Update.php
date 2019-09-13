<?php

class Martin_Debug_Model_Layout_Update extends Mage_Core_Model_Layout_Update{
public function getFileLayoutUpdatesXml($area, $package, $theme, $storeId = null)
    {
	$debugInfoes=array();
        if (null === $storeId) {
            $storeId = Mage::app()->getStore()->getId();
        }
        /* @var $design Mage_Core_Model_Design_Package */
        $design = Mage::getSingleton('core/design_package');
        $layoutXml = null;
        $elementClass = $this->getElementClass();
        $updatesRoot = Mage::app()->getConfig()->getNode($area.'/layout/updates');
        Mage::dispatchEvent('core_layout_update_updates_get_after', array('updates' => $updatesRoot));
        $updates = $updatesRoot->asArray();
        $themeUpdates = Mage::getSingleton('core/design_config')->getNode("$area/$package/$theme/layout/updates");
        if ($themeUpdates && is_array($themeUpdates->asArray())) {
            //array_values() to ensure that theme-specific layouts don't override, but add to module layouts
            $updates = array_merge($updates, array_values($themeUpdates->asArray()));
        }
        $updateFiles = array();
        foreach ($updates as $updateNode) {
            if (!empty($updateNode['file'])) {
                $module = isset($updateNode['@']['module']) ? $updateNode['@']['module'] : false;
                if ($module && Mage::getStoreConfigFlag('advanced/modules_disable_output/' . $module, $storeId)) {
                    continue;
                }
                $updateFiles[] = $updateNode['file'];
            }
        }
        // custom local layout updates file - load always last
        $updateFiles[] = 'local.xml';
        $layoutStr = '';
	$timmer=0;
        foreach ($updateFiles as $file) {
	    $debugKey=$timmer++."_{$file}";
	    $debugInfoes[$debugKey]['layout File Name']=$file;
	    
            $filename = $design->getLayoutFilename($file, array(
                '_area'    => $area,
                '_package' => $package,
                '_theme'   => $theme
            ));
	     $debugInfoes[$debugKey]['layout File full path']=$filename;
	    $debugInfoes[$debugKey]['is layout File readable']="false";
            if (!is_readable($filename)) {
                continue;
            }
	    $debugInfoes[$debugKey]['is layoutFileName readable']="ture";
	    
            $fileStr = file_get_contents($filename);
            $fileStr = str_replace($this->_subst['from'], $this->_subst['to'], $fileStr);
            $fileXml = simplexml_load_string($fileStr, $elementClass);
	    
	    $debugInfoes[$debugKey]['successfully loading Data From File']="false";
            if (!$fileXml instanceof SimpleXMLElement) {
                continue;
            }
	    $debugInfoes[$debugKey]['successfully loading Data From File']="true";
            
            foreach($fileXml->children() as $child){
                foreach($child->children() as $grandChild){
                    $grandChild->addAttribute('filePath',$filename);
                } 
            }
            
            $layoutStr .= $fileXml->innerXml();
        }
	Mage::dispatchEvent("after_throughing_out_layout_files",array('debugInfoes'=>$debugInfoes));
        $layoutXml = simplexml_load_string('<layouts>'.$layoutStr.'</layouts>', $elementClass);
        return $layoutXml;
    }
}
