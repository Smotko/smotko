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
        $post_id = new Zend_Form_Element_Hidden('post_id');
        $user_id = new Zend_Form_Element_Hidden('user_id');
        $save = new Zend_Form_Element_Submit('submit');
        $save->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => ''))))
             ->setLabel('Dodaj');

        $this->addElements(array($userName, /*$password,*/ $userUrl, $description, $honeypot, /*$captcha,*/ $save, $id, $post_id));
        
        $user = Zend_Registry::get('User');
        if(is_array($user)){
            unset($user['id']);
            //$this->removeElement('captcha');
            if(!empty($user['password'])){
                

                $userName = $this->getElement('user_name');
                $userName->setAttrib('readonly', 'readonly');
            }
            else{
                $this->removeElement('user_url');
            }
            //$this->removeElement('password');
            $this->populate($user);
        }
        else{
            $this->removeElement('user_url');
        }
    }
}

