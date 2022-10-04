<style>
.container-fluid
{
background-color:#fff;
}
</style>
<div class="container-fluid">
<br />
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">
<p class="hospital_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3><?php echo $los_title;?></h3>

<table class="table table-bordered" id="monthly_los_grid">
        <thead>
                 <tr>
                  <th rowspan="2">Month</th>
				  <th colspan="2">Medical Rehab</th>
				  <th rowspan="2">Total</th>
				  <th colspan="4">Diagnostic</th>
				  <th rowspan="2">Total</th>
				  <th colspan="4">Laboratory</th>
				  <th rowspan="2">Total</th>
				  <th colspan="4">Radiology</th>
				  <th rowspan="2">Total</th>
				  <th colspan="4">By Patient Request</th>
				 </tr>
				 <tr>
				  <th>OPD</th>
				  <th>IPD</th>
				  <th>OPD</th>
				  <th>ETC</th>
				  <th>MCU</th>
				  <th>IPD</th>
				  <th>OPD</th>
				  <th>ETC</th>
				  <th>IPD</th>
				  <th>MCU</th>
				  <th>OPD</th>
				  <th>ETC</th>
				  <th>IPD</th>
				  <th>MCU</th>
				  <th>Med.Rehab</th>
				  <th>Diagnostic</th>
				  <th>Laboratory</th>
				  <th>Radiology</th>					  
				 </tr>
              </thead>
              <tbody>
			  <?php
			//--- Initial value ---/
			  $total_med_rehab_OPD = 0;
			  $total_med_rehab_IPD = 0;
			  $total_diagnostic_ETC = 0;
			  $total_diagnostic_MCU= 0;
			  $total_diagnostic_OPD = 0;
			  $total_diagnostic_IPD = 0;
			  $total_laboratory_ETC = 0;
			  $total_laboratory_MCU = 0;
			  $total_laboratory_OPD = 0;
			  $total_laboratory_IPD = 0;
			  $total_radiology_ETC = 0;
			  $total_radiology_MCU = 0;
			  $total_radiology_OPD = 0;
			  $total_radiology_IPD = 0;
			  $total_med_rehab_retail = 0;
			  $total_diagnostic_retail = 0;
			  $total_laboratory_retail = 0;
			  $total_radiology_retail = 0;			  
			  
			  for($i=1;$i<=12;$i++) { 
			//--- Medical Rehab OPD ---/	
			$medical_rehab_OPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Medical Rehabilitation'", 'OPD', $repyear, $i, 'Regular');
			$total_med_rehab_OPD =  $total_med_rehab_OPD + $medical_rehab_OPD;			
			//--- Medical Rehab IPD ---/  
			$medical_rehab_IPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Medical Rehabilitation'", 'IPD', $repyear, $i, 'Regular');
			$total_med_rehab_IPD =  $total_med_rehab_IPD + $medical_rehab_IPD;			  
			
			//--- Diagnostic ETC ---/    
			$diagnostic_ETC = $this->monthly_los_model->get_diagnostic_report( "'TREADMILL TEST','ECHOKARDIOGRAM','ECG','ABPM','HOLTER MONITORING','STRESS ECHO','TRANSESOPHAGEAL ECHO'", 'ETC', $repyear, $i, 'Regular');
			$total_diagnostic_ETC =  $total_diagnostic_ETC + $diagnostic_ETC;
			//--- Diagnostic MCU ---/    
			$diagnostic_MCU = $this->monthly_los_model->get_diagnosticmcu_report( "'TREADMILL TEST','ECHOKARDIOGRAM','ECG','ABPM','HOLTER MONITORING','STRESS ECHO','TRANSESOPHAGEAL ECHO'", 'MCU', $repyear, $i, 'Regular');
			$total_diagnostic_MCU =  $total_diagnostic_MCU + $diagnostic_MCU;
			//--- Diagnostic OPD ---/    
			$diagnostic_OPD = $this->monthly_los_model->get_diagnostic_report( "'TREADMILL TEST','ECHOKARDIOGRAM','ECG','ABPM','HOLTER MONITORING','STRESS ECHO','TRANSESOPHAGEAL ECHO'", 'OPD', $repyear, $i, 'Regular');
			$total_diagnostic_OPD =  $total_diagnostic_OPD + $diagnostic_OPD;
			//--- Diagnostic IPD ---/    
			$diagnostic_IPD = $this->monthly_los_model->get_diagnostic_report( "'TREADMILL TEST','ECHOKARDIOGRAM','ECG','ABPM','HOLTER MONITORING','STRESS ECHO','TRANSESOPHAGEAL ECHO'", 'IPD', $repyear, $i, 'Regular');
			$total_diagnostic_IPD =  $total_diagnostic_IPD + $diagnostic_IPD;
			
			//--- Laboratorium ETC ---/    
			$laboratory_ETC = $this->monthly_los_model->get_montlyreg_lob_report( "'Laboratory'", 'ETC', $repyear, $i, 'Regular');
			$total_laboratory_ETC =  $total_laboratory_ETC + $laboratory_ETC;
			//--- Laboratorium MCU ---/    
			$laboratory_MCU = $this->monthly_los_model->get_montlyreg_mcu_report( "'Laboratory'", 'MCU', $repyear, $i, 'Regular');
			$total_laboratory_MCU =  $total_laboratory_MCU + $laboratory_MCU;
			//--- Laboratorium OPD ---/    
			$laboratory_OPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Laboratory'", 'OPD', $repyear, $i, 'Regular');
			$total_laboratory_OPD =  $total_laboratory_OPD + $laboratory_OPD;
			//--- Laboratorium IPD ---/    
			$laboratory_IPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Laboratory'", 'IPD', $repyear, $i, 'Regular');
			$total_laboratory_IPD =  $total_laboratory_IPD + $laboratory_IPD;
			
			//--- Radiology ETC ---/    
			$radiology_ETC = $this->monthly_los_model->get_montlyreg_lob_report( "'Radiology'", 'ETC', $repyear, $i, 'Regular');
			$total_radiology_ETC =  $total_radiology_ETC + $radiology_ETC;
			//--- Radiology MCU ---/    
			$radiology_MCU = $this->monthly_los_model->get_montlyreg_mcu_report( "'Radiology'", 'MCU', $repyear, $i, 'Regular');
			$total_radiology_MCU =  $total_radiology_MCU + $radiology_MCU;
			//--- Radiology OPD ---/    
			$radiology_OPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Radiology'", 'OPD', $repyear, $i, 'Regular');
			$total_radiology_OPD =  $total_radiology_OPD + $radiology_OPD;
			//--- Radiology IPD ---/    
			$radiology_IPD = $this->monthly_los_model->get_montlyreg_lob_report( "'Radiology'", 'IPD', $repyear, $i, 'Regular');
			$total_radiology_IPD =  $total_radiology_IPD + $radiology_IPD;	
			
			//---- Medical Rehab Retail ----//
			$medical_rehab_retail = $this->monthly_los_model->get_montlyreg_los_retail_report("'Medical Rehabilitation'", $repyear, $i, 'Retail');
			$total_med_rehab_retail = $total_med_rehab_retail + $total_med_rehab_retail;
			//---- Diagnostic Retail ----//
			$medical_diagnostic_retail = $this->monthly_los_model->get_diagnosticmcu_report("'TREADMILL TEST','ECHOKARDIOGRAM','ECG','ABPM','HOLTER MONITORING','STRESS ECHO','TRANSESOPHAGEAL ECHO'",'MCU',$repyear, $i, 'Retail');
			$total_diagnostic_retail = $total_diagnostic_retail + $medical_diagnostic_retail;
			//---- Laboratory Retail ----//
			$medical_laboratory_retail = $this->monthly_los_model->get_montlyreg_los_retail_report("'Laboratory'", $repyear, $i, 'Retail');
			$total_laboratory_retail = $total_laboratory_retail + $medical_laboratory_retail;
			//---- Radiology Retail ----//
			$medical_radiology_retail = $this->monthly_los_model->get_montlyreg_los_retail_report("'Radiology'", $repyear, $i, 'Retail');
			$total_radiology_retail = $total_radiology_retail + $medical_radiology_retail;			
			  
			  ?>
			  <tr>
			  <td><?php echo $monthname[$i];?></td>
			  <td><?php echo $medical_rehab_OPD;?></td>
			  <td><?php echo $medical_rehab_IPD;?></td>
			 <!--Total Medical Rehab-->
			  <td><b><?php echo ($medical_rehab_OPD + $medical_rehab_IPD);?></b></td>
			  <td><?php echo $diagnostic_OPD;?></td>
			  <td><?php echo $diagnostic_ETC;?></td>
			  <td><?php echo $diagnostic_MCU;?></td>
			  <td><?php echo $diagnostic_IPD;?></td>
			 <!--Total Diagnostic-->
			  <td><b><?php echo ($diagnostic_OPD + $diagnostic_ETC + $diagnostic_MCU + $diagnostic_IPD);?></b></td>
			  <td><?php echo $laboratory_OPD;?></td>
			  <td><?php echo $laboratory_ETC;?></td>
			  <td><?php echo $laboratory_IPD;?></td>
			  <td><?php echo $laboratory_MCU;?></td>
			 <!--Total laboratory-->
			  <td><b><?php echo ($laboratory_ETC + $laboratory_MCU + $laboratory_OPD + $laboratory_IPD);?></b></td>
			  <td><?php echo $radiology_OPD;?></td>
			  <td><?php echo $radiology_ETC;?></td>
			  <td><?php echo $radiology_IPD;?></td>
			  <td><?php echo $radiology_MCU;?></td>
			 <!--Total Diagnostic-->
			  <td><b><?php echo ($radiology_ETC + $radiology_MCU + $radiology_OPD + $radiology_IPD);?></b></td>
			 <!--Total Retail LOS-->
			  <td><?php echo $medical_rehab_retail;?></td>
			  <td><?php echo $medical_diagnostic_retail;?></td>
			  <td><?php echo $medical_laboratory_retail;?></td>	
			  <td><?php echo $medical_radiology_retail;?></td>	
			  </tr>

			  <?php } ?>
			  <tr>
			  <td><b>Total</b></td>
			  <td><b><?php echo  number_format($total_med_rehab_OPD); ?></b></td>
			  <td><b><?php echo  number_format($total_med_rehab_IPD); ?></b></td>
			  <td><b><?php echo  number_format(($total_med_rehab_OPD + $total_med_rehab_IPD)); ?></td>
			  
			  <td><b><?php echo  number_format($total_diagnostic_OPD); ?></b></td>
			  <td><b><?php echo  number_format($total_diagnostic_ETC); ?></b></td>
			  <td><b><?php echo  number_format($total_diagnostic_MCU); ?></b></td>	
			  <td><b><?php echo  number_format($total_diagnostic_IPD); ?></b></td>	
			  <td><b><?php echo  number_format(($total_diagnostic_OPD + $total_diagnostic_ETC + $total_diagnostic_MCU + $total_diagnostic_IPD)); ?></td>
			  
			  <td><b><?php echo  number_format($total_laboratory_OPD); ?></b></td>
			  <td><b><?php echo  number_format($total_laboratory_ETC); ?></b></td>
			  <td><b><?php echo  number_format($total_laboratory_IPD); ?></b></td>	
			  <td><b><?php echo  number_format($total_laboratory_MCU); ?></b></td>	
			  <td><b><?php echo  number_format(($total_laboratory_OPD + $total_diagnostic_ETC + $total_laboratory_IPD + $total_laboratory_MCU)); ?></td>

			  <td><b><?php echo  number_format($total_radiology_OPD); ?></b></td>
			  <td><b><?php echo  number_format($total_radiology_ETC); ?></b></td>
			  <td><b><?php echo  number_format($total_radiology_IPD); ?></b></td>	
			  <td><b><?php echo  number_format($total_radiology_MCU); ?></b></td>	
			  <td><b><?php echo  number_format(($total_radiology_OPD + $total_radiology_ETC + $total_radiology_IPD + $total_radiology_MCU)); ?></td>
			  
			  <td><b><?php echo  number_format($total_med_rehab_retail); ?></b></td>	
			  <td><b><?php echo  number_format($total_diagnostic_retail); ?></b></td>
			  <td><b><?php echo  number_format($total_laboratory_retail); ?></b></td>				  
			  <td><b><?php echo  number_format($total_radiology_retail); ?></td>

			  </tr>
			</tbody>
    </table>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>