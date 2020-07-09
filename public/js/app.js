$(document).ready(function () {
    // Alert Sliding
    $('div.alert').not('.alert-important').delay(5000).slideUp(300);

    // Datepicker 
    flatpickr('.flatpickr', {});

    // Datepicker - range
    flatpickr('.range', {
        mode: "range"
    });

    // DateTimePicker
    flatpickr('.datetimepicker', {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });

    flatpickr('.timepicker', {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        minTime: "07:00",
        maxTime: "18:00",
    });

});
