var options = {
    widthFixed: true,
    showProcessing: true,
    headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!
    widgets: ['default', 'zebra', 'print', 'stickyHeaders', 'filter'],
    widgetOptions: {
        print_title: 'table',          // this option > caption > table id > "table"
        print_dataAttrib: 'data-name', // header attrib containing modified header name
        print_rows: 'f',         // (a)ll, (v)isible or (f)iltered
        print_columns: 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
        print_extraCSS: '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
        print_styleSheet: '', // add the url of your print stylesheet
        // callback executed when processing completes - default setting is null
        print_callback: function (config, $table, printStyle) {
            // do something to the $table (jQuery object of table wrapped in a div)
            // or add to the printStyle string, then...
            // print the table using the following code
            $.tablesorter.printTable.printOutput(config, $table.html(), printStyle);
        },
        // extra class name added to the sticky header row
        stickyHeaders: '',
        // number or jquery selector targeting the position:fixed element
        stickyHeaders_offset: 0,
        // added to table ID, if it exists
        stickyHeaders_cloneId: '-sticky',
        // trigger "resize" event on headers
        stickyHeaders_addResizeEvent: true,
        // if false and a caption exist, it won't be included in the sticky header
        stickyHeaders_includeCaption: false,
        // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
        stickyHeaders_zIndex: 2,
        // jQuery selector or object to attach sticky header to
        stickyHeaders_attachTo: null,
        // scroll table top into view after filtering
        stickyHeaders_filteredToTop: true,

        // adding zebra striping, using content and default styles - the ui css removes the background from default
        // even and odd class names included for this demo to allow switching themes
        zebra: ["ui-widget-content even", "ui-state-default odd"],
        // use uitheme widget to apply defauly jquery ui (jui) class names
        // see the uitheme demo for more details on how to change the class names
        uitheme: 'jui'
    }
};

function build_table(table_data) {
    let table_id = localStorage.getItem('table_id');
    let row_query_strings = localStorage.getItem('row_query_strings');
    let column_query_strings = localStorage.getItem('column_query_strings');

 //   $('#' + table_id + ' thead tr').remove();
    $('#' + table_id + ' tbody tr').remove();
    let route_headers = new Object();
    let query_headers = new Array();
    let column_count = 0;
    let query_count = 0;
    let seqenced_rows = new Object();
    let rows_string = '';
    if (column_query_strings != '') {
        let header_querys = column_query_strings.split(';');
        header_querys.forEach(function (query) {
            let header = query.split(':');
            route_headers[header[0]] = header[1].split('~');
        });
    }

    if (row_query_strings != '') {
        let rows_str = row_query_strings.split(';');
        rows_str.forEach(function (row_str, index) {
            seqenced_rows[row_str] = new Array();
            for (let route in route_headers) {
                seqenced_rows[row_str].push(route_headers[route][index]);
            }
        });
        for (let row in seqenced_rows) {
            rows_string += '<tr><td>' + row.split('#')[1] + '</td>';
            seqenced_rows[row].forEach(function (row) {   // Getting value for each row
                let data_points;      // Data point object
                if (row in table_data) {
                    data_points = table_data[row];
                } else {
                    data_points = new Array();
                }
                data_points.forEach(function (data_point) {
                    for (let column in data_point) {
                        rows_string += "<td><a href='#" + row + '_detail' + "'>" + data_point[column] + '</a>';   // Built cell for each data point
                    }
                    rows_string += '</td>';
                });
            });
            rows_string += '</tr>';
        }
        let header_string = '<tr><th>#</th>';
        for (let header in route_headers) {
            let heading = header.split('#')[1];
            header_string += '<th>' + heading + '</th>';
        }
        header_string += '</tr>';

        $('#' + table_id + ' thead ').append(header_string);
        $('#' + table_id + ' tbody ').append(rows_string);
    } else {
        console.log('In else');
        let query_string = Object.keys(table_data);
        console.log(table_data);
        console.log(query_string);
        // Getting headers and formatting headers
        query_string.forEach(function (query_result) {
            let table = table_data[query_result];
            let table_headers = Object.keys(table[0]);
            let header_string = '<tr><th>#</th>';
            table_headers.forEach(function (header) {
                header = header.replace('_', ' ');
                header = header.charAt(0).toUpperCase() + header.slice(1);
                header_string += '<th>' + header + '</th>';
            });
            header_string += '</tr>';
            if(localStorage.getItem('loaded')==1){
                $('#' + table_id + ' thead ').append(header_string);
            }
            let html_rows = '<tr>';
            let index = 1;
            table.forEach(function (row) {
                let columns = Object.values(row);
                html_rows += '<td>' + index + '&nbsp;</td>';
                columns.forEach(function (column) {
                    let col;
                    if(Boolean(column)){
                        col = column.replace(/(^\s*,)|(,\s*$)/g, '');
                    } else{
                        col = column;
                    }                   
                    html_rows += '<td>' + col + '</td>';
                });
                html_rows += '</tr>'
                index++;
            });
            $('#' + table_id + ' tbody ').append(html_rows);

        });
    }
    if(localStorage.getItem('loaded')==1){
        localStorage.setItem('loaded', 2);
        $('#' + table_id).tablesorter(options);
    }    
 //   $('#' + table_id).trigger("update");
}

function set_localStorage() {
    localStorage.setItem('loaded', 1);
    localStorage.setItem('initial_text', $('#ajax_notification').text());
    localStorage.setItem("table_id", $('#table_id').text());
    localStorage.setItem('query_strings', $('#query_strings').text());
    localStorage.setItem("row_query_strings", '');
    localStorage.setItem("column_query_strings", '');
}

function clear_localStorage() {
    localStorage.removeItem('loaded');
    localStorage.removeItem("table_id");
    localStorage.removeItem('query_strings');
    localStorage.removeItem("row_query_strings");
    localStorage.removeItem("column_query_strings");
}