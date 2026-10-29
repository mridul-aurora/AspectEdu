(function($) {
    "use strict";

    function syncTimeToAll() {
        if ($('#copy').is(':checked')) {
            let firstVal = $('#first_item').val();
            if (firstVal !== undefined && firstVal !== null) {
                $('.time').not('#first_item').each(function() {
                    $(this).val(firstVal);
                    let dtp = $(this).data('DateTimePicker');
                    if (dtp && firstVal) {
                        try {
                            dtp.date(moment(firstVal, 'LT'));
                        } catch (e) {
                            // ignore moment parse error
                        }
                    }
                });
            }
        }
    }

    $(document).ready(function() {
        $(document).on('change', '#copy', function() {
            if ($(this).is(':checked')) {
                syncTimeToAll();
            }
        });

        $(document).on('dp.change change input keyup paste', '#first_item', function() {
            syncTimeToAll();
        });
    });
})(jQuery);
