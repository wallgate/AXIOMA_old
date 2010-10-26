$(function()
{
    $('ul.navigation ul').slideUp(0);

    $('ul.navigation > li').hoverIntent(function() {
        $('ul', this).slideDown(200);
    }, function() {
        $('ul', this).slideUp(200);
    })


    $('.stripedTable tr:even').addClass('alt');


/*---------------------- окошки с запросом подтверждения ---------------------*/

    $('a.delete').click(function()
    {
        $('div.confirm').dialog({title: 'Удалить запись?'})
                        .children('a.yes')
                        .attr('href', $(this).attr('href'));
        return false;
    })

    $('div.confirm a.no').click(function()
    {
        $('div.confirm').dialog('close');
        return false;
    })


/*---------------------------------- вкладки ---------------------------------*/

    function showTab(index)
    {
        $('.dispayGroup').fadeOut(0)
                         .eq(index)
                         .fadeIn(200);
    }

    showTab(0);
    $('a.tabSwitcher').click(function()
    {
        var index = $('a.tabSwitcher').index(this);
        if ($('.dispayGroup').eq(index).is(':visible'))
            return false;
        showTab(index);
        return false;
    })


/*--------------------------------- календарь --------------------------------*/

    if ($('.datePicker').size())
    {
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: 'назад',
            nextText: 'вперёд',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            weekHeader: 'Не',
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['ru']);
        $(".datePicker").datepicker({"changeYear" : true});
    }


/*-------------------------------- маски ввода -------------------------------*/

    if ($(".cellphone").size())
        $(".cellphone").mask("8-999-999-9999");
    if ($(".homephone").size())
        $(".homephone").mask("(9999) 99-99-99");
})