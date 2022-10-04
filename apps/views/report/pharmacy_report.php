<div class="container-fluid">
<h3>Pharmacy Report <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?> </h3>
<div class="row well">

<div class="accordion" id="datadoctor">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle  btn btn-primary" data-toggle="collapse" data-parent="#datadoctor" href="#summary">
         <b>Summary</b>
      </a>
    </div>
    <div id="summary" class="accordion-body collapse in">
      <div class="accordion-inner">
	  <div class="row-fluid">
		<div class="span6">
		<h4><?php echo $hospital_name;?></h4>
			<div class="alert alert-info">
				<h4>Total Prescription Create :</h4>
			</div>
			<div class="alert alert-info">
				<h4>Total Drugs Usage : </h4>
			</div>
		</div>
	
		<!-- Detailed Data-->
		<div class="span6">
        <h4 style="text-align: center;">Top 10 Drugs Usage</h4>
            <table class="table table-bordered" >
            <thead>
		  <tr>
			<th>Drugs Code</th><th>Drugs Name</th><th>Total Usage</th><th>Prescription</th>
          </tr>
	       </thead>
	       <tbody>
            <tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</tbody>
            </table>
		</div>
		</div>
        </div>
        </div>
        </div>


  
 
	    <div class="span12 back pull-right">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Kembali Ke Menu Utama</a>
		</div>		

</div> 
 
