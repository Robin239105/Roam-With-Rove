
jQuery(document).ready(function($) {
    function calculate() {
        var days = parseFloat($('#days').val()) || 0;
        var rate = parseFloat($('#rate').val()) || 0;
        var fullService = $('#full-service').hasClass('active');
        var earnings = days * rate * 12;
        if(fullService) {
            earnings = earnings * 0.7;
        } else {
            earnings = earnings * 0.85;
        }
        $('#estimated-earnings').text('$' + earnings.toFixed(2) + '/Year');
    }

    $('.car-type-btn').click(function(){
        $('.car-type-btn').removeClass('active');
        $(this).addClass('active');
    });

    $('.plan-btn').click(function(){
        $('.plan-btn').removeClass('active');
        $(this).addClass('active');
        calculate();
    });

    $('#days, #rate').on('input', function() {
        calculate();
    });
});
