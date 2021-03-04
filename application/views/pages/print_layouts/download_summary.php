<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/html2pdf.bundle.min.js"></script>
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
.float_center {
  float: right;

  position: relative;
  left: -50%; /* or right 50% */
  text-align: left;
}
.centerDiv
    {
       display: block;
       border: 1px solid #000000;
       text-align: center ;
       width: 40%;
       height: 36px;
       position: absolute;
       top:0;
	bottom: 0;
	left: 0;
	right: 0;
  	margin: auto;
    }
</style>
<?php if(isset($result) && count($result)>0) { ?>
</style>
<div>
<button class="float_center" type="button" onclick="downloadPDF()">Save to Device</button>
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
<button class="float_center" type="button" onclick="downloadPDF()">Save to Device</button>
</div>
<?php echo form_open("register/notify_summary_download",array('id'=>'notify_summary_download')); ?>
<input type="hidden" name="summary_key" id="summary_key" value="<?php echo $_GET['key']?>" />		
</form>
<?php } else { ?>
<div class="centerDiv"> The page you are looking for is either removed or invaild. <br> Please contact administrator for more details.</div>
<?php } ?>
 

