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
	text-align: left!important;
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
    var rowcount = 0;
    var currentPartyType = null;
    let options = <?= json_encode($all_item); ?>;

    // Pre-process items for Selectize display
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

    $(function() {
        $("#indent_date").Zebra_DatePicker({ direction: false });
        $("#indent_time").ptTimeSelect();

        $("#from_id").change(function() {
            let from_id = $(this).val();
            if (from_id) {
                $.ajax({
                    url: '<?php echo base_url(); ?>consumables/indent/check_party_type',
                    type: 'POST',
                    dataType: 'JSON',
                    data: { from_id: from_id },
                    success: function(res) {
                        currentPartyType = res.is_external; // 1 = internal, 2 = external
                    }
                });
            } else {
                currentPartyType = null;
            }
            $("#to_id option").show();
            $('#to_id option[value="' + this.value + '"]').hide();
        }).trigger('change');

        $('#to_id').change(function() {
            $("#from_id option").show();
            $('#from_id option[value="' + this.value + '"]').hide();
        }).trigger('change');
        
        function initSelectize($selector) {
             $selector.selectize({
                labelField: "item_name",
                searchField: "item_name",
                valueField: "item_id",
                options: options,
                maxOptions: 10,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    let $selectizeControl = $selector.closest('.selectize-control.items');
                    $selectizeControl.addClass('loading');
                    
                    $.ajax({
                        url: '<?php echo base_url(); ?>consumables/indent/search_selectize_items',
                        type: 'POST',
                        dataType: 'JSON',
                        data: { query: query, item_type: $('#item_type').val() },
                        success: function(res) {
                            callback(res.items);
                            setTimeout(() => $selectizeControl.removeClass('loading'), 500);
                        },
                        error: function() {
                            callback();
                            setTimeout(() => $selectizeControl.removeClass('loading'), 500);
                        }
                    });
                }
            });
        }
        
        initSelectize($("[name='item[]']").eq(0));

        $("#addbutton").click(function() {
            rowcount++;
            var sno = "<td>" + " " + "</td>";
            var item = "<td><div class='form-group'><select name='item[]' class='items' required><option value=''>Select</option></select></div></td>";
            var note = '<td><div class="form-group"><textarea class="form-control" name="item_note[]" required></textarea></div></td>';
            var quantity = "<td><input type='number' min='1' step='1' class='number form-control' name='quantity_indented[]' required /></td>";
            var remove = "<td><button type='button' class='btn btn-danger remove show-tip' onclick='$(\"#slot_row_" + rowcount + "\").remove();'><span class='glyphicon glyphicon-trash'></span></button></td>";

            $("#slot_table").append("<tr id='slot_row_" + rowcount + "'>" + sno + item + quantity + note + remove + "</tr>");

            initSelectize($('#slot_row_' + rowcount + ' select[name="item[]"]'));
        });
        
        $("#slot_table").on('change', 'select[name="item[]"]', function(e) {
            let selectedItemId = e.target.value;
            let $itemElements = $("[name='item[]']");
            let currentIndex = $itemElements.index(this);

            for (let r = 0; r < $itemElements.length; r++) {
                if (r !== currentIndex && $($itemElements[r]).val() === selectedItemId && selectedItemId !== "") {
                    alert("This item has already been selected in another row!");
                    let $selectizeInstance = $itemElements[currentIndex].selectize;
                    if ($selectizeInstance) {
                       $selectizeInstance.setValue(""); 
                    }
                    return;
                }
            }
        });


        $("#evaluate_applicant").submit(function(e) {
            if ($(this).data('is-override')) {
                return true;
            }
            
            if (currentPartyType != 1) {
                return true;
            }

            e.preventDefault();

            let $form = $(this);
            let itemSelects = $form.find('select[name="item[]"]');
            let lowBalanceItems = [];

            if ($("#from_id").val() === "" || $("#to_id").val() === "") {
                 alert("Please select both Indent From and Indent To parties.");
                 return;
            }
            if (itemSelects.length === 0 || itemSelects.filter(function() { return $(this).val() === ""; }).length > 0) {
                 alert("Please ensure all item rows have a selected item.");
                 return;
            }
			let fromPartyId = $('#from_id').val();
            let balancePromises = itemSelects.map(function() {
                let itemId = $(this).val();
                let itemText = $(this).next().find('.selectize-input').find('.item').text() || itemId;

                return new Promise((resolve) => {
                    $.ajax({
                        url: '<?php echo base_url(); ?>consumables/indent/check_item_balance',
                        type: 'POST',
                        dataType: 'JSON',
                        data: { item_id: itemId,
                				from_id: fromPartyId 
							},
                        success: function(res) {
                            if (res.balance <= 0) {
                                lowBalanceItems.push(itemText);
                            }
                            resolve();
                        },
                        error: function() {
                            lowBalanceItems.push(itemText + " (Balance Check Failed)");
                            resolve();
                        }
                    });
                });
            }).get();

            Promise.all(balancePromises).then(() => {
                if (lowBalanceItems.length > 0) {
                    $('#lowBalanceItemsList').empty();
                    lowBalanceItems.forEach(item => {
                        $('#lowBalanceItemsList').append('<li>' + item + '</li>');
                    });
                    $('#balanceWarningModal').modal('show');
                } else {
                    $form.data('is-override', true); 
                    this.submit();
                }
            });
        });

        $('#confirmSubmitBtn').off('click').on('click', function() {
            $('#balanceWarningModal').modal('hide');
            
            const $form = $("#evaluate_applicant");
            const formElement = document.getElementById('evaluate_applicant');
        
            if ($form.find('input[name="Submit"]').length === 0) {
                 $('<input>').attr({
                    type: 'hidden',
                    name: 'Submit', 
                    value: 'Submit'
                }).appendTo($form);
            }
            $form.data('is-override', true);
            formElement.submit();
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
		<div class="col-xs-12 col-md-offset-1">
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
				<div class="col-md-12">
					<table style="width:950px;height:100px;text-align:center;border:2px solid #ccc;background:#f6f6f6;border-spacing:10px;" class="table table-bordered" id="slot_table"> 
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
								<td style="width:55%;">
									<div class="form-group">	<!--Item-->
										<select name="item[]" id="item" class="items" required>
										<option value="">Select</option>
										
									   </select>
									 </div>						<!--end of Item-->
								 </td>
			                     <td style="width:7%;">
				                       
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
					<div class="col-md-3"></div>
					<div class="col-md-4">
						<div class="form-group form-group-lg">
							<label for="indent_note">Note </label>
							<textarea class="form-control" name="indent_note" id="indent_note" placeholder="Add a note for the indent"></textarea>
						</div>
					</div>
					<div class="col-md-3"></div>
				</div>			
				<div class="row">
					<div class="col-md-10">
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

<div class="modal fade" id="balanceWarningModal" tabindex="-1" role="dialog" aria-labelledby="balanceWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="balanceWarningModalLabel"> Insufficient Balance </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                You do not have sufficient balance for the following item(s) to approve. 
                <ul id="lowBalanceItemsList" class="mt-2"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSubmitBtn">Proceed Anyway</button>
            </div>
        </div>
    </div>
</div>