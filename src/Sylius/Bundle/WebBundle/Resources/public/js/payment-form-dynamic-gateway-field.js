jQuery(document).ready(function() {
    var updateGateway = function() {
        var method   = $('#sylius_payment_method option:selected').text(),
            $gateway = $('#sylius_payment_gateway');

        if (method == 'Credit Card') {
            $gateway.removeAttr('disabled');
        }
        else {
            $gateway.val('');
            $gateway.attr('disabled', 'disabled')
        }
    };

    updateGateway();
    $('#sylius_payment_method').change(updateGateway);
});