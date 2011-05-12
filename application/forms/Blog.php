<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_Blog extends Zend_Form
{
    public function init(){

        $this->setName('blog');
        $this->setAction('/admin/blog/add');

        //Categories:
        $cat = Doctrine_Query::create()
                    ->select()
                    ->from('Model_Categories c')
                    ->fetchArray();
        
        
       
        $categories = new Zend_Form_Element_MultiCheckbox('categories');
        $categories->setLabel('Kategorije:')
                   ->setSeparator(' ');

        foreach($cat as $c){
            $categories->addMultiOption($c['id'], $c['name']);
        }

        $id = new Zend_Form_Element_Hidden('id');
        $title = new Zend_Form_Element_Text('title');
        $title->setLabel('Blog title:');
        $description = new Zend_Form_Element_Textarea('excerpt');
        $description->setLabel('Blog description:')
                    ->setAttrib('rows', '2');
        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Blog text:')
                ->setAttrib('id', 'blog_content')
                    ->setAttrib('rows', '10')
                ->setAttrib('class', 'editor');

        $style = new Zend_Form_Element_Textarea('style');
        $style->setLabel('Custom css:')
                 ->setAttrib('rows', '5')
                 //->setAttrib('cols', '95')
                ;
        
        $save = new Zend_Form_Element_Submit('submit');
        $save->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));
        $reset = new Zend_Form_Element_Reset('reset');
        $reset->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));
        $this->addElement($categories);
        $this->addElements(array($title, $description, $content, $style, $save, $reset, $id));
        
                
        
        //Zend_Debug::dump($grp->getDecorator('DtDdWrapper'));die;
        //$grp->clearDecorators();
        

        
    }
}

