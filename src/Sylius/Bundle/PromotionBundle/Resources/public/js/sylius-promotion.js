/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ($) {
    'use strict';

    var methods = {
        init: function(options) {
            var settings = $.extend({
              'prototypePrefix': false
            }, options);

            return this.each(function() {
                show($(this), false);
                $(this).change(function() {
                    show($(this), true);
                });

                function show(element, replace) {
                    var id = element.attr('id');
                    var selectedValue = element.val();
                    var prototypePrefix = id;
                    if (false !== settings.prototypePrefix) {
                        prototypePrefix = settings.prototypePrefix;
                    }

                    var form = element.closest('div.control-group').parent();
                    var container = form.next();
                    var count = form.parents(':eq(1)').children().length - 1;
                    var prototype = $('#' + prototypePrefix + '_' + selectedValue)
                        .data('prototype')
                        .replace(/\[__name__\]/g, '[' + prototypePrefix + '][' + count + '][configuration]')
                        .replace(/__name__/g, count)
                    ;

                    if (replace) {
                        if (form.children().length > 1) {
                            form.children().last().remove();
                        }
                        container.html(prototype);
                    } else if (form.children().length <= 1) {
                        container.html(prototype);
                    }
                }
            });
        }
    };

    $.fn.handlePrototypes = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.handlePrototypes' );
        }
    };

    $.fn.getFormFields = function(type) {
        this.change(function() {
            var $form = $(this).closest('form'),
                data  = {},
                name  = $(this).attr('name');

            data[name] = $(this).val();

            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: data,
                success: function(html) {
                    // updates CSRF token just in case
                    var $token = $('#sylius_promotion__token', $(html)).val();
                    $('#sylius_promotion__token').val($token);

                    var $oldDiv = $('#sylius_promotion_' + type).children('div').has('select[name="' + name + '"]').next('div');
                    var $newDiv = $('#sylius_promotion_' + type, $(html)).children('div').has('select[name="' + name + '"]').next('div');

                    $oldDiv.replaceWith($newDiv);
                }
            });
        });
    }

    $(document).ready(function() {
        $('select[name^="sylius_promotion[rules]"][name$="[type]"]').livequery(function() {
            $(this).handlePrototypes({prototypePrefix: 'rules'});
            $(this).getFormFields('rules');
        });
        $('select[name^="sylius_promotion[actions]"][name$="[type]"]').livequery(function() {
            $(this).handlePrototypes({prototypePrefix: 'actions'});
            $(this).getFormFields('actions');
        });
    });
})(jQuery);
