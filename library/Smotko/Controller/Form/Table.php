<?php
/**
 * Description of Smotko_Form
 * Creates form elements from the database table
 * @author smotko
 */
class Smotko_Form_Table extends Zend_Form {

    private $_timeFields = array();
    private $_dateFields = array();

    public function setOptions(array $options){
         
        
        if (isset($options['tableName'])) {
            
            $this->addTable($options['tableName']);
            unset($options['tableName']);
        }
        parent::setOptions($options);
        
    }

    public function addTable($tableName){

        $translate = Zend_Registry::get('Zend_Translate');
        
        $names = array();

        //Load config:
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);

        //Load db:
        $db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params);
        
        //Get table info:
        $tableInfo = $db->describeTable($tableName);

        //Prepare form elements:
        foreach($tableInfo as $column => $settings){

            $elementName = $tableName . '_' . $settings['COLUMN_NAME'];
            
            switch($settings['DATA_TYPE']){
                case 'int':
                    if($settings['PRIMARY'] || substr($settings['COLUMN_NAME'], 0, 3) == 'id_'){
                        $element = new Zend_Form_Element_Hidden($elementName);
                        $element->setDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd'))));
                    }
                    else{
                        $element = new Zend_Form_Element_Text($elementName);
                    }
                    $element->addValidator(new Zend_Validate_Int());                    
                    break;
                case 'text':
                case 'longtext':
                    $element = new Zend_Form_Element_Textarea($elementName);
                    break;
                case 'varchar':
                    $element = new Zend_Form_Element_Text($elementName);
                    $element->addValidator('StringLength', false, array(0, $settings['LENGTH']));


                    break;
                case 'tinyint':
                    $element = new Zend_Form_Element_Checkbox($elementName);
                    break;
                case 'date':
                    array_push($this->_dateFields, $elementName);
                    //TODO CREATE ELEMENT DATE:
                    $element = new Zend_Form_Element_Text($elementName);
                    break;
                case 'timestamp':
                    array_push($this->_timeFields, $elementName);
                    //TODO CREATE ELEMENT DATETIME
                    $element = new Zend_Form_Element_Text($elementName);
                    break;
                default:
                    $element = new Zend_Form_Element_Text($elementName);
                    
            }
            if($settings['DEFAULT']){
                if($settings['DEFAULT'] == 'CURRENT_TIMESTAMP')
                    switch($settings['DATA_TYPE']){
                        case 'date':
                            $element->setValue(date("d. m. Y"));
                            break;
                        case 'time':
                            $element->setValue(date("H:i:s"));
                            break;
                        case 'timestamp':
                            $element->setValue(date("d. m. Y H:i:s"));
                            break;
                    }
                else
                    $element->setValue($settings['DEFAULT']);
            }
            
            $element->setLabel(ucfirst($translate->translate($settings['COLUMN_NAME'])) . ': ');
            $this->addElement($element);

            array_push($names, $elementName);
            

        }
        //Add submit and clear button:
        $element = new Zend_Form_Element_Submit($tableName . 'submit');
        $element->setLabel(ucfirst($translate->translate('submit')));
        $this->addElement($element);


        array_push($names, $tableName . 'submit');

        $element = new Zend_Form_Element_Reset($tableName . 'reset');
        $element->setLabel(ucfirst($translate->translate('submit')));
        $element->setDecorators(array('ViewHelper', array('HtmlTag', array('tag' => 'dd'))));
        $this->addElement($element);
        array_push($names, $tableName . 'reset');
        $element->setLabel(ucfirst($translate->translate('reset')));
        $this->setDecorators(array('FormElements', 'Form'));

        
        $this->addDisplayGroup($names, $tableName);
        $disp = $this->getDisplayGroup($tableName);
        $disp->setLegend(ucfirst($translate->translate($tableName)));
        $disp->setDecorators(array('FormElements', array('HtmlTag', array('tag'=>'dl', 'id' => $tableName . '_form', 'class'=> 'smotko_form')), 'Fieldset'));
                
    }
    public function isDate($elementName){
        
        return in_array($elementName, $this->_dateFields);
    }
    public function isTime($elementName){

        return in_array($elementName, $this->_timeFields);
    }
}
