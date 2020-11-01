<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<div class="row">
<?php if(isset($report) && count($report)==1){ ?>
<div class="col-md-8 col-md-offset-2">
	
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Edit Document</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
    <?php 
	foreach($report as $s){
	?>    
	<?php 
	echo form_open_multipart('documentation/edit_document/'.$s->id,array('class'=>'form-horizontal','role'=>'form','id'=>'edit_document')); 
	?>
	<div class="form-group">
		<div class="col-md-6">
			<input type="hidden" class="form-control" placeholder="keyword" id="keyword" name="keyword" required
            value='<?php echo $s->id;?>' />
		</div>
	</div>    
	<div class="form-group">
		<div class="col-md-3">
			<label for="keyword" class="control-label">Keyword*</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="keyword" id="keyword" name="keyword" required
            value='<?php echo $s->keyword;?>' />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="topic" class="control-label">Topic*</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Topic" id="topic" name="topic" required 
            value='<?php echo $s->topic;?>' />
		</div>
    </div>
    <div class="form-group">
		<div class="col-md-3">
			<label for="document_date" class="control-label">Document Date*</label>
		</div>
		<div class="col-md-6">
			<input type="date" class="form-control" value='<?php echo $s->document_date;?>' id="document_date" name="document_date" required />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Display Status</label>
		</div>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="status" value="1" checked />Display&nbsp;&nbsp;  
			</label>
			<label class="control-label">
				<input type="radio" name="status" value="0" />Hide
			</label>
		</div>
	</div>  
    <div class="form-group">
		<div class="col-md-3">
			<label for="note" class="control-label">Note</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Note" id="note" name="note" 
            value='<?php echo $s->note;?>' />
		</div>
	</div>
    <div class="form-group">
        <div class="col-md-3">
			<label for="note" class="control-label">Replace Document*</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="sr-only" hidden name="document_link" />
            <input type="file" name="upload_file" id="upload_file" readonly="true"/>
        </div>
		<div class="col-md-6">
		<?php 
		    // Add text Tip for defaults
	        foreach($defaultsConfigs as $default){
	     	    if ($default->default_id=="udoc_max_size"){
					$max_size = "Max Size " . $default->value . " " . $default->default_unit;
				}
				if ($default->default_id=="udoc_allowed_types"){
	    		    $allowed_types = $default->default_unit ." " . $default->value;
				 }
	     	    if ($default->default_id=="udoc_max_width"){
					$max_width = "Max Width " . $default->value . " " . $default->default_unit;
				}
				if ($default->default_id=="udoc_max_height"){
	    		    $max_height = "Max Height " . $default->value ." " . $default->default_unit;
	         	}			  
			}
			echo nl2br($max_size . " : " . $allowed_types . "\n(If image is allowed: " . $max_width . " : " . $max_height . ")");
	    ?>
		</div>
    </div>
    <div class="col-md-6">
                    <div id="moreImageUpload"></div>
                    <div style="clear:both;"></div><br>
                  <button class="btn btn-lg btn-primary btn-block"  type="submit" name="file_upload" value="Upload" class="btn btn-group btn-default btn-animated" >Submit</button>
    </div>           
    <?php } ?>                       
</form>
</div>
<?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[id^='upload_file']").each(function() {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function() {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreImageUploadLink").show();
                }
            });
        });
    });
</script>
