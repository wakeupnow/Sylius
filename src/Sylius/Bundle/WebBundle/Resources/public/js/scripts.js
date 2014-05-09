$(document).ready(function () {

    // Checks for IE7 and older and displays message to update browser
    jQuery.browser={};(function(){jQuery.browser.msie=false;
    jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)\./)){
    jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
    if ($.browser.msie && $.browser.version < 8) {
        $('body').append(
            '<div class="browser-message ">' +
                '<h2>Did you know that your Internet Explorer is out of date?</h2>' +
                '<p>To get the best possible experience using our website, we recommend that you upgrade<br />to a newer version of Internet Explorer or other browser. Here are some options:</p>' +
                '<a href="https://www.google.com/intl/en/chrome/browser/" target="_blank">Google Chrome</a><br />' +
                '<a href="http://www.mozilla.org/en-US/firefox/new/" target="_blank">Firefox</a><br />' +
                '<a href="http://support.apple.com/downloads/#safari" target="_blank">Safari</a><br />' +
                '<a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie" target="_blank">Internet Explorer</a><br />' +
                '</div>'
        );
    };


    // Fade in dropdown menus
    $(document).on('mouseover', '.open-dropdown', function (){
        $(this).find('.dropdown').stop().fadeIn(100);
    });
    $(document).on('mouseout', '.open-dropdown', function (){
        $(this).find('.dropdown').stop().fadeOut(100);
    });

    // Open Bottom Menu
    $(document).on('click', '.open-console', function(){
        var t = $(this),
            userConsole = $('.console');

        if (userConsole.hasClass('open') && t.hasClass('selected')){
            userConsole.removeClass('open');
            t.removeClass('selected');
            userConsole.slideUp();
        }
        else {
            $('.open-console').removeClass('selected');
            t.addClass('selected');

            if(t.hasClass('bttn-profile')){
                userConsole.find('.console-dashboard').hide();
                userConsole.find('.console-profile').show();
            }
            else {
                userConsole.find('.console-profile').hide();
                userConsole.find('.console-dashboard').show();
            }
            userConsole.addClass('open');
            userConsole.slideDown();
        }

    });

    // Detect and override tap event on product to first open hover state
    $(document).on('touchstart', '.tap-detect', function(e){
        var tapProduct = $(this).closest('.product');

        if(!tapProduct.hasClass('tapped')){
            e.preventDefault();
            tapProduct.addClass('tapped');
        }
    });

    // Open/Close Moblie Nav
    $(document).on('click', '.menu-mobile', function(){
        $('.nav-mobile').slideToggle();
    });

    // Open Mobile Sub Nav
    $(document).on('click', '.mobile-open-dropdown', function(){
        var t = $(this);

        if (t.hasClass('open')){
            t.removeClass('open');
            t.next('.mobile-submenu').slideUp();
        }
        else {
            $('.mobile-open-dropdown').removeClass('open');
            $('.mobile-submenu').slideUp();
            t.addClass('open');
            t.next('.mobile-submenu').slideDown();
        }

    });

    // Scrolls to top of page
    $(document).on('click', '.scrollTop', function(){
        $('html, body').animate({scrollTop: 0});
    });


    // Open Product Modal
    $(document).on('click', '.expand-arrow', function () {
        $('.modal-product').fadeIn();
    });
    $(document).on('click', '.add-cart', function () {
        $('.modal-added').fadeIn();
    });
    $(document).on('click', '.modal-close', function(){
        $(this).closest('.modal').fadeOut();
    });

    $(document).on('click', '#add-new-shipping-address', function(){
     $('.shipping-address').show();
     return false;
    });

    $(document).on('click', '#add-new-billing-address', function(){
     $('.billing-address').show();
     return false;
    });

    $(document).on('change', '.payment-method-info', function(){
     $('div.payment-info').hide();
     if($(this).is(':checked')){
        $('.'+$(this).data('payinfo')).show();
     }
     return false;
    });

    $(document).on('click', 'button#checkout-use-new-card', function(){
     $('div.payment-info').hide();
     $('div.new-payment').show();
     return false;
    });
    
});	// END WINDOW READY