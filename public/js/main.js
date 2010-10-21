$(function()
{
    $('ul.navigation ul').slideUp(0);

    $('ul.navigation > li').hoverIntent(function() {
        $('ul', this).slideDown(200);
    }, function() {
        $('ul', this).slideUp(200);
    })
})