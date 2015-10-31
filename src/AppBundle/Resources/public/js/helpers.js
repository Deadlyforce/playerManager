// HELPERS

function getDatepicker()
{
    $(".datepicker").datepicker({
        dateFormat: 'dd-mm-yy', 
        showSecond: false,
        controlType: 'select',
        oneLine: true
    });
}

function getDatetimepicker()
{
    $(".datetimepicker").datetimepicker({ 
        dateFormat: 'dd-mm-yy',
        timeFormat: 'HH:mm:ss',
        hourText: 'Heures',
        timeText: 'Horaire',
        minuteText: 'Minutes',
        showSecond: false,
        controlType: 'select',
        oneLine: true
    });
}



