<!---------------------------- issue_tracker log script -------------------------->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>
.row{	
  margin-top:10px;
  margin-bottom:10px;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<div class="panel panel-warning">
  <div class="panel-heading">Error Log</div>
  <div class="panel-body">
<div class="row small">
		<div class="col-xs-4">
				<div class="col-md-4">
					<label for="date" class='control-label'>Date </label>
				</div>
				<div class="col-md-8">
                                    <input type="text" value="<?php echo date("d-M-Y"); ?>" readonly name="date" class="form-control input-sm" id="date" />
				</div>
		</div>
		<div class=" col-xs-4">		
				<div class="col-md-4">
	       			<label for="time" class='control-label'>Time  </label>
				</div>
				<div class="col-md-8">
					<input type="text" value="<?php echo date("g:iA"); ?>" readonly name="time" class="form-control input-sm" id="time" />
				</div>
		</div>
	</div>
<div class="row small">
		<div class="col-xs-4">
				<div class="col-md-4">
				<label class="control-label">In Brief* </label>
				</div>
				<div class="col-md-8">
				<input type="text" name="brief" placeholder="In Brief" class="form-control" size="160"  required />
				</div>
		</div>
       </div>
<div class="row small">
  <div class="col-xs-4">
			<div class="col-md-4">
					Description : 
			</div>
			<div class="col-md-8">
                            <textarea name="textarea" rows="10" name="detail" class="form-control" cols="50" size="500" placeholder="Description" ></textarea>
				        
			</div>
		</div>
 
</div>
     <div class="row small">
		<div class="col-xs-4">
			<div class="col-md-4">
					E-Mail ID : 
			</div>
			<div class="col-md-8">
					<input type="text" name="email_id" class="form-control" size="30" id="email_id" />
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
					Phone : 
			</div>
			<div class="col-md-8">
					<input type="text" name="phone" class="form-control" sze="15" />
			</div>
		</div>
	</div>
 
     <br />
    <!------------------------------------ upload form view---------------------------------------->
  <body> 
      
      <?php echo form_open_multipart('issue_tracker/do_upload');?> 
		
      <form action = "" method = "">
         <input  type = "file" name = "userfile" size = "1000" /> 
         <br /><br /> 
         <input type = "submit" value = "upload" /> 
      
		
   </body>
   <br/>
         </form> 
        </div>
 </div>

  
     