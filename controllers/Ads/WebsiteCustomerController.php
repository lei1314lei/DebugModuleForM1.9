<?php
class Martin_Debug_Ads_WebsiteCustomerController extends Mage_Core_Controller_Front_Action{
    const CONTRIES_CODE=[
        'ad','ae','af','ag','ai','al','am','an','ao','aq','ar','as','at','au','aw','az','ba','bb','bd','be','bf','bg','bh','bi','bj','bm','bn','bo','br','bs','bt','bv','bw','by','bz','ca','cc','cf','cg','ch','ci','ck','cl','cm','cn','co','cr','cs','cu','cv','cx','cy','cz','de','dj','dk','dm','do','dz','ec','ee','eg','eh','es','et','fi','fj','fk','fm','fo','fr','fx','ga','gb','gd','ge','gf','gh','gi','gl','gm','gn','gp','gq','gr','gs','gt','gu','gw','gy','hk','hm','hn','hr','ht','hu','id','ie','il','in','io','iq','ir','is','it','jm','jo','jp','ke','kg','kh','ki','km','kn','kp','kr','kw','ky','kz','la','lb','lc','li','lk','lr','ls','lt','lu','lv','ly','ma','mc','md','mg','mh','mk','ml','mm','mn','mo','mp','mq','mr','ms','mt','mu','mv','mw','mx','my','mz','na','nc','ne','nf','ng','ni','nl','no','np','nr','nt','nu','nz','om','pa','pe','pf','pg','ph','pk','pl','pm','pn','pr','pt','pw','py','qa','re','ro','ru','rw','sa','sb','sc','sd','se','sg','sh','si','sj','sk','sl','sm','sn','so','sr','st','su','sv','sy','sz','tc','td','tf','tg','th','tj','tk','tm','tn','to','tp','tr','tt','tv','tw','tz','ua','ug','uk','um','us','uy','uz','va','vc','ve','vg','vi','vn','vu','wf','ws','ye','yt','yu','za','zm','zr','zw'
    ];

    public function indexAction()
    {
//        var_dump(preg_match('/[,]/','PDF,'));exit;
//        $ordersAddress = Mage::getModel('sales/order_address')->getCollection();
        $adaption = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "select * from tmp_forGoogleAdsCustomerList";
        $result = $adaption->query($sql);

        $customerList = $this->_processResource($result->fetchAll());

        $this->_processByGoogleRules($customerList);
        echo 'OK';

    }

    protected function _processResource($items)
    {
        $data = array();
        foreach($items as $item)
        {
            $data[]=new Varien_Object($item);
        }

        foreach($data as $itemData) {
            $invalidMsg = '';
            $email = $itemData->getEmail();
            $phone = $itemData->getData('telephone');
            $firstName = $itemData->getData('firstname');
            $lastName = $itemData->getData('lastname');
            $country = $itemData->getData('country_id');
            $zip = $itemData->getData('postcode');

            $key = "$firstName|$lastName|$country";
            if (!isset($customerList[$key])) {
                $customerList[$key] = [
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'country' => $country,
                ];
                $customerList[$key]['emails'] = array();
                $customerList[$key]['zips'] = array();
                $customerList[$key]['phones'] = array();
            }

            if ($email) {
                $customerList[$key]['emails'][$email] = '';
            }
            if ($zip) {
                $customerList[$key]['zips'][$zip] = '';
            }
            if ($phone) {
                $customerList[$key]['phones'][$phone] = '';
            }
        }
        return $customerList;
    }

    protected function _handleName($name)
    {
        $msg='';
        if('N/A'==$name){
            $msg="Seems like there isn't last name($name)";
        }elseif(preg_match('/[,]/',$name)){
            $msg="Last name contain unexpected letter($name)";
        }
        if($msg)
        {
           throw new Exception($msg) ;
        }
    }
    protected function _handleFirstName(&$firsname)
    {
        $firsname=trim($firsname);
        if(preg_match('/^(Mr\.|Ms.)/i',$firsname))
        {
            $invalidMsg =",Invalid first name($firsname)";
            throw new Exception($invalidMsg);
        }
        $this->_handleName($firsname);
    }
    protected function _handleLastName(&$lastname)
    {
        $lastname=trim($lastname);
        $msg = '';
        if(preg_match('/\.$/i',$lastname))
        {
            $msg ="Last name contains suffixes($lastname)";
        }
        if($msg)
        {
            throw new Exception($msg);
        }
        $this->_handleName($lastname);
    }
    protected function _handleZip($countryCode,&$zip)
    {
        $zip = trim($zip);
        $invalidMsg='';
        if($countryCode=='us')
        {
            if(!preg_match('/^\d{5}$/',$zip)
                && !preg_match('/^\d{5}-\d{4}$/',$zip))
            {
                $invalidMsg .=",invalid zip($zip)";
            }
        }else{
            $invalidMsg .="Failed to handle zip,Unexpected Country For Toolots By Now($countryCode)";
        }
        if($invalidMsg)
        {
            throw new Exception($invalidMsg);
        }
    }
    protected function _handleEmail(&$email)
    {
        $msg='';
        $email = trim($email);
        if(!preg_match('/^.+?@.+$/',$email))
        {
            $msg="Invalid Email($email)";
        }elseif(strpos(' ',$email))
        {
            $msg="Email contains space($email)";
        }
        if($msg)
        {
            throw new Exception("Failed to handle Email,$msg");
        }
    }
    protected function _handlePhone($countryCode,&$phone)
    {
        $msg='';
        if($countryCode=='us') {
            if ($phone) {
                if(preg_match('/^[\d\s-\(\)]+$/',$phone))
                {
                    $phone = '1 ' . $phone;
                }else{
                    $msg="Unexpected phone factor";
                }
            }
        }else{
            $msg="Unexpected Country For Toolots By Now($countryCode)";
        }
        if($msg)
        {
            throw new Exception("Failed to handle phone,$msg");
        }
    }
    protected function _handleCountry(&$country)
    {
        $country = strtolower($country);
        if(!in_array($country,self::CONTRIES_CODE))
        {
             throw new Exception("Invalid country code ($country)");
        }
    }
    protected function _processByGoogleRules($customerList)
    {
        $dir = Mage::getBaseDir('var');
        $invalidLogs=$dir.DS.'google_ads_website_customer_invalid_ones.log';
        $customerListFile = $dir.DS.'google_ads_website_customer.csv';
        $tooMuchContactsLogs=$dir.DS.'google_ads_website_customer_too_much_contact_info.log';
        $fileContent = "Email,First Name,Last Name,Country,Zip,Email,Zip,Phone,Phone\r\n";
        $invalidContent = "";
        $tooMuchContactInfo='';

        foreach($customerList as  $key => $customer)
        {
            $firstName= $customer['firstname'];
            $lastName=$customer['lastname'];
            $country= $customer['country'];
            $emails  = array_keys($customer['emails']);
            $zips = array_keys($customer['zips']);
            $phones = array_keys($customer['phones']);

            list($email_1,$email_2) = $emails;
            list($zip_1,$zip_2) = $zips;
            list($phone_1,$phone_2) = $phones;
//            if(empty($phones))
//            {
//                $invalidContent .= "Without phone".json_encode($customer)."\r\n";
//                continue;
//            }

            try {
                $this->_handleFirstName($firstName);
                $this->_handleLastName($lastName);
                $this->_handleCountry($country);
                $this->_handleEmail($email_1);
                $this->_handleZip($country,$zip_1);
                $this->_handlePhone($country,$phone_1);
                if($email_2)
                {
                    $this->_handleEmail($email_2);
                }
                if($zip_2)
                {
                    $this->_handleZip($country,$zip_2);
                }
                if($phone_2)
                {
                    $this->_handlePhone($country,$phone_2);
                }

                $fileContent .= "$email_1,\"$firstName\",\"$lastName\",$country,$zip_1,$email_2,$zip_2,$phone_1,$phone_2"."\r\n";
            }catch(Exception $e) {
                $invalidContent .= $e->getMessage().".".json_encode($customer)."\r\n";
            }

            if(count($emails)>2 || count($zips)>2 || count($phones)>2)
            {
                $tooMuchContactInfo.="$key\r\n";
            }

        }

        if($invalidContent){
            if(false===file_put_contents($invalidLogs,$invalidContent))
            {
                die("failed to write data into $invalidLogs");
            }
        }

        if(false === file_put_contents($customerListFile,$fileContent))
        {
            die("failed write data into $customerListFile" );
        }

        if($tooMuchContactInfo)
        {
            if(false === file_put_contents($tooMuchContactsLogs,$tooMuchContactInfo)  )
            {
                die("failed write data into $tooMuchContactsLogs");
            }
        }

    }

}
