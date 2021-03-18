<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/html2pdf.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
<script>
 
function downloadPDF(){
var element = document.getElementById('content');
var opt = {
  margin:       0.5,
  filename:     'ConsultationSummary.pdf',
  image:        { type: 'jpeg', quality: 1 },
  html2canvas:  { scale:  1 },
  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
};
html2pdf(element, opt);

$.ajax({
  type: 'POST',
  url: $("#notify_summary_download").attr("action"),
  data: $("#notify_summary_download").serialize()
});

}



</script>
<style>
tr {page-break-inside: avoid}
.float_center {
  float: right;

  position: relative;
  left: -50%; /* or right 50% */
  text-align: left;
}
</style>
<?php if(isset($result) && count($result)>0) { ?>
</style>
<title><?php echo $title;?></title>
<div>
<button class="btn btn-md btn-primary float_center" type="button" onclick="downloadPDF()">Save to Device</button>
<br/>
</div>
<br/>
<div id="content">
<?php 
echo base64_decode($result[0]->summary_link_contents);
?>
</div>
<div>
<br/>
<button class="btn btn-md btn-primary float_center" type="button" onclick="downloadPDF()">Save to Device</button>
</div>
<?php echo form_open("register/notify_summary_download",array('id'=>'notify_summary_download')); ?>
<input type="hidden" name="summary_key" id="summary_key" value="<?php echo $_GET['key']?>" />		
</form>
<?php } ?>
 

