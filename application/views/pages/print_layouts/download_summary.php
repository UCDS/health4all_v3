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
  html2canvas:  { scale:  2 },
  jsPDF:        { unit: 'in', format: 'a3', orientation: 'portrait' }
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
  margin: 0 auto;
}
.container {
  display: flex;
  justify-content: center;
}
</style>
<?php if(isset($result) && count($result)>0) { ?>
</style>
<title><?php echo $title;?></title>
<div class="container">
<button class="btn btn-md btn-primary float_center" type="button" onclick="downloadPDF()">Save to Device</button>
<br/>
</div>
<br/>
<div id="content">
<?php 
echo base64_decode($result[0]->summary_link_contents);
?>
</div>
<div class="container">
<br/>
<button class="btn btn-md btn-primary float_center" type="button" onclick="downloadPDF()">Save to Device</button>
</div>
<?php echo form_open("register/notify_summary_download",array('id'=>'notify_summary_download')); ?>
<input type="hidden" name="summary_key" id="summary_key" value="<?php echo $_GET['key']?>" />		
</form>
<?php } ?>
 

