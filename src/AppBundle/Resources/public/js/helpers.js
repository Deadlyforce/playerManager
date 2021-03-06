// HELPERS

/**
 * Datatables plugin pour ordre des colonnes avec dates à des formats spéciaux 
 * Exemple: dd-mm-YYYY
 */
if (typeof $.fn.dataTable !== 'undefined') {
   $.fn.dataTable.moment = function ( format, locale ) {
        var types = $.fn.dataTable.ext.type;

        // Add type detection
        types.detect.unshift( function ( d ) {
            return moment( d, format, locale, true ).isValid() ?
                'moment-'+format :
                null;
        } );

        // Add sorting method - use an integer for the sorting
        types.order[ 'moment-'+format+'-pre' ] = function ( d ) {
            return moment( d, format, locale, true ).unix();
        };
    };
}

function getDatepicker()
{
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy', 
        showSecond: false,
        controlType: 'select',
        oneLine: true,
        changeYear: true
    });
}

function getDatetimepicker()
{
    $(".datetimepicker").datetimepicker({ 
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm',
        hourText: 'Hours',
        timeText: 'Time',
        minuteText: 'Minutes',
        showSecond: false,
        controlType: 'slider',
        oneLine: true,
        stepMinute: 5
    });
}



