<div class="center-block">
  


 <h2 align="center">Area</h2><br>
 <strong><?php if(isset($message)){ echo "<center>".$message."</center>";}   
     echo  "<center>".validation_errors()."<center>"; ?></strong> 
    
  <?php	echo form_open('hospital_areas/add_area',array('class'=>'form-group','role'=>'form')); ?> 
	 
    <div class="col-md-8 col-md-offset-3">
	 <div class="row">
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
	    <div class="form-group">
	        <label for="inputarea_name">Area Name</label>
		<input class="form-control" name="area_name"  id="inputarea_name" placeholder="enter name" type="TEXT" align="middle">
	    </div>
	  </div>
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
	   <div class="form-group">
	    <label for="inputdepartment_id">Department</label>
		 <select name="department_id" id="department_id" class="form-control">
		 <option value="">select</option>
	     <?php
		  foreach($all_departments as $dept)
		  {
		    echo "<option value='".$dept->department_id."'>".$dept->department."</option>";
		  }
		 ?>
		</select>
	   </div>	
	  </div>
	  <div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
	    <div class="form-group">
	        <label for="inputbeds ">Beds</label>
		<input class="form-control" name="beds" id="inputbeds" placeholder="enter no of beds" type="text">
	    </div>
	  </div>
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
	   <div class="form-group">
	    <label for="inputarea_type_id ">Area Type </label>
		 <select name="area_type_id" id="area_type_id" class="form-control">
		 <option value="">select</option>
		 <?php
		 foreach($area_types as $area)
		 {
		   echo"<option value='".$area->area_type_id."'>".$area->area_type."</option>";
		 }
		 ?>
	    </select>
	   </div>	
	  </div>
	  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
	   <div class="form-group">
	    <label for="inputlab_report_staff_id ">Lab Report Staff </label>
		<select name="lab_report_staff_id" id="lab_report_staff_id" class="form-control">
		 <option value="">select</option>
		 <?php
		  foreach($lab_report_staff as $lab)
		  {
		   echo"<option value='".$lab->staff_id."'>".$lab->staff_name."</option>";
		  }
		 ?>
		</select>
	   </div>	
	  </div>
	  </div>
	  </div>
	  <div class="container">
	   <div class="row">
		<div class="col-md-12">
		 <center><button class="btn btn-default" type="submit" name="Submit" id="btn">Submit</button></center>
		</div>
	   </div>
	  </div>
	  <?php echo form_close(); ?>
     </div>
   
