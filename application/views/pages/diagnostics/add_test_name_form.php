<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
 <script>
     $(function () {
         $(":checked").attr('checked', false);
         var i = 2;
         $("#b_test_name").click(function () {
             var test_name = "<div id='add_test_name_" + i + "' ><div class='col-md-10'></br>";
             test_name += "<input type='text' name='test_name[]' form='add_test_name' class='form-control' size='2' /></div><div class='col-md-2'></br>";
             test_name += "<input type='button' class='btn btn-danger btn-sm' value='X' onclick='remove_test_name(" + i + ")' /></div></div>";
             $(".test_name").append(test_name);
             i++;
         });

         $("#binary_output").click(function () {
             if ($(this).is(":checked")) {
                 $(".binary_output_labels").show();
                 $(".binary_output_labels").find("input").attr('required', true);
             }
             else {
                 $(".binary_output_labels").hide();
                 $(".binary_output_labels").find("input").attr('required', false);
             }
         });

         $(".numeric_output").click(function () {
             if ($(this).is(":checked")) {
                 $(".numeric_output_units").show();
                 $(".numeric_output_range").show();
                 $(".range").show();
                 $(".numeric_output_units").find("select").attr('required', true);

             }
             else {
                 $(".numeric_output_units").hide();
                 $(".numeric_output_range").hide();
                 $(".range").hide();
                 $(".numeric_output_units").find("select").attr('required', false);

                 for (i = 1; i <= parseInt($("#count_of_range_items").val()); i++) {
                     $("#range_bound_lower_label" + i).hide();
                     $("#range_bound_lower" + i).hide();
                     $("#range_bound_upper" + i).hide();
                     $("#range_less_than_label" + i).hide();
                     $("#range_upper_bound" + i).hide();
                     $("#range_greater_than_label" + i).hide();
                     $("#range_lower_bound" + i).hide();
                     $("#age_between_years_low_label" + i).hide();
                     $("#age_between_years_low" + i).hide();
                     $("#age_between_months_low" + i).hide();
                     $("#age_between_days_low" + i).hide();
                     $("#age_between_years_high_label" + i).hide();
                     $("#age_between_years_high" + i).hide();
                     $("#age_between_months_high" + i).hide();
                     $("#age_between_days_high" + i).hide();
                     $("#age_less_than_years_label" + i).hide();
                     $("#age_less_than_years" + i).hide();
                     $("#age_less_than_months" + i).hide();
                     $("#age_less_than_days" + i).hide();
                     $("#age_greater_than_years_label" + i).hide();
                     $("#age_greater_than_years" + i).hide();
                     $("#age_greater_than_months" + i).hide();
                     $("#age_greater_than_days" + i).hide();
                 }
                 $("input:radio").attr("checked", false);
             }
         });
         $(".output_format input[type=checkbox]").click(function () {
             $(".output_check").attr('required', true);
             $(".output_format input[type=checkbox]").each(function () {
                 if ($(this).is(':checked'))
                     $(".output_check").attr('required', false);
             });
         });

         //Function to display the range text boxes to gather input from the user.
         //If the user selects value type as between.

         $("#add_range").click(function () {
             var count_of_range_items = parseInt($("#count_of_range_items").val()) + 1;
             $("#count_of_range_items").val("" + count_of_range_items);
             var field1 = '<div class="form_group test_range" id="range_' + count_of_range_items + '"><label class="col-md-4 range" >Value Range</label>' +
                             '<div class="col-md-8 range" id="value_range" >' +
                                 '<label><input type="radio" id="range_type_between' + count_of_range_items + '" onclick="showRangeTypeBetween(' + count_of_range_items + ');" form="add_test_name" value="3" name="range' + count_of_range_items + '" />' +
                                 '[...]Between &nbsp;</label>' +
                                 '<label><input type="radio" id="range_less_than' + count_of_range_items + '" onclick="showRangeLessThan(' + count_of_range_items + ');" form="add_test_name" value="1" name="range' + count_of_range_items + '" />' +
                                 '&lt Less than &nbsp; </label>' +
                                 '<label><input type="radio" id="range_greater_than' + count_of_range_items + '" onclick="showRangeGreaterThan(' + count_of_range_items + ')" form="add_test_name" value="2" name="range' + count_of_range_items + '" />' +
                                 '&gt Greater than</label>' +
                                 '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                                 '<span class="glyphicon glyphicon-minus" aria-hidden="true" onclick="$(\'#range_' + count_of_range_items + '\').remove()"></span>' +
                             '</div>';


             var field2 = '<label for="range_bound_lower' + count_of_range_items + '" id="range_bound_lower_label' + count_of_range_items + '" class="col-md-4 between" hidden>Value Between</label>' +
                         '<div class="col-md-4 between" id="range_bound_lower' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="range_low' + count_of_range_items + '" placeholder="Minimum" />' +
                         '</div>' +
                         '<div class="col-md-4 between" id="range_bound_upper' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="range_high' + count_of_range_items + '" placeholder="Maximum" />' +
                         '</div>' +
                         '<label for="range_upper_bound' + count_of_range_items + '" class="col-md-4 less_than" id="range_less_than_label' + count_of_range_items + '" hidden>Value less than</label>' +
                         '<div class="col-md-8 less_than" id="range_upper_bound' + count_of_range_items + '" hidden>' +
                             '<input type="Text" class="form-control" form="add_test_name" name="value_less_than' + count_of_range_items + '" placeholder="Value less than" />' +
                         '</div>' +
                         '<label for="range_lower_bound' + count_of_range_items + '" id="range_greater_than_label' + count_of_range_items + '" class="col-md-4 greater_than" hidden>Value greater than</label>' +
                         '<div class="col-md-8 greater_than" id="range_lower_bound' + count_of_range_items + '" hidden>' +
                             '<input type="Text" class="form-control" form="add_test_name" name="value_greater_than' + count_of_range_items + '" placeholder="Value greater than" />' +
                         '</div>';

             var field3 = '<label class="col-md-4 range" >Gender</label>' +
                          '<div class="col-md-8 range" >' +
                             '<label ><input type="radio" form="add_test_name" value="1" name="gender' + count_of_range_items + '" />' +
                             'Male &nbsp;</label>' +
                             '<label ><input type="radio" form="add_test_name" value="2" name="gender' + count_of_range_items + '" />' +
                             'Female &nbsp;</label>' +
                             '<label ><input type="radio" form="add_test_name" value="3" name="gender' + count_of_range_items + '" />' +
                             'Both</label>' +
                          '</div>';

             var field4 = '<label class="col-md-4 range" >Age Range</label>' +
                          '<div class="col-md-8 range">' +
                              '<label ><input type="radio" id="between_ages' + count_of_range_items + '" onclick="showAgeBetween(' + count_of_range_items + ');" form="add_test_name" value="3" name="age' + count_of_range_items + '" />' +
                              '[...]Age between &nbsp;</label>' +
                              '<label ><input type="radio" id="age_less_than' + count_of_range_items + '" onclick="showAgeLessThan(' + count_of_range_items + ');" form="add_test_name" value="1" name="age' + count_of_range_items + '" />' +
                              ' &ltAge less than &nbsp;</label>' +
                              '<label ><input type="radio" id="age_greater_than' + count_of_range_items + '" onclick="showAgeGreaterThan(' + count_of_range_items + ');" form="add_test_name" value="2" name="age' + count_of_range_items + '" />' +
                              ' &gtAge greater than</label>' +
                              '<input type="radio" id="all_ages' + count_of_range_items + '" form="add_test_name" value="4" name="age' + count_of_range_items + '" />'+
                              '<label for="all_ages1"> &gtAll ages</label>'
                          '</div>' +
                          '<label for="age_between_years_low' + count_of_range_items + '" id="age_between_years_low_label' + count_of_range_items + '" class="col-md-4 age_between" hidden>Lower age limit</label>' +
                          '<div class="col-md-2 age_between" id="age_between_years_low' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="year_low' + count_of_range_items + '" placeholder="Years" />' +
                          '</div>' +
                          '<div class="col-md-2 age_between" id="age_between_months_low' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="month_low' + count_of_range_items + '" placeholder="Months" />' +
                          '</div>' +
                          '<div class="col-md-2 age_between" id="age_between_days_low' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="day_low' + count_of_range_items + '" placeholder="Days" />' +
                          '</div>' +
                          '<label for="age_between_years_high' + count_of_range_items + '" id="age_between_years_high_label' + count_of_range_items + '" class="col-md-4 age_between" hidden>Upper age limit</label>' +
                          '<div class="col-md-2 age_between" id="age_between_years_high' + count_of_range_items + '" hidden>' +
                              '<input type="text" class="form-control" form="add_test_name" name="year_high' + count_of_range_items + '" placeholder="Years" />' +
                          '</div>' +
                          '<div class="col-md-2 age_between" id="age_between_months_high' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="month_high' + count_of_range_items + '" placeholder="Months" />' +
                          '</div>' +
                          '<div class="col-md-2 age_between" id="age_between_days_high' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="day_high' + count_of_range_items + '" placeholder="Days" />' +
                          '</div>' +
                          '<label for="age_less_than_years' + count_of_range_items + '" id="age_less_than_years_label' + count_of_range_items + '" class="col-md-4 upper_age_limit" hidden>Age less than</label>' +
                          '<div class="col-md-2 upper_age_limit" id="age_less_than_years' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="upper_age_limit_years' + count_of_range_items + '" placeholder="Years" />' +
                          '</div>' +
                          '<div class="col-md-2 upper_age_limit" id="age_less_than_months' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="upper_age_limit_months' + count_of_range_items + '" placeholder="Months" />' +
                          '</div>' +
                          '<div class="col-md-2 upper_age_limit" id="age_less_than_days' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="upper_age_limit_days' + count_of_range_items + '" placeholder="Days" />' +
                          '</div>' +
                          '<label for="age_greater_than_years' + count_of_range_items + '" id="age_greater_than_years_label' + count_of_range_items + '" class="col-md-4 lower_age_limit" hidden>Age greater than</label>' +
                          '<div class="col-md-2 lower_age_limit" id="age_greater_than_years' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="lower_age_limit_years' + count_of_range_items + '" placeholder="Years" />' +
                          '</div>' +
                          '<div class="col-md-2 lower_age_limit" id="age_greater_than_months' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="lower_age_limit_months" placeholder="Months" />' +
                          '</div>' +
                          '<div class="col-md-2 lower_age_limit" id="age_greater_than_days' + count_of_range_items + '" hidden>' +
                             '<input type="text" class="form-control" form="add_test_name" name="lower_age_limit_days' + count_of_range_items + '" placeholder="Days" />' +
                          '</div>' +
                     '</div>';
             var total = field1 + field2 + field3 + field4;
             $("#range_fields_container").append(total);

         });

     });

     function showRangeTypeBetween(rangeNumber) {
         if (document.getElementById("range_type_between" + rangeNumber).checked) {
             $("#range_bound_lower_label" + rangeNumber).show();
             $("#range_bound_lower" + rangeNumber).show();
             $("#range_bound_upper" + rangeNumber).show();

             $("#range_less_than_label" + rangeNumber).hide();
             $("#range_upper_bound" + rangeNumber).hide();
             $("#range_greater_than_label" + rangeNumber).hide();
             $("#range_lower_bound" + rangeNumber).hide();
         }
     }

     function showRangeLessThan(rangeNumber) {
         if (document.getElementById("range_less_than" + rangeNumber).checked) {
             $("#range_less_than_label" + rangeNumber).show();
             $("#range_upper_bound" + rangeNumber).show();

             $("#range_bound_lower_label" + rangeNumber).hide();
             $("#range_bound_lower" + rangeNumber).hide();
             $("#range_bound_upper" + rangeNumber).hide();
             $("#range_greater_than_label" + rangeNumber).hide();
             $("#range_lower_bound" + rangeNumber).hide();
         }
     }

     function showRangeGreaterThan(rangeNumber) {
         if (document.getElementById("range_greater_than" + rangeNumber).checked) {
             $("#range_greater_than_label" + rangeNumber).show();
             $("#range_lower_bound" + rangeNumber).show();

             $("#range_less_than_label" + rangeNumber).hide();
             $("#range_upper_bound" + rangeNumber).hide()
             $("#range_bound_lower_label" + rangeNumber).hide();
             $("#range_bound_lower" + rangeNumber).hide();
             $("#range_bound_upper" + rangeNumber).hide();
         }
     }

     function showAgeBetween(rangeNumber) {
         if (document.getElementById("between_ages" + rangeNumber).checked) {
             $("#age_between_years_low_label" + rangeNumber).show();
             $("#age_between_years_low" + rangeNumber).show();
             $("#age_between_months_low" + rangeNumber).show();
             $("#age_between_days_low" + rangeNumber).show();
             $("#age_between_years_high_label" + rangeNumber).show();
             $("#age_between_years_high" + rangeNumber).show();
             $("#age_between_months_high" + rangeNumber).show();
             $("#age_between_days_high" + rangeNumber).show();

             $("#age_less_than_years_label" + rangeNumber).hide();
             $("#age_less_than_years" + rangeNumber).hide();
             $("#age_less_than_months" + rangeNumber).hide();
             $("#age_less_than_days" + rangeNumber).hide();

             $("#age_greater_than_years_label" + rangeNumber).hide();
             $("#age_greater_than_years" + rangeNumber).hide();
             $("#age_greater_than_months" + rangeNumber).hide();
             $("#age_greater_than_days" + rangeNumber).hide();
         }
     }

     function showAgeLessThan(rangeNumber) {
         if (document.getElementById("age_less_than" + rangeNumber).checked) {
             $("#age_less_than_years_label" + rangeNumber).show();
             $("#age_less_than_years" + rangeNumber).show();
             $("#age_less_than_months" + rangeNumber).show();
             $("#age_less_than_days" + rangeNumber).show();

             $("#age_between_years_low_label" + rangeNumber).hide();
             $("#age_between_years_low" + rangeNumber).hide();
             $("#age_between_months_low" + rangeNumber).hide();
             $("#age_between_days_low" + rangeNumber).hide();
             $("#age_between_years_high_label" + rangeNumber).hide();
             $("#age_between_years_high" + rangeNumber).hide();
             $("#age_between_months_high" + rangeNumber).hide();
             $("#age_between_days_high" + rangeNumber).hide();

             $("#age_greater_than_years_label" + rangeNumber).hide();
             $("#age_greater_than_years" + rangeNumber).hide();
             $("#age_greater_than_months" + rangeNumber).hide();
             $("#age_greater_than_days" + rangeNumber).hide();
         }
     }

     function showAgeGreaterThan(rangeNumber) {
         if (document.getElementById("age_greater_than" + rangeNumber).checked) {
             $("#age_greater_than_years_label" + rangeNumber).show();
             $("#age_greater_than_years" + rangeNumber).show();
             $("#age_greater_than_months" + rangeNumber).show();
             $("#age_greater_than_days" + rangeNumber).show();

             $("#age_between_years_low_label" + rangeNumber).hide();
             $("#age_between_years_low" + rangeNumber).hide();
             $("#age_between_months_low" + rangeNumber).hide();
             $("#age_between_days_low" + rangeNumber).hide();
             $("#age_between_years_high_label" + rangeNumber).hide();
             $("#age_between_years_high" + rangeNumber).hide();
             $("#age_between_months_high" + rangeNumber).hide();
             $("#age_between_days_high" + rangeNumber).hide();

             $("#age_less_than_years_label" + rangeNumber).hide();
             $("#age_less_than_years" + rangeNumber).hide();
             $("#age_less_than_months" + rangeNumber).hide();
             $("#age_less_than_days" + rangeNumber).hide();
         }
     }

</script>
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Test Name </h3>
	</center><br>
	<center>
        <?php  echo validation_errors(); 
               echo form_open('diagnostics/add/test_name',array('role'=>'form','class'=>'form-custom','id'=>'add_test_name')); 
        ?>
	</center>
	
	<div class="form-group">
		<label for="test_area" class="col-md-4">Test Area<font color='red'>*</font></label>
		<div  class="col-md-8">
		<select name="test_area" id="test_area" class="form-control">
		<?php foreach($test_areas as $d){
			echo "<option value='$d->test_area_id'>$d->test_area</option>";
		}
		?>
		</select>
		</div>
		<br />
		<br />

		<label for="test_method" class="col-md-4">Test Method<font color='red'>*</font></label>
		<div  class="col-md-8">
		<select name="test_method" id="test_method" class="form-control">
		<?php foreach($test_methods as $d){
			echo "<option value='$d->test_method_id'>$d->test_method</option>";
		}
		?>
		</select>
		</div>
		<br />
		<br />
		<label for="test_name" class="col-md-4">Test Name<font color='red'>*</font></label>
		<div  class="col-md-8 test_name" id="add_test_name" >
			<input type="text" class="form-control" placeholder="Test Name" id="test_name" form="add_test_name" name="test_name" required />
			<input type="text" class="form-control" placeholder="Note" id="test_note" form="add_test_note" name="test_note" />
		</div>
		<br />
		<br />

		<label for="add_output_format" class="col-md-4">Output Format<font color='red'>*</font></label>
		<div  class="col-md-8 output_format" id="add_output_format" >
			<input type="checkbox" id="binary_output" form="add_test_name" value="1" name="output_format[]"  />
			<label for="binary_output">Binary</label>
			<input type="checkbox" class="numeric_output" form="add_test_name" value="2" name="output_format[]" />
			<label>Numeric</label>
			<input type="checkbox" id="text_output" form="add_test_name" value="3" name="output_format[]" />
			<label for="text_output">Text</label>
                        <input type="checkbox" class="output_check sr-only" required /> 
		</div>
		<br />
		<br />

		<label for="binary_output_labels" class="col-md-4 binary_output_labels" hidden>Binary Labels<font color='red'>*</font></label>
		<div  class="col-md-8 binary_output_labels" id="binary_output_labels"  hidden>
			<input type="text" class="form-control binary_output" placeholder="Binary Positive Label" id="binary_pos" form="add_test_name" name="binary_pos" />
			<input type="text" class="form-control binary_output" placeholder="Binary Negative Label" id="binary_neg" form="add_test_name" name="binary_neg" />			
		
		<br />
		</div>

		<label for="numeric_output_units" class="col-md-4 numeric_output_units" hidden>Numeric output units<font color='red'>*</font></label>
		<div  class="col-md-8 numeric_output_units" id="numeric_output_units"  hidden>
			<select name="numeric_result_unit" class="form-control">
				<option value="" selected disabled>Select</option>
				<?php foreach($lab_units as $unit){ ?>
					<option value="<?php echo $unit->lab_unit_id;?>"><?php echo $unit->lab_unit;?></option>
				<?php } ?>
			</select>
		</div>
                
                <!--Fields to input values of the range. All of them are having class range, so that they can be hidden and shown. -->
                <div class="form_group" id="range_fields_container" >
                <div class='test_range'>
                <label for="value_range" class="col-md-4 range" hidden>Value Range</label>
                <div class="col-md-8 range" id="value_range" hidden>
                    <input type="radio" id="range_type_between1" onclick="showRangeTypeBetween('1');" form="add_test_name" value="3" name="range1" />
                    <label for="range_type_between1">[...]Between</label>
                    <input type="radio" id="range_less_than1" onclick="showRangeLessThan('1');" form="add_test_name" value="1" name="range1" />
                    <label for="range_less_than1"> &lt Less than</label>
                    <input type="radio" id="range_greater_than1" onclick="showRangeGreaterThan('1')" form="add_test_name" value="2" name="range1" />
                    <label for="range_greater_than1"> &gt Greater than</label>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="glyphicon glyphicon-plus" id="add_range" aria-hidden="true"></span>
                </div>
                
                <label for="range_bound_lower1" id="range_bound_lower_label1" class="col-md-4 between" hidden>Value Between</label>
                <div class="col-md-4 between" id="range_bound_lower1" hidden>
                    <input type="text" id="range_low" class="form-control" form="add_test_name" name="range_low1" placeholder="Minimum" />
                </div>
                <div class="col-md-4 between" id="range_bound_upper1" hidden>
                    <input type="text" id="range_high" class="form-control" form="add_test_name" name="range_high1" placeholder="Maximum" />
                </div>
                <label for="range_upper_bound1" id="range_less_than_label1" class="col-md-4 less_than" hidden>Value less than</label>
                <div class="col-md-8 less_than" id="range_upper_bound1" hidden>
                    <input type="Text" id="value_less_than" class="form-control" form="add_test_name" name="value_less_than1" placeholder="Value less than" />
                </div>
                <label for="range_lower_bound1" id="range_greater_than_label1" class="col-md-4 greater_than" hidden>Value greater than</label>
                <div class="col-md-8 greater_than" id="range_lower_bound1" hidden>
                    <input type="Text" id="value_greater_than1" class="form-control" form="add_test_name" name ="value_greater_than1" placeholder="Value greater than" />
                </div>
                
                <label for="gender1" class="col-md-4 range" hidden>Gender</label>
                <div class="col-md-8 range" id="gender" hidden>
                    <input type="radio" id="gender_male" form="add_test_name" value="1" name="gender1" />
                    <label for="gender_male">Male</label>
                    <input type="radio" id="gender_female" form="add_test_name" value="2" name="gender1" />
                    <label for="gender_female">Female</label>
                    <input type="radio" id="gender_both" form="add_test_name" value="0" name="gender1" />
                    <label for="gender_both">Both</label>
                </div>
                
                <label for="age_range" class="col-md-4 range" hidden>Age Range</label>
                <div class="col-md-8 range" id="age_range" hidden>
                    <input type="radio" id="between_ages1" onclick="showAgeBetween('1');" form="add_test_name" value="3" name="age1" />
                    <label for="between_ages">[...]Age between</label>
                    <input type="radio" id="age_less_than1" onclick="showAgeLessThan('1');" form="add_test_name" value="1" name="age1" />
                    <label for="age_less_than1"> &ltAge less than</label>
                    <input type="radio" id="age_greater_than1" onclick="showAgeGreaterThan('1');" form="add_test_name" value="2" name="age1" />
                    <label for="age_greater_than1"> &gtAge greater than</label>
                    <input type="radio" id="all_ages1" form="add_test_name" value="4" name="age1" />
                    <label for="all_ages1"> &gtAll ages</label>
                </div>
                <label for="age_between_years_low1" id="age_between_years_low_label1" class="col-md-4 age_between" hidden>Lower age limit</label>
                <div class="col-md-2 age_between" id="age_between_years_low1" hidden>
                    <input type="text" id="year_low" class="form-control" form="add_test_name" name="year_low1" placeholder="Years" />
                </div>
                <div class="col-md-2 age_between" id="age_between_months_low1" hidden>
                    <input type="text" id="month_low" class="form-control" form="add_test_name" name="month_low1" placeholder="Months" />
                </div>
                <div class="col-md-2 age_between" id="age_between_days_low1" hidden>
                    <input type="text" id="day_low" class="form-control" form="add_test_name" name="day_low1" placeholder="Days" />
                </div>
                <label for="age_between_years_high1" id="age_between_years_high_label1" class="col-md-4 age_between" hidden>Upper age limit</label>
                <div class="col-md-2 age_between" id="age_between_years_high1" hidden>
                    <input type="text" id="year_high" class="form-control" form="add_test_name" name="year_high1" placeholder="Years" />
                </div>
                <div class="col-md-2 age_between" id="age_between_months_high1" hidden>
                    <input type="text" id="month_high" class="form-control" form="add_test_name" name="month_high1" placeholder="Months" />
                </div>
                <div class="col-md-2 age_between" id="age_between_days_high1" hidden>
                    <input type="text" id="day_high" class="form-control" form="add_test_name" name="day_high1" placeholder="Days" />
                </div>
                <label for="age_less_than_years1" id="age_less_than_years_label1" class="col-md-4 upper_age_limit" hidden>Age less than</label>
                <div class="col-md-2 upper_age_limit" id="age_less_than_years1" hidden>
                    <input type="text" id="upper_age_limit_years" class="form-control" form="add_test_name" name="upper_age_limit_years1" placeholder="Years" />
                </div>
                <div class="col-md-2 upper_age_limit" id="age_less_than_months1" hidden>
                    <input type="text" id="upper_age_limit_months" class="form-control" form="add_test_name" name="upper_age_limit_months1" placeholder="Months" />
                </div>
                <div class="col-md-2 upper_age_limit" id="age_less_than_days1" hidden>
                    <input type="text" id="upper_age_limit_days" class="form-control" form="add_test_name" name="upper_age_limit_days1" placeholder="Days" />
                </div>
                <label for="age_greater_than_years1" id="age_greater_than_years_label1" class="col-md-4 lower_age_limit" hidden>Age greater than</label>
                <div class="col-md-2 lower_age_limit" id="age_greater_than_years1" hidden>
                    <input type="text" id="lower_age_limit_years" class="form-control" form="add_test_name" name="lower_age_limit_years1"  placeholder="Years" />
                </div>
                <div class="col-md-2 lower_age_limit" id="age_greater_than_months1" hidden>
                    <input type="text" id="lower_age_limit_months" class="form-control" form="add_test_name" name="lower_age_limit_months1" placeholder="Months" />
                </div>
                <div class="col-md-2 lower_age_limit" id="age_greater_than_days1" hidden>
                    <input type="text" id="lower_age_limit_days" class="form-control" form="add_test_name" name="lower_age_limit_days1" placeholder="Days" />
                </div>  
                </div>
                <br /><br /><br />
                </div> <!-- Range fields container end -->
                <input type="text" id="count_of_range_items" form="add_test_name" name="range_item_count" value="1" hidden />
        </div>
   	<div class="col-md-3 col-md-offset-4">
	</br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="submit">Submit</button>
	</div>
</div>
