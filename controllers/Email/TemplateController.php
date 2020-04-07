<?php
class Martin_Debug_Email_TemplateController extends Mage_Core_Controller_Front_Action{
    public function testAction()
    {
//        $fileName="haha";
//        $mailTemplate = Mage::getModel('core/email_template');
//        $currentStoreId = Mage::app()->getStore()->getId();
//        $sendor="info@toolots.com";
//        $templateId='toolots_sales_report';
//        $to="547249121@qq.com";
//
//        $mailTemplate->setDesignConfig(array('area' => 'backend'))
//            ->sendTransactional(
//                $templateId,
//                $sendor,
//                $to,
//                null,
//                array('fileName' => $fileName),
//                $currentStoreId
//            );
        echo "ok";
    }

    public function defaultTemplatesAction()
    {

//        $path='customer/password/forgot_email_template';
//        $templateId=Mage::getStoreConfig($path, 1);
//        $localeCode = Mage::getStoreConfig('general/locale/code', 1);
//
//        $defaultTemplates=Mage_Core_Model_Email_Template::getDefaultTemplates();
//        var_dump($templateId,$localeCode,$defaultTemplates);
//
//        exit;

        $defaultTemplates=Mage::getConfig()->getNode(Mage_Core_Model_Email_Template::XML_PATH_TEMPLATE_EMAIL)->asArray();
        var_dump($defaultTemplates);exit;
    }


    public function sendEmailAction()
    {
        //Toolots_Strategy_Model_SecondHand_Email_CreationNotification
        $email=Mage::getModel('strategy/secondHand_Email_CreationNotification');
        $from=array('email'=>"toolots@example.com","name"=>"toolots");
        $to=array(array('email'=>"test@example.com","name"=>"guest"));
        $email->send($from,$to);
    }

    public function indexAction()
    {

        $templateParams=array();
        $storeId=1;
//        $templateId=Mage::getStoreConfig($templateConfigPath, $storeId);
//        $sender=Mage::getStoreConfig($senderConfigPath, $storeId);
        $templateId="admin_emails_forgot_email_template";
        $sender=array("email"=>"toolots@example.com", "name"=>"toolots");


        $to="547249121@qq.com";
        $toName="MMM";
        $to2="test@example.com";
        $toName2="MT";

        /** @var $mailer Mage_Core_Model_Email_Template_Mailer */
        $mailer = Mage::getModel('core/email_template_mailer');
        $emailInfo = Mage::getModel('core/email_info');
        $emailInfo->addTo($to, $toName);

        $emailInfo->addTo($to2, $toName2);

        $mailer->addEmailInfo($emailInfo);

        // Set all required params and send emails
        $mailer->setSender($sender);
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams($templateParams);
        $mailer->send();
    }
}