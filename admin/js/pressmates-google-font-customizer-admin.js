( function ( $ ) {
    'use strict';

    function retreive_font_weight( font_type ) {

        var font_selector = $( '#customize-control-' + font_type + '_font_family select' ),
            font_selected = font_selector.val(),
            weight_select;

        if ( 'default' !== font_selected ) {

            $.ajax({
                type: 'POST',
                url: js_vars.admin_url,
                dataType: 'json',
                data: {
                    action: 'pressmates_google_font_weight',
                    selected_font: font_selected
                },
                success: function( response ) {

                    var result = eval( response ),
                        select_options = '';

                    for ( var index in result ) {

                        var selected_weight                = '',
                            google_font_weight = js_vars.google_font_weight;

                        switch ( font_type ) {
                            case 'google_font_weight' :
                                if ( result[index] == google_font_weight ) {
                                    selected_weight = 'selected="selected"';
                                }
                                break;
                            default :
                                selected_weight = '';
                        }

                        select_options += '<option value="' + result[index] + '" ' + selected_weight + '>' + result[index] + '</option>';
                    }

                    weight_select = $( '#customize-control-' + font_type + '_font_weight select' );
                    weight_select.empty();
                    weight_select.append( select_options );

                }

            });

        } else {
            weight_select = $('#customize-control-' + font_type + '_font_weight select');
            weight_select.empty();
            weight_select.append('<option value="default">' + js_vars.default_text + '</option>');
        }

    }

    $(window).load(function () {

        /**
         * On load set selected font family and weight
         */
        retreive_font_weight( 'google_font_weight' );

        /**
         * Select font and generate weight for it
         */
        var google_font_weight   = $( '#customize-control-pressmates_google_font_family select' );

        google_font_weight.on( 'change', function () {
            console.log("test");
            retreive_font_weight( 'pressmates_google' );
        });

    }); // End Document Ready

})(jQuery);