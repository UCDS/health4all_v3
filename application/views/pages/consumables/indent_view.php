<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">

<style type="text/css">
.selectize-control.items .selectize-dropdown>div {
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.selectize-control.items .selectize-dropdown .by {
	font-size: 11px;
	opacity: 0.8;
}

.selectize-control.items .selectize-dropdown .by::before {
	content: 'by ';
}

.selectize-control.items .selectize-dropdown .name {
	font-weight: bold;
	margin-right: 5px;
}

.selectize-control.items .selectize-dropdown .title {
	display: block;
}

.selectize-control.items .selectize-dropdown .description {
	font-size: 12px;
	display: block;
	color: #a0a0a0;
	white-space: nowrap;
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

.selectize-control.items .selectize-dropdown .meta {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 10px;
}

.selectize-control.items .selectize-dropdown .meta li {
	margin: 0;
	padding: 0;
	display: inline;
	margin-right: 10px;
}

.selectize-control.items .selectize-dropdown .meta li span {
	font-weight: bold;
}

.selectize-control.items::before {
	-moz-transition: opacity 0.2s;
	-webkit-transition: opacity 0.2s;
	transition: opacity 0.2s;
	content: ' ';
	z-index: 2;
	position: absolute;
	display: block;
	top: 12px;
	right: 34px;
	width: 16px;
	height: 16px;
	background: url(<?php echo base_url(); ?>assets/images/spinner.gif);
	background-size: 16px 16px;
	opacity: 0;
}

.selectize-control.items.loading::before {
	opacity: 0.4;
}
</style>
<script type="text/javascript">
		var rowcount=0;
		$(function(){

		let options = <?= json_encode($all_item); ?>;
		options = options.map(opt => {
		let ans = `${opt.item_name}-${opt.item_form}-`;
		if (opt.dosage) {
			ans += opt.dosage;
		}
		if (opt.dosage_unit) {
			ans += opt.dosage_unit;
		}
		return {
			...opt,
			item_name: ans
		};
		});
		console.log(options);

		$("#indent_date").Zebra_DatePicker({direction:false});
		$("#indent_time").ptTimeSelect();
		$("#addbutton").click(function(){
			rowcount++;
			var sno="<td>"+ " " +"</td></br>";
			
			var item ="<td><div class='form-group'><select name='item[]' id='item' class='items' required><option value=''>Select</option>";
			
			item += "</select></td>";
			var note = '<td><div class="form-group"><textarea class="form-control" name="item_note[]" required > </textarea>	</div></td>'
			var quantity="<td><input type='number' class='number form-control' name='quantity_indented[]' required /></td></br>";
		    var remove="<td><button value='X' class='btn btn-danger remove show-tip' onclick='$(\"#slot_row_"+rowcount+"\").remove();'><span class='glyphicon glyphicon-trash'></span></button></td>";
			$("#slot_table").append("<tr id='slot_row_"+rowcount+"'>"+sno+item+quantity+ note+remove+"</tr>");

			$selectize = $('[name="item[]"]').selectize({
			labelField: "item_name",
			searchField: "item_name",
			valueField: "item_id",
			options: options,
			// allowEmptyOption: true, 
			// showEmptyOptionInDropdown: true, 
			maxOptions: 10,
			load: function(query, callback) {
				if(!query.length) return callback();
				console.log('loading', $('.selectize-control.items'));
				$($('.selectize-control.items')[rowcount]).addClass('loading');
				$.ajax({
					url: '<?php echo base_url(); ?>consumables/indent/search_selectize_items',
					type: 'POST',
					dataType: 'JSON', 
					data: {query: query, item_type: $('#item_type').val()},
					error: function(res) {
						
						callback();
						$($('.selectize-control.items')[rowcount]).addClass('loading');
						setTimeout(() => {

							$($('.selectize-control.items')[rowcount]).removeClass('loading');
						}, 500);
					},
					success: function(res) {
						
						callback(res.items);
						$($('.selectize-control.items')[rowcount]).addClass('loading');
						setTimeout(() => {
							console.log('delayed loading');
							$($('.selectize-control.items')[rowcount]).removeClass('loading');
						}, 500);
					}
				});
			}
		});

			let item_elements = $("[name='item[]']");
			$("[name='item[]']").change((e) => {
				console.log("Changed", rowcount, e.target.value);
				for(let r = 0; r < item_elements.length; r++){
					if(r != rowcount && $(item_elements[r]).val() == e.target.value){
						console.log("Same");
						console.log(item_elements[r]);
						item_elements[rowcount].selectize.setValue(0);
						return;
					}
				}
			});
		});


		$selectize = $('[name="item[]"]').selectize({
			labelField: "item_name",
			searchField: "item_name",
			valueField: "item_id",
			options: options,
			// allowEmptyOption: true, 
			// showEmptyOptionInDropdown: true, 
			maxOptions: 10,
			load: function(query, callback) {
				if(!query.length) return callback();
				console.log('loading', $('.selectize-control.items'));
				$($('.selectize-control.items')[rowcount]).addClass('loading');
				$.ajax({
					url: '<?php echo base_url(); ?>consumables/indent/search_selectize_items',
					type: 'POST',
					dataType: 'JSON', 
					data: {query: query, item_type: $('#item_type').val()},
					error: function(res) {
						
						callback();
						$($('.selectize-control.items')[rowcount]).addClass('loading');
						setTimeout(() => {

							$($('.selectize-control.items')[rowcount]).removeClass('loading');
						}, 500);
					},
					success: function(res) {
						
						callback(res.items);
						$($('.selectize-control.items')[rowcount]).addClass('loading');
						setTimeout(() => {
							console.log('delayed loading');
							$($('.selectize-control.items')[rowcount]).removeClass('loading');
						}, 500);
					}
				});
			}
		});

		let item_elements = $("[name='item[]']");
		$("[name='item[]']").change((e) => {
			console.log("Changed", rowcount, e.target.value);
			for(let r = 0; r < item_elements.length; r++){
				if(r != rowcount && $(item_elements[r]).val() == e.target.value){
					console.log("Same");
					console.log(item_elements[r]);
					item_elements[rowcount].selectize.setValue(0);
					return;
				}
			}
		});

	});
	
</script>
<script>
$(function(){
$('#to_id  option[value="'+$('#from_id').val()+'"]').hide();
$('#from_id').change(function(){
	$("#to_id option").show();
    var optionval = this.value;
    $('#to_id  option[value="'+optionval+'"]').hide();
    
});
	$selectize = $("[name='item[]']").selectize({
			maxOptions: 10
		});
});
$(function(){
$('#from_id  option[value="'+$('#to_id').val()+'"]').hide();
$('#to_id').change(function(){
	$("#from_id option").show();
    var optionval = this.value;
    $('#from_id  option[value="'+optionval+'"]').hide();
    
});
});
</script>
<style>
#slot_table
{
    counter-reset: Serial;           /* Set the Serial counter to 0 */
    border-collapse: collapse;
}
#slot_table tr td:first-child:before
{
  counter-increment: Serial;      /* Increment the Serial counter */
  content: "" counter(Serial); /* Display the counter */
}
</style>
<?php
	$indent_date=0;
	if($this->input->post('indent_date')) $indent_date=date("d-M-Y",strtotime($this->input->post('indent_date'))); else $indent_date = date("d-M-Y");
	$indent_time=0;
	if($this->input->post('indent_time')) $indent_time=date("H:i",strtotime($this->input->post('indent_time'))); else $indent_time = date("g:i A
	");
	
?>
<div class="center-block">
<?php if($mode=="auto_indent") { ?>
<h2 align="center">Add Indent/Approve/Issue Form</h2></br>
<?php } else{ ?>
	<h2 align="center">Add Indent Form</h2></br>
<?php }?>
	  <?php echo form_open('consumables/indent/add_indent',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
		<div class="col-xs-4 col-md-offset-2">
            <div class="container">
				<div class="row">
                        <div class="col-md-2">  <!--indent date-->
							<div class="form-group">
								<label for="indent_date">Indent Date</label>
							    <input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>" name="indent_date" id="indent_date" size="10"/>
							</div>
						</div>					<!-- end of Indent Date-->
						<div class="col-md-2">	<!-- Indent Time-->
							<div class="form-group">
								<label for="indent_time">Indent Time</label>
								<input  class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("h:i A",strtotime($indent_time)); ?>" name="indent_time" id="indent_time" size="7px"/>
							</div>
						</div>					<!-- end of Indent Time-->
						<div class="col-md-3">	<!-- From party-->
							<div class="form-group">
								<label for="from_id">Indent From Party<font color='red'>*</font></label>
								<select name="from_id" id="from_id" class="form-control" required>
								<option value="">Select</option>
								<?php
								foreach($parties as $fro)
									{
										echo "<option value='".$fro->supply_chain_party_id."'>".$fro->supply_chain_party_name."</option>";
									
									}
								?>
								</select>
							</div>	
						</div>					<!--end of From party-->
						<div class="col-md-3">	<!-- To party-->
							<div class="form-group">
								<label for="to_id">Indent To Party<font color='red'>*</font></label>
								<select name="to_id" id="to_id" class="form-control" required>
								<option value="">Select</option>
								<?php
								foreach($parties as $t)
									{
										echo"<option value='".$t->supply_chain_party_id."'>".$t->supply_chain_party_name."</option>";
									
									}
								?>
								</select>
							</div>	
						</div>					<!-- end of To party-->
			</div>
		</div></br>
						
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-md-offset-1">
					<table style="width:900px;height:100px;text-align:center;border:2px solid #ccc;background:#f6f6f6;border-spacing:10px;" class="table table-bordered" id="slot_table"> 
						<thead>
							<tr id="slot_row_">
								<th class="col-md-1"><center>#</center></th>
								<th class="col-md-4"><center>Item</center></th>
								<th class="col-md-1"><center>Quantity</center></th>
								<th class="col-md-3"><center>Note</center></th>
								<th class="col-md-1"></th>
							</tr>
						 </thead>
							<tr id="slot_row_">
								<td>
								</td>
								<td>
									<div class="form-group">	<!--Item-->
										<select name="item[]" id="item" class="items" required>
										<option value="">Select</option>
										
									   </select>
									 </div>						<!--end of Item-->
								 </td>
			                     <td>
				                       
								<div class="form-group">
										<input type="number" min="1" step="1" class="number form-control" name="quantity_indented[]" required  /></div>
								</td>
								<td>
								<div class="form-group">
										
										<textarea class="form-control" name="item_note[]" required > </textarea>
								</div>
								</td>
								<td><input type="button" id="addbutton" class="btn btn-primary" value="Add+" /></td>
							</tr>
						</table>
					</div>
				 </div>
			</div>
				    
				    <div class="container">			
							<div class="row">
								<div class="col-md-4">
									<div class="form-group form-group-lg">
										<label for="indent_note">Note </label>
										<textarea class="form-control" name="indent_note" id="indent_note" placeholder="Add a note for the indent"></textarea>
									</div>

								</div>
							</div>			
							<div class="row">
								<div class="col-md-9">
									<center><button class="btn btn-primary" type="submit" name="Submit" value="Submit" id="btn">Submit</button>
									<?php if($mode=="auto_indent") { ?>
									<input type="hidden" name="auto_indent" value="1"/>
									<?php }else { ?>
									<input type="hidden" name="auto_indent" value="0"/>
									<?php } ?>
									</center>
								</div>
								
							</div>
					</div>
			</div>
	     <?php echo form_close(); ?> 
	 </div>
		 
	     










				















