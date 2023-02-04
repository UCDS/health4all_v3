<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script>
  $(function(){
    $("#barcode")
      .barcode("<?php echo $registered->patient_id;?>",'code128',{barWidth:2, barHeight:20,showHRI:false});
  });
</script>
<style>
@media print{
  @page {
    size: A4 landscape;
  }
  .padding-adjustment{
    padding-top: 44mm;
    padding-left: 150mm;
  }
  .a6-label-css {
    width: 5.83in;
    height: 4.13in;
    border: 0.1em black dashed;
    font-size:20px;
  }  
}
</style>
<?php 
  $relative = '';
  if($registered->father_name != '')
    $relative = $registered->father_name;
  else if($registered->mother_name != '')
    $relative = $registered->mother_name;
  else if($registered->spouse_name != '')
    $relative = $registered->spouse_name;
  $admit_date = date_create($registered->admit_date);
  $admit_date = date_format($admit_date, 'd-M-Y');
  $admit_time = strtotime($registered->admit_time);
  $admit_time = date('h:i A', $admit_time);
  $hospital= $this->session->userdata('hospital');
  $hospital_name = $hospital['hospital_short_name'];
?>
<div class='padding-adjustment'>
<table cellpadding='8' class='a6-label-css'>

<tr>
    <td> <?php echo $hospital_name;?> </td>
    
  </tr>
  <tr>
    <td ><b>Patient ID:</b> <?php echo $registered->patient_id;?></td>
    <td id='barcode'></td>
  </tr>
  <tr>
    <td colspan='2'><b>OP Number:</b> <?php echo $registered->hosp_file_no.', '.$admit_date.', '.$admit_time;?></td>
  </tr>
  <tr>
    <td ><b>Department:</b> <?php echo $registered->department;?></td>
    
  </tr>
  <tr>
  <tr>
    <td><b>Name:</b> <?php echo ' '.$registered->name.', '.$registered->age_years.'Y/'.$registered->gender;?></td>
    <td><b>Relative:</b> <?php echo $relative; ?> </td>
  </tr>
  <tr>    
    <td><b>Address:</b> <?php echo $registered->address; ?></td>
    <td><b>Phone:</b> <?php echo ' '.$registered->phone;?></td>
  </tr>
  <!-- <tr>
    <td>
    <b>Weight:</b> <?php //echo $registered->admit_weight; ?>&emsp;
    <b>BP:</b> <?php //echo $registered->sbp.'/'.$registered->dbp; ?>&emsp;
    <b>Pulse:</b> <?php //echo $registered->pulse_rate; ?>
    </td>
  </tr>
  <tr valign='top' colspan='2'>
    <td><b>Tests:</b></td>
  </tr>             -->
</table>
</div>
