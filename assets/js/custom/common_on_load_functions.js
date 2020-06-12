$(document).ready(function() {
    // Set initial date
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $('#to_date').val(today);
    $('#from_date').val(today);
    $('#admit_date').val(today);
    
    // Set local storage
    localStorage.clear();
    set_localStorage();
    
    let table_id = localStorage.getItem('table_id');
    
    // Submit default filter
    $('#primary_filter').submit();
    $('#'+table_id).click(function(event){
        console.log('In table event');
        if(event.target.nodeName=='A'){
            console.log('link event');
            let query_string = $(event.target).attr('href');
            query_string = query_string.replace('#', '');
        //    localStorage.clear();
            clear_localStorage();
            localStorage.setItem('query_strings', query_string);
            localStorage.setItem("table_id", 'detailed_table');
            localStorage.setItem("row_query_strings", '');
            localStorage.setItem("column_query_strings", '');
            $('#detailed_table').removeAttr('hidden');
            $('#primary_filter').submit();
        }
    });
    console.log('after submit');
});