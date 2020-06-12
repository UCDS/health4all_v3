<div class="container">
<form class="form-inline" id="primary_filter" action="<?php echo base_url().'/generic_resport/json_data';?>" method="post">
    <div class="form-group">
        <label for="from_date">From Date: </label>
        <input class="form-control" type="date" value='' name="from_date" id="from_date" size="15" />
    </div>
    <div class="form-group">
        <label for="to_date">To Date: </label>
        <input class="form-control" type="date" value='' name="to_date" id="to_date" size="15" />
    </div>
    <div class="form-group">
        <label for="signed_consultation">Doctor: </label><br>
        <select name="signed_consultation" class="form-control" >
		<option value=''>--Select--</option>
		<?php 
			foreach($doctors as $doc){
				echo "<option value='$doc->signed_consultation'>$doc->first_name $doc->last_name</option>";
			}
		?>
		</select>
    </div>
 <!--   <div class="form-group">
        <label for="hospital_id">Hospital: </label><br>
		<select name="hospital_id" class="form-control"  style="width:300px">
		<option value=''>--Select--</option>
		<?php 
		/*	foreach($hospitals as $row){
				echo "<option value='$row->hospital_id'>$row->hospital, $row->place, $row->district</option>";
			} */
		?>
		</select>
    </div> -->
    <div class="form-group">
      <label for="">&nbsp; </label><br>
        <button type="submit" id="submit" class="btn btn-default">Submit</button>
      </div>       
    </div>
    
</form>

<p hidden id="table_id">detailed_table</p>
<p hidden id="display_route_header">true</p>
<p hidden id="display_query_header">false</p>
<p hidden id="display_column_name">false</p>
<p hidden id="combine_columns">true</p>
<p hidden id="query_strings">prescription_report</p>

<br><br>
<table class="table table-striped table-bordered" id="detailed_table" >
    <thead>
        
    </thead>
    <tbody><!-- tr td -->
    
    </tbody>
    <tfoot><!-- tr td -->
        
    </tfoot>
</table>
</div>