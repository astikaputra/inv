<style>
.container-fluid
{
background-color:#fff;
}
</style>
<div class="container-fluid">
<div class="row-fluid">
<br />
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
<p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3>Medicine Consumption Report From <?php echo date('d M Y',strtotime($startdate)); ?> Until <?php echo date('d M Y',strtotime($enddate));?></h3>
<br /><br />
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#daily1" data-toggle="tab">Drugs Consumption</a></li>
	<li><a href="#daily2" data-toggle="tab">Retail Patient</a></li>
  </ul>

 <div class="tab-content">
    <div id="daily1" class="tab-pane active">
<table class="table table-striped table-bordered">
        <thead>
                 <tr>
                  <th>Medicine Name</th>
				  <th>Total Presciption</th>
				  <th >Total Consumtion</th>
				 </tr>
              </thead>
              <tbody>
			  
			    <?php 
					$total_medicine_pre = 0;
					$total_medicine_con = 0;					
					foreach ($medicine_data->result() as $data_mdc) { 
					$total_medicine_pre = $total_medicine_pre+$data_mdc->TotalPre;
					$total_medicine_con = $total_medicine_con+$data_mdc->TotalCon; 
					 echo '<tr>';
					 echo '<td>'. $data_mdc->MedicineName.'</td>';
					 echo '<td>'. $data_mdc->TotalPre.'</td>';		
					 echo '<td>'. $data_mdc->TotalCon.'</td>';
					 echo '</tr>';                    
				 }; ?>
		    <br />
			<tfoot>
			<tr class="active">
			<td style="font-size: 20px;"><b>Total</b></td>
			<td style="font-size: 20px;"><b><?php echo $total_medicine_pre;?></b></td>
			<td style="font-size: 20px;"><b><?php echo $total_medicine_con;?></b></td>
			</tr>
			</tfoot>
			</tbody>
    </table>
</div>

 <div id="daily2" class="tab-pane">
 <table class="table table-striped table-bordered">
        <thead>
                 <tr>
				 <th>Presciption Number</th>
                  <th>Patient Name</th>
				  <th>Create Date</th>
				  <th >Create By</th>
				 </tr>
              </thead>
              <tbody>
			  
			   <?php
			foreach ($medicine_data_retail->result() as $retail_mdc) {	?>
			<tr>
			 <td><?php echo $retail_mdc->Presnum; ?></td>
			 <td><?php echo $retail_mdc->PatientName; ?></td>
			 <td><?php echo $retail_mdc->CreateDate; ?></td>
			<td><?php echo $retail_mdc->CreatedBy; ?></td>
			</tr>                             
				<?php } ?>
			</tbody>
    </table>
 </div>
 
</div>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>
