<?php
class Reg2_Decorator_TableRow extends Zend_Form_Decorator_Abstract
{
	    /**
     * Render a label
     *
     * @param  string $content
     * @return string
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

     	$label = trim($element->getLabel());
     	$class = $element->getAttrib('class');
     	if($class) {
     		$class = " class=\"$class\"";
     	} else {
     		$class = $element->isRequired()?" class=\"required\"": '';
     	}
     	
		return "<tr><td$class>$label:</td><td>".$content."</td></tr>\n";
	}
}

