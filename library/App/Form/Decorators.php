<?php

class App_Form_Decorators
{
    public static function inputDecorators()
    {
        return array(
            'ViewHelper',
            'Errors',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('InfoCell', array('tag'=>'td', 'placement'=>'prepend', 'wrapperClass'=>'col1')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr'))
        );
    }


    public static function buttonDecorators()
    {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'colspan'=>2, 'align'=>'center')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr'))
        );
    }


    public static function formDecorators()
    {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table')),
            'Form'
        );
    }


    public static function displayGroupDecorators()
    {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table', 'class'=>'displayGroup')),
        );
    }

}