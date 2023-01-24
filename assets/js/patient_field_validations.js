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
            },
            phone: {
                number: true
            },
        },
        ignore: ".date_custom",
        submitHandler: function (form) {
            form.submit();
        }
    });
   
    $('#custom_phone').keyup(function() {
        var phone_val = $('#custom_phone').val();
        
        $('#phone_more').hide();
        $('#phone_less').hide();
        if(phone_val.length < 10)
        {
         $('#phone_more').hide();
         $('#phone_less').show();
        }
         else if(!phone_val.length < 10){            
           $('#phone_less').hide();  
         } 
        if(phone_val.length > 10){
         $('#phone_less').hide();  
         $('#phone_more').show();     
        }      
        // else if(!phone_val.length > 10){
           
        //     $('#phone_more').hide();  
        // }  
      });    
});

// doctor_id, arrival_mode