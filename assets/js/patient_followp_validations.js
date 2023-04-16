 $().ready(function () {

    $('form[id="followup_patient"]').validate({
        rules: {
            status_date: {
               required: true,
            },
            status: {
                required: true,
            },
            last_visit_type: {
                required: true,
            },
            last_visit_date: {
                required: true,
            },
        },
     
        submitHandler: function (form) {
            form.submit();
        }
    });
      
});

