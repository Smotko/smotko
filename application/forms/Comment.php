<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_Comment extends Zend_Form
{
    public function init(){

        $this->setName('debate');
        $this->setAction('/debate/add');
        $id = new Zend_Form_Element_Hidden('id');

        $userName = new Zend_Form_Element_Text('user_name');
        $userName->setLabel('Ime:')
                 ->setRequired();

        $userEmail = new Zend_Form_Element_Text('user_email');
        $userEmail->setLabel('E-Mail:')
                  ->setValidators(array('EmailAddress'))
                  ->setRequired();
        
        $userUrl = new Zend_Form_Element_Text('user_url');
        $userUrl->setLabel('Spletna stran:')
                ->addValidator(new Smotko_Validate_Url());
        
        $markdown = new Zend_Form_Element_Checkbox('markdown');
        $markdown->addDecorator('label', array('placement' => 'append'))
                 ->setLabel('Markdown');
        
        $description = new Zend_Form_Element_Textarea('content');
        $description->setLabel('Sporočilo:')
                    ->setAttrib('id', 'debate_text')
                    ->setAttrib('rows', '4')
                    ->setRequired()
                    ->removeDecorator('label');

        //$password = new Zend_Form_Element_Password('password');
        //$password->setLabel('Geslo (ni obvezno):');
        
        $honeypot = new Zend_Form_Element_Textarea('content-longr');
        $honeypot->removeDecorator('label')
                 ->setAttrib('id', 'content-longr');

        /*
        $validate = new Zend_Validate_Between(2, 2);
        $validate->setMessage('1 + 1 = 2...');
        $captcha = new Zend_Form_Element_Text('captcha');
        $captcha->setLabel('Koliko je 1 + 1?')
                ->addValidator($validate)
                ->setRequired();
        */

        $publickey = '6LdR-b4SAAAAAFW4myd5XzdwY3WmpN4oIwhIx2CF';
        $privatekey = '6LdR-b4SAAAAAPS6TbND3WCpwlDOI0SxH2QLYwPB';
        $recaptcha = new Zend_Service_ReCaptcha($publickey, $privatekey);
        $captcha = new Zend_Form_Element_Captcha('captcha', array(
                    'label' => "Prepričaj me, da si človek:",
                    'captcha'  => 'ReCaptcha',
                    'captchaOptions' => array('captcha' => 'ReCaptcha', 'service' => $recaptcha),
                     'ignore' => true
                    
                    ));
        $sloCaptcha = new Zend_Form_Element_Text('slo_captcha');
        $sloCaptcha->setLabel('Napiši vse tri šumnike slovenske abecede');
        $post_id = new Zend_Form_Element_Hidden('post_id');
        $user_id = new Zend_Form_Element_Hidden('user_id');
        $save = new Zend_Form_Element_Submit('submit');
        $save->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => ''))))
             ->setLabel('Dodaj');

        $this->addElements(array($userName, /*$password,*/ $userUrl, $markdown, $description, $honeypot, $sloCaptcha, /*$captcha,*/ $save, $id, $post_id));
        
        $user = Zend_Registry::get('User');
        if(is_array($user)){
            unset($user['id']);
            $this->removeElement('slo_captcha');
            if(!empty($user['password'])){
                

                $userName = $this->getElement('user_name');
                $userName->setAttrib('readonly', 'readonly');
            }
            else{
                $this->removeElement('user_url');
                $this->removeElement('markdown');
            }
            //$this->removeElement('password');
            $this->populate($user);
        }
        else{
            $this->removeElement('user_url');
            $this->removeElement('markdown');
        }
    }
    
    public function setPnp(){
    	
    	$this->removeElement('user_url');
    	if($this->getElement('captcha'))
    	$this->getElement('captcha')->setAttrib('style', 'width:40px;')
    	->setOptions(array('captcha' => array('captcha' => 'Figlet','wordLen' => 2)));
    	if($this->getElement('password'))
    	$this->getElement('password')->setAttrib ('style', 'width:60px;');
    	$this->getElement('submit')->setAttrib('style', 'width: 60px');
    	
    	$this->setAction('/pnp/add');
    	
    	$todayPnp = Model_Pnp::getPnpOnDate(date('Y-m-d'));
    	if(!$todayPnp)
    	{
    		$dateElement = new Zend_Form_Element_Hidden('date');
    		$date = new Zend_Date();
    	
    		$dateElement->setValue($date->toString(Zend_Date::DATE_MEDIUM));
    		$this->addElement($dateElement);
    	}
    	$this->setIdSuffix('pnp');
    	return $this;
    }
    
    public function isValid($data){
    	if(array_key_exists('slo_captcha', $data)){
	        $cap = strtolower($data['slo_captcha']);
	        if(!(strstr($cap,'č') && strstr($cap, 'š') && strstr($cap, 'ž'))){
	            return false;
	        }
    	}
        return parent::isValid($data);
    }
    
    public function setIdSuffix($suffix)
    {
    	$formId = $this->getId();
    	if (0 < strlen($formId)) {
    		$this->setAttrib('id', $formId . '_' . $suffix);
    	}
    	
    	// elements
    	$elements = $this->getElements();
    	foreach ($elements as $element) {
    		$element->setAttrib('id', $element->getId() . '_' . $suffix);
    	}
    	
    	return $this;
    }

}

