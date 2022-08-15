<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
 <script>
 var index=0;

function removeImage(index) {
$("body").addClass("loading"); 
var jsonData = {};
jsonData.patient_id = "<?php echo $result[0]->patient_id;?>";
jsonData.globalImageIndex = index;
jsonData.document_link = document.getElementById("PatientDocFullName"+index).innerHTML; 
var target = '<?php echo base_url();?>register/deleting_documents';
$.ajax({
   url: target,
   type: 'POST',					
   dataType: "JSON",
   data: jsonData, 
   success: function(response) { $('#PatientDoc'+ response.globalImageIndex).remove(); $("body").removeClass("loading"); },
   error : function(response) {  $("body").removeClass("loading");bootbox.alert("Error in removing the file");   }
});
								
}

function showImageHereFunc() {
  var total_file=document.getElementById("uploadImageFile").files.length;
  
  if (total_file <= 0){
  	return;
  }
  $("body").addClass("loading"); 
  for(var i=0;i<total_file;i++) { 
	document.getElementById("imageIndex").value=i;
	document.getElementById("globalImageIndex").value=index;
	var globalIndex = document.getElementById("globalImageIndex").value;
	var imgUrl = URL.createObjectURL(event.target.files[i]); 
	if (event.target.files[i].type.toLowerCase().includes('pdf')){
		imgUrl = "<?php echo base_url();?>assets/images/pdf_logo.png";
	}
	$('#showImageHere').append("<div id='PatientDoc"+globalIndex+"' class='imgcontainer' hidden> <img src='"+imgUrl+"' height='100px' width='100px'/><br><br> <button type=\"button\" class=\"close\" aria-label=\"Close\" data-toggle=\"tooltip\" title=\"Remove document\" onclick='removeImage("+globalIndex+")'\"> <span aria-hidden=\"true\">&times;</span> </button> <div>"+ event.target.files[i].name.slice(0,20)+" - "+ event.target.files[i].type +"</div> </div><div id='PatientDocFullName"+globalIndex+"' hidden>"+event.target.files[i].name+ "</div>");
	$('#showImageHere').append("<div id='PatientDocProgress"+globalIndex+"'>  <div>"+ event.target.files[i].name.slice(0,20)+" - "+ event.target.files[i].type +"</div> <div class=\'progress\' id=\"progressDivId\">  <div class=\'progress-bar\' id='progressBar"+globalIndex+"'> <div class=\'percent\' id='percent"+globalIndex+"'>0%</div> </div>  </div> </div>");
	// Get form
        var form = document.getElementById('imageInputForm');

        // Create an FormData object 
        var data = new FormData(form);
  $.ajax({
   xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        var gi =  JSON.parse(JSON.stringify(globalIndex)); 
        xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {   
           var percentComplete = e.loaded / e.total;                    
           var percentValue = Math.round(percentComplete*100);
           if(percentValue <= 100){
           	if(percentValue <= 100){
                   var percentCompletedText = percentValue + '%';
                   $("#progressBar"+gi).css("width",percentCompletedText);
                   $("#percent"+gi).text(percentCompletedText);
              }	
    	     
    	     }
    	   }
    	          
        };
        return xhr;
    },
                type: "POST",
	        url: $('#imageInputForm').attr('action'),
	        data: data,
	        processData: false,
	        contentType: false,
	        cache: false,
	        enctype: 'multipart/form-data',
            success: function (data) {        
         	$("#PatientDoc"+data.globalImageIndex).show();
               $("#PatientDocProgress"+data.globalImageIndex).hide();
               $("body").removeClass("loading");
               document.getElementById("uploadImageFile").value = ""; 
               bootbox.alert("Document uploaded successfully");
            },
             error: function(data) {
          	$("#PatientDocProgress"+data.responseJSON.globalImageIndex).hide();
          	$("#PatientDoc"+data.responseJSON.globalImageIndex).hide();
          	$("body").removeClass("loading");
          	document.getElementById("uploadImageFile").value = ""; 
          	bootbox.alert(data.responseJSON.messages);
        }
          });         
    index = index + 1;
  }    
        
}

 </script> 
<style>

input[type="file"]{
   display: none;
}
#fileupload:hover{
color:#990000;
}
.imgcontainer:hover{
background-color:#e6eeff;
}
.imgcontainer{
margin:5px;
}

.float_center {
  position: relative; /* or absolute */
  top: 0%;
  left: 50%;
  transform: translate(-50%, 0%);
}

#inner {
  display: table;
  margin: 0 auto;
}

#outer {
  width:100%;
}
body{
min-width:260px;
}

.progress-bar {
    background-color: #0000ff;
    width: 0%;
    height: 30px;
    border-radius: 4px;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
}

.percent {
    position: absolute;
    display: inline-block;
    font-weight: bold;
    -webkit-border-radius: 4px;
    margin-left: -12px;
}
.footer {
    bottom: 0;
    top:1%;
    left: 0;
    position: relative; //changed to relative from fixed also works if position is not there
    font-size: small;
    width:100%;
    text-align:center;
  
}

.loading_model {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('<?=base_url()?>assets/images/spinner.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading .loading_model {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .loading_model {
    display: block;
}
</style>
<title><?php echo $title;?></title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<div id="outer">
  <div id="inner"><h4><b>Instructions</b></h4> 
<ul>
  <li>File type should be <?php echo $allowed_types;?>. </li>
  <li>File size should not exceed <?php echo $max_size/1024;?> MB.</li>
  <li>Image dimension should not exceed <?php echo $max_width?>x<?php echo $max_height?>.</li>
</ul> 
<div style="text-align: center;"> <b> Patient Name: <?php echo $result[0]->name;?> (ID: <?php echo $result[0]->patient_id;?>)</b></div>
</div>

</div>

<div style="border:2px dashed black;border-radius:15px;width:250px;background-color:#f5f5f0;margin-top:1%" class="float_center">
<?php echo form_open("register/uploading_docs",array('role'=>'form','class'=>'form-custom','id'=>'imageInputForm','enctype'=>'multipart/form-data')); ?> 
<input type="hidden" id="imageIndex" name="imageIndex">
<input type="hidden" id="globalImageIndex" name="globalImageIndex">
<input type="hidden" id="patient_id" name="patient_id" value=<?php echo $result[0]->patient_id;?>>
<label class="custom-file-upload" style="text-align:center;margin-left:26%;color:#3333ff;">
      <input type="file" id="uploadImageFile" name="uploadImageFile[]" title="" onchange="showImageHereFunc();"/>
        <span id="fileupload"><u> Browse Documents </u> </span>
</label>
    </form>
    <div id="showImageHere"></div>
</div>

<div class="footer">
<div id="inner">
<b>Close the page after the document upload. </b>
  <p><i>This page will expire at <?php echo date("j-M-Y h:i A",strtotime($result[0]->expires_at));?> </i></p>
</div> 
</div> 
<div class="modal loading_model"></div>
