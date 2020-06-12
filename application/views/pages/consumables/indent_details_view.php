<script type="text/javascript">
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}
</script>
		<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
		<div id="print-div" class="sr-only" style="width:100%;height:100%;"> 
		<center>
		<h3><?php echo $register[0]->hospital;?></h3>
		<h3>Indent</h3><hr>
		</center>
		<label style="float:left"><b>Indent Id:</b> <?php echo $register[0]->indent_id;?></br></label>
		<label style="float:right"><b>From:</b> <?php echo $register[0]->from_party_name;?></label><br>
		 <label style="float:left"> <b>Indent Date:</b> <?php echo date("d-M-Y g:i A", strtotime($register[0]->indent_date)); ?></label>
		<label style="float:right"><b>To:</b> <?php echo $register[0]->to_party_name;?></label><br><br><br>
		<center>
		<table style=" border:1px solid black;width:100%;border-collapse: collapse;">
			<thead style="height:50px">
				<th style="text-align:center;border:1px solid black;">#</th>
				<th style="text-align:center;border:1px solid black;">Items</th>
				<th style="text-align:center;border:1px solid black;">Quantity</th>
			</thead>
			<tbody>
			<?php $i=1; 
		foreach($register as $r){ ?>
			<tr>
				<td style="border:1px solid black;  padding: 15px;  height: 50px;" align="center"><?= $i++; ?></td>
				<td style="border:1px solid black;  padding: 15px;  height: 50px;" align="left"><?php echo $r->item_name."-".$r->item_form."-".$r->item_type."-".$r->dosage.$r->dosage_unit?></td>
				<td style="border:1px solid black;  padding: 15px;  height: 50px;" align="right"><?php echo $r->quantity_indented?></td>
		    </tr>
			<?php } ?>
			</tbody>
		</table></br>	</center>
		<b>Indented by:</b><?php echo $register[0]->first_name." ".$register[0]->last_name;?></br></br></br>
		<b>Signature:</b>
			
		
		
		
		</div>
		  <?php echo form_open('consumables/indent/add_indent',array('role'=>'form'))   ?>
		  <div class="col-md-12 col-md-offset-1">
		  <?php if($register[0]->indent_status=='Issued') { ?>
		     <center> <div class="alert alert-info"><h4>Indent added/approved/issued Succesfully</h4></div></center>
		  <?php } else { ?>
		<center> <div class="alert alert-info"><h4>Indent added Succesfully</h4></div></center>
		  <?php } ?>
		  </div>
		  
  <div class="col-xs-4 col-md-offset-2">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-success">
					<div class="panel-heading">
						<center>	
							<h3>Indent Order</h3>
						</center>
					</div> 
					<div class="panel-body">
						<form class="span9">
							<div class="span3">
								<div class="col-md-6">									<!--Indent Id-->
									<label><b>Indent Id:</b> <?php echo $register[0]->indent_id;?></label>
								</div>													<!--end Indent Id-->
								<div class="span3">											<!-- From party-->
									<div class="col-md-6">
										<label><b>From:</b> <?php echo $register[0]->from_party_name;?></label>
									</div>
								</div>														<!--end of From party-->
								<div class="col-md-6">									<!--Indent Date-->
									<label><b>Date:</b> 	
										<?php echo date("d-M-Y g:i A", strtotime($register[0]->indent_date)); ?>
									</label>
								</div>													<!--end of Indent Date-->
							</div>
							<div class="span3">											<!-- To party -->
								<div class="col-md-6">
									<label><b>To:</b> <?php echo $register[0]->to_party_name;?></label>
								</div>
							</div>														<!--end of To party-->
						</form></br>
						
						<div class="container">
							<div class="row"> 
								<center><div class="col-md-8">
									<table class="table table-bordered table-striped">
										<thead>
												<th class="col-md-1"style="text-align:center" rowspan="3">#</th>
												<th class="col-md-3"style="text-align:center" rowspan="3">Items</th>
												<th class="col-md-1"style="text-align:center" rowspan="3">Quantity</th>
										</thead>
										<tbody>
											<?php $i=1; 
												foreach($register as $r){ ?>
													<tr>
														<td align="center"><?= $i++; ?></td>
														<td><?php echo $r->item_name."-".$r->item_form."-".$r->item_type."-".$r->dosage.$r->dosage_unit?></td>
														<td align="right"><?php echo $r->quantity_indented?></td>
													</tr>
											<?php } ?>
										</tbody>
									</table>
								</div></center>
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-success">
					<div class="panel-footer">
					 <?php if($register[0]->indent_status=='Issued') { ?>
					 <b>Indented/Approved/Issued by :</b><?php echo $register[0]->first_name." ".$register[0]->last_name ;?>
					 <?php } else { ?>
					<b>Indented by :</b><?php echo $register[0]->first_name." ".$register[0]->last_name ;?>
					 <?php } ?>
					</div>  
				</div>
			</div>
		</div>
	</div>
	</div>
	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<center>	<button type="button" class="btn btn-primary " onClick="printDiv('print-div')" autofocus>Print</button></center>
			</div>
		</div>
	</div>
	
					<?php// } ?>
		
	<?php echo form_close(); ?> 
	