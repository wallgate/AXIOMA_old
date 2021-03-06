<?php

class App_Form_Decorators
{
    public static function inputDecoratorsLogin()
    {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('Label', array('tag'=>'td', 'placement'=>'prepend')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }


    public static function inputDecorators()
    {
        return array(
            'ViewHelper',
            'Errors',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('InfoCell', array('tag'=>'td', 'placement'=>'prepend', 'wrapperClass'=>'col1')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }

    
    public static function checkboxDecorators()
    {
        return array(
            'ViewHelper',
            array('Label', array('placement'=>'append')),
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array(array('emptyCell'=>'HtmlTag'), array('tag'=>'td', 'placement'=>'prepend')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }


    public static function buttonDecorators()
    {
        return array(
            'ViewHelper',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'colspan'=>2, 'align'=>'center', 'class'=>'submitCell')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr'))
        );
    }


    public static function fileDecorators()
    {
        return array(
            'File',
            'Errors',
            array(array('tdTag'=>'HtmlTag'), array('tag'=>'td', 'valign'=>'top')),
            array('InfoCell', array('tag'=>'td', 'placement'=>'prepend', 'wrapperClass'=>'col1')),
            array(array('trTag'=>'HtmlTag'), array('tag'=>'tr', 'valign'=>'top'))
        );
    }


    public static function formDecorators()
    {
        return array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table', 'cellspacing'=>0)),
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