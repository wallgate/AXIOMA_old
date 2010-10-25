<?php

class App_Form_Decorator_InfoCell extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        $label       = $this->getElement()->getLabel();
        $description = $this->getElement()->getDescription();
        $required    = $this->getElement()->isRequired();

        if ($required) $label .= ' <span class="asterisk">*</span>';
        
        $infoCell    = $label . '<br/><small class="description">' . $description . '</small>';
        
        $placement   = $this->getPlacement();
        $htmlTag     = $this->getOption('tag');
        $tagClass    = $this->getOption('wrapperClass');

        if (!empty($htmlTag))
        {
            if (!empty($tagClass)) $class = ' class="'.$tagClass.'"';
            $infoCell = sprintf('<%s%s>%s</%s>', $htmlTag, $class, $infoCell, $htmlTag);
        }

        return $placement=='append'
            ? $content . $infoCell
            : $infoCell . $content;
    }
}