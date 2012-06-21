<?php
/**
 * Based on JavaScript Jquery plugin by Jan Jarfalk "Limit"
 * This helper sets up a character limit on a form field (input, textarea etc.)
 * based on a option "max" on validator StringLenght attached to a form element.
 * Also includes a proper JavaScript to handle dynamic input changes.
 *
 * @see http://unwrongest.com/projects/limit/ "Limit" plugin documentation
 * @author Bartosz Rychlicki <bartosz.rychlicki@gmail.com>
 * @version 1.0
 * @example
 * $this->_helper->LimitChars(array(
 *   $form->getElement('about'),
 *   $form->getElement('equipment'),
 *   ), $this->view);
 */
class Br_Controller_Action_Helper_LimitChars extends \Zend_Controller_Action_Helper_Abstract {

    /**
     * @var bool
     */
    protected static $_jsIncluded = false;

    /**
     * @param array $elements Array of Zend_Form_Element
     * @param Zend_View_Interface $view
     * @throws InvalidArgumentException
     */
    public function direct(array $elements, \Zend_View_Interface $view)
    {
        // checking if JS is included, if not, we will include it in the view
        if(self::$_jsIncluded === false) {
            $view->headScript()->appendFile('/js/jquery.limit-1.2.source.js');
            self::$_jsIncluded = true;
        }
        $scriptToInclude = "";
        foreach($elements as $element) {
            if($element instanceof \Zend_Form_Element) {
                if(!$validator = $element->getValidator('StringLength'))
                    throw new \InvalidArgumentException('Element '.$element->getName(). 'does not have attached StringLenght validator');
                $elementId = $element->getName();
                $limit = $validator->getMax();
                if(!$limit > 0) {
                    throw new \InvalidArgumentException('Validator StringLength for element '.$element->getName(). 'does not have "max" option bigger than 0');
                }
                $element->getDecorator("description")->setEscape(false);
                $element->setDescription($view->translate(
                    vsprintf("You have <span id=\"$elementId-charsLeft\"></span> chars left.", array($limit)))
                );
                $scriptToInclude .= "$('#$elementId').limit('$limit','#$elementId-charsLeft');";
            } else {
                throw new \InvalidArgumentException('All elements in $element argument are not instance of \Zend_Form_Element');
            }
        }
        $view->headScript()->appendScript("
            $(document).ready(function(){
                $scriptToInclude
            });
        ");
    }
}