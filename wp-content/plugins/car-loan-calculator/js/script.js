
jQuery(document).ready(function($) {
    $('#calculate-btn').on('click', function() {
        var price = parseFloat($('#vehicle-price').val()) || 0;
        var down = parseFloat($('#down-payment').val()) || 0;
        var trade = parseFloat($('#trade-in').val()) || 0;
        var rate = parseFloat($('#interest-rate').val()) || 0;
        var term = parseInt($('#loan-term').val()) || 0;

        var principal = price - down - trade;
        var monthlyRate = rate / (12 * 100);

        if (monthlyRate === 0) {
            var monthlyPayment = principal / term;
        } else {
            var monthlyPayment = (principal * monthlyRate * Math.pow(1 + monthlyRate, term)) / (Math.pow(1 + monthlyRate, term) - 1);
        }

        var totalPayment = monthlyPayment * term;
        var totalInterest = totalPayment - principal;

        $('#monthly-payment').text('Monthly Payment: $' + monthlyPayment.toFixed(2));
        $('#total-loan').text('Total Loan Amount: $' + principal.toFixed(2));
        $('#total-interest').text('Total Interest Paid: $' + totalInterest.toFixed(2));
        $('#total-payment').text('Total Payment: $' + totalPayment.toFixed(2));
    });
});
