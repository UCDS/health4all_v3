// for id update_patients, age_years, age_months, age_days
$().ready(function () {
    
    $('form[id="update_patients"]').validate({
        rules: {
            age_years: {
                range: [0, 200],
                digits: true
            },
            age_months: {
                range: [0, 11],
                digits: true
            },
            age_days: {
                range: [0, 31],
                digits: true
            }
        },
        ignore: ".date_custom",
        submitHandler: function (form) {
            form.submit();
        }
    });
});

// doctor_id, arrival_mode