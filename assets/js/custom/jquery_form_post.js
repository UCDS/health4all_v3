$(document).ready(function(){
    // click on button submit
    $("#primary_filter").submit(function(event){
        // send ajax
        console.log('Submit clicked');
        let previous_text = localStorage.getItem('initial_text');
        
        $('#ajax_notification').text(previous_text+" Query submitted please wait...");
        let query_strings = localStorage.getItem('query_strings');
        $('<input />').attr('type', 'hidden')
            .attr('name', "query_strings")
            .attr('id', 'query_strings_field')
            .attr('value', query_strings)
            .appendTo('#primary_filter');
        $.ajax({
            url: '/generic_report/json_data',     // url where to submit the request Local URL
                                                                // url: '/generic_report/json_data',     // url where to submit the request
            type : "POST",                                      // type of action POST || GET
            dataType : 'json',                                  // data type
            data : $("#primary_filter").serialize(),            // post data || get data
            success : function(result) {
                // you can see the result from the console
                // tab of the developer tools
                $('#ajax_notification').text(previous_text+" Got Result");
                build_table(result);
                $('#query_strings_field').remove();
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
                $('#ajax_notification').text(previous_text+" Something went wrong");
                $('#query_strings_field').remove();
            }
        });
        event.preventDefault();
    });
});