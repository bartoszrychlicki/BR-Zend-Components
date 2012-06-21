# BR (Bartosz Rychlicki) Zend Components

This is a growing library of quality components build during some commercial projects.

## Br_Controller_Action_Helper_LimitChars
This Action Helper together with little JavaScript plugin by Jan Jarfalk called "Limit"
is the solution for displaying how much characters left for user to type into form input element until he will reach
set limit by default \Zend_Validate_StringLength validator (exactly it's max option).
Plugin will setup a description field next to Your element that will update dynamically as user types characters in field.

It's very easy to use.
### Example ###
Remember to register namespace of the plugin inside Your bootstrap like so:

<code>
Zend_Controller_Action_HelperBroker::addPrefix('Br_Controller_Action_Helper_');
</code>

And then, inside of action just invoke the plugin like so:

<code>
$this->_helper->LimitChars(array(
  $form->getElement('about'),
  $form->getElement('equipment'),
), $this->view);
</code>

First argument is array of the \Zend_Form_Elements You want to initialize the plugin on,
second argument is currently used view (for appending JavaScript).

### Remember ###

* Helper will overwrite description field on Your element if You have defined them.
* You need to have headScript helper invoked in Your view to add necessary JavaScript file

