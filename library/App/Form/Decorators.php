<?php

class App_Form_Decorators
{
    public static function inputDecorators()
    {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td')),
            array('Label', array('tag'=>'td','placement'=>'prepend')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr')),
        );
    }

    public static function buttonDecorators()
    {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'colspan'=>2, 'align'=>'center')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr')),
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
}