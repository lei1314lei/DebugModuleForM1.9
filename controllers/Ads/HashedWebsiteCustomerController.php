<?php
class Martin_Debug_Ads_HashedWebsiteCustomerController extends Mage_Core_Controller_Front_Action{
    const CONTRIES_CODE=[
        'ad','ae','af','ag','ai','al','am','an','ao','aq','ar','as','at','au','aw','az','ba','bb','bd','be','bf','bg','bh','bi','bj','bm','bn','bo','br','bs','bt','bv','bw','by','bz','ca','cc','cf','cg','ch','ci','ck','cl','cm','cn','co','cr','cs','cu','cv','cx','cy','cz','de','dj','dk','dm','do','dz','ec','ee','eg','eh','es','et','fi','fj','fk','fm','fo','fr','fx','ga','gb','gd','ge','gf','gh','gi','gl','gm','gn','gp','gq','gr','gs','gt','gu','gw','gy','hk','hm','hn','hr','ht','hu','id','ie','il','in','io','iq','ir','is','it','jm','jo','jp','ke','kg','kh','ki','km','kn','kp','kr','kw','ky','kz','la','lb','lc','li','lk','lr','ls','lt','lu','lv','ly','ma','mc','md','mg','mh','mk','ml','mm','mn','mo','mp','mq','mr','ms','mt','mu','mv','mw','mx','my','mz','na','nc','ne','nf','ng','ni','nl','no','np','nr','nt','nu','nz','om','pa','pe','pf','pg','ph','pk','pl','pm','pn','pr','pt','pw','py','qa','re','ro','ru','rw','sa','sb','sc','sd','se','sg','sh','si','sj','sk','sl','sm','sn','so','sr','st','su','sv','sy','sz','tc','td','tf','tg','th','tj','tk','tm','tn','to','tp','tr','tt','tv','tw','tz','ua','ug','uk','um','us','uy','uz','va','vc','ve','vg','vi','vn','vu','wf','ws','ye','yt','yu','za','zm','zr','zw'
    ];

    public function indexAction()
    {
//        $customer = Mage::getModel('customer/customer')->load(3);
//        $address = $customer->getPrimaryBillingAddress();
//        var_dump($address->getData());exit;
//        $addresses = $customer->getAddressCollection();
//        foreach($addresses as $address)
//        {
//            var_dump($address->getData());exit;
//        }
//        var_dump(get_class_methods());exit;
//        $customers = Mage::getModel('customer/customer')->getCollection();
//        foreach($customers as $customer)
//        {
//            var_dump(get_class_methods($customer));exit;
//        }

//        var_dump(preg_match('/[,]/','PDF,'));exit;
//        $ordersAddress = Mage::getModel('sales/order_address')->getCollection();
        $adaption = Mage::getSingleton('core/resource')->getConnection('core_read');
        $sql = "select * from tmp_forGoogleAdsCustomerList";
        $result = $adaption->query($sql);

        $customerList = $this->_processResource($result->fetchAll());

        $this->_processByGoogleRules($customerList);
        echo 'OK';

    }
    protected function _toBeHashedData(&$data)
    {
        if($data)
        {
            $data = hash('sha256',$data) ;
        }
    }

    protected function _formatEmail(&$email)
    {
         $email = strtolower(trim($email));
    }
    protected function _formatPhoneWithCountryCode(&$phoneWithCountryCode)
    {
        if($phoneWithCountryCode)
        {
            $phoneWithCountryCode = str_replace(array('(',')','-',' '),'',$phoneWithCountryCode);
            $phoneWithCountryCode = '+'.$phoneWithCountryCode;
        }
    }
    protected function _formatFirstName(&$firstName)
    {
        $firstName=str_replace(array('Ms.','Mrs.','Mr.','Dr.'),'',$firstName) ;
        $firstName = mb_convert_case($firstName,MB_CASE_LOWER,'UTF-8');
        $firstName = trim($firstName);
    }
    protected function _formatLastName(&$lastName)
    {
        $lastName = str_replace(['Jr.','Sr.','2nd','III','II','IV','CPA','MD','PhD'],'',$lastName);
        $lastName = mb_convert_case($lastName,MB_CASE_LOWER,'UTF-8');
        $lastName = trim($lastName);
    }
    protected function _formatCountry(&$country)
    {
       $country = strtolower($country) ;
    }
    protected function _formatZip(&$zip)
    {
        $zip = strtolower($zip);
        $zip = str_replace([' '],'',$zip);
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

    protected function _validateName($name)
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
    protected function _validateFirstName(&$firsname)
    {
        $this->_validateName($firsname);
    }
    protected function _validateLastName(&$lastname)
    {
        $this->_validateName($lastname);
    }
    protected function _validateZip($countryCode,&$zip)
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
            $invalidMsg .="Failed to validate zip,Unexpected Country For Toolots By Now($countryCode)";
        }
        if($invalidMsg)
        {
            throw new Exception($invalidMsg);
        }
    }
    protected function _validateEmail(&$email)
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
            throw new Exception("Failed to validate Email,$msg");
        }
    }
    protected function _validatePhone($countryCode,&$phone)
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
            throw new Exception("Failed to validate phone,$msg");
        }
    }
    protected function _validateCountry(&$country)
    {
        $country = strtolower($country);
        if(!in_array($country,self::CONTRIES_CODE))
        {
            throw new Exception("Invalid country code ($country)");
        }
    }
    protected function _processByGoogleRules($customerList)
    {
        $dir = Mage::getBaseDir('var').DS.'hashed';
        if(!is_dir($dir))
        {
           mkdir($dir) ;
        }
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

            try {
                $this->_validateFirstName($firstName);
                $this->_validateLastName($lastName);
                $this->_validateCountry($country);
                $this->_validateEmail($email_1);
                $this->_validateZip($country,$zip_1);
                $this->_validatePhone($country,$phone_1);
                if($email_2)
                {
                    $this->_validateEmail($email_2);
                }
                if($zip_2)
                {
                    $this->_validateZip($country,$zip_2);
                }
                if($phone_2)
                {
                    $this->_validatePhone($country,$phone_2);
                }


                $this->_formatFirstName($firstName);
                $this->_formatLastName($lastName);
                $this->_formatEmail($email_1);
                $this->_formatEmail($email_2);
                $this->_formatPhoneWithCountryCode($phone_1);
                $this->_formatPhoneWithCountryCode($phone_2);
                $this->_formatZip($zip_1);
                $this->_formatZip($zip_2);

                $this->_toBeHashedData($email_1);
                $this->_toBeHashedData($email_2);
                $this->_toBeHashedData($phone_1);
                $this->_toBeHashedData($phone_2);
                $this->_toBeHashedData($firstName);
                $this->_toBeHashedData($lastName);


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

    protected function _testFormatAndHash()
    {

        $unformatted = ['wc2h 8lg','WC2H8LG','  wc2h8lg  '];
        foreach($unformatted as $item)
        {
            $this->_formatZip($item);
            echo $item,"<br>";
        }

        echo "<hr>";

        foreach($unformatted as $item)
        {
            $this->_formatZip($item);
            $this->_toBeHashedData($item);
            echo $item,"<br>";
        }

        exit;
        $unformatted = ['DOE','DOÉ','Doe Jr.','Doe Sr.','Doe 2nd','Doe II','Doe III','Doe IV','Doe CPA','Doe MD','Doe PhD','  doe  ','  Doe Jr.  '];
        foreach($unformatted as $item)
        {
            $this->_formatLastName($item);
            echo $item,"<br>";
        }

        echo "<hr>";

        foreach($unformatted as $item)
        {
            $this->_formatLastName($item);
            $this->_toBeHashedData($item);
            echo $item,"<br>";
        }

        exit;

        $unformatted = ['JANE','JÁNE','Ms. Jane','Mrs. Jane','Mr. Jane','Dr. Jane','  jane  ','  Dr. Jane  '];
        foreach($unformatted as $item)
        {
            $this->_formatFirstName($item);
            echo $item,"<br>";
        }

        echo "<hr>";

        foreach($unformatted as $item)
        {
            $this->_formatFirstName($item);
            $this->_toBeHashedData($item);
            echo $item,"<br>";
        }

        exit;
        $unformatted = ['12223334444','1 222 333 4444','1-222-333-4444','1 (222) 333 4444','1-(222)-333-4444','12223334444'];
        foreach($unformatted as $item)
        {
            $this->_formatPhoneWithCountryCode($item);
            echo $item,"<br>";
        }

        echo "<hr>";

        foreach($unformatted as $item)
        {
            $this->_formatPhoneWithCountryCode($item);
            $this->_toBeHashedData($item);
            echo $item,"<br>";
        }

        exit;
        $unformatted = ['JohnDoe@gmail.com','JohnDoe@mail.google.com','   johndoe@gmail.com  '];
        foreach($unformatted as $item)
        {
            $this->_formatEmail($item);
            echo $item,"<br>";
        }

        echo "<hr>";

        foreach($unformatted as $item)
        {
            $this->_formatEmail($item);
            $this->_toBeHashedData($item);
            echo $item,"<br>";
        }

        exit;
    }
}
