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
<h3><?php echo $content_title;?></h3>

<table class="table table-bordered" id="monthly_los_grid">
        <thead>
                 <tr>
                  <th rowspan="2">Day</th>
				  <th colspan="6">ETC Throughput</th>
				  <th colspan="6">OPD Throughput</th>
				  <th colspan="6">Retail Throughput</th>
				  <th colspan="6">IPD Throughput</th>
				  <th colspan="6">MCU Throughput</th>
				  <th colspan="6">Throughput</th>
				  <th colspan="5">Jumlah Pasien</th>
				  <th colspan="5">Jumlah Pemeriksaan</th>
				 </tr>
				 <tr>
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th>
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th>
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th>
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th> 
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th>
				  <th>Conv</th>
				  <th>Pano</th>
				  <th>CT</th>
				  <th>USG</th>
				  <th>Mamo</th>
				  <th>MRI</th>
				  <th>ETC</th>
				  <th>OPD</th>
				  <th>RET</th>
				  <th>IPD</th>
				  <th>MCU</th>
				  <th>ETC</th>
				  <th>OPD</th>
				  <th>RET</th>
				  <th>IPD</th>
				  <th>MCU</th>                				  
				 </tr>
              </thead>
              <tbody>
			  <?php
			//--- Initial value ---/
			  $total_ETC_conv = 0;
			  $total_ETC_pano = 0;
			  $total_ETC_ct = 0;
			  $total_ETC_usg= 0;
			  $total_ETC_mamo = 0;
			  $total_ETC_mri = 0;
			  $total_OPD_conv = 0;
			  $total_OPD_pano = 0;
			  $total_OPD_ct = 0;
			  $total_OPD_usg= 0;
			  $total_OPD_mamo = 0;
			  $total_OPD_mri = 0;
			  $total_RET_conv = 0;
			  $total_RET_pano = 0;
			  $total_RET_ct = 0;
			  $total_RET_usg= 0;
			  $total_RET_mamo = 0;
			  $total_RET_mri = 0;
			  $total_IPD_conv = 0;
			  $total_IPD_pano = 0;
			  $total_IPD_ct = 0;
			  $total_IPD_usg= 0;
			  $total_IPD_mamo = 0;
			  $total_IPD_mri = 0;
			  $total_MCU_conv = 0;
			  $total_MCU_pano = 0;
			  $total_MCU_ct = 0;
			  $total_MCU_usg= 0;
			  $total_MCU_mamo = 0;
			  $total_MCU_mri = 0;	
			  $total_TRO_conv = 0;
			  $total_TRO_pano = 0;
			  $total_TRO_ct = 0;
			  $total_TRO_usg= 0;
			  $total_TRO_mamo = 0;
			  $total_TRO_mri = 0;
			  $total_TOP_ETC = 0;
			  $total_TOP_OPD = 0;
			  $total_TOP_RET = 0;
			  $total_TOP_IPD = 0;
			  $total_TOP_MCU = 0;
			  $total_TOS_ETC = 0;
			  $total_TOS_OPD = 0;
			  $total_TOS_RET = 0;
			  $total_TOS_IPD = 0;
			  $total_TOS_MCU = 0;			  
			  
			  for($i=1;$i<=31;$i++) { 
			//--- Conventional ETC ---/	
			$ETC_conv = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_conv =  $total_ETC_conv + $ETC_conv;			
			//--- Conventional OPD ---/ 
			$OPD_conv = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_conv =  $total_ETC_conv + $OPD_conv;
			//--- Conventional RET ---/	
			$RET_conv = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_conv =  $total_ETC_conv + $RET_conv;			
			//--- Conventional IPD ---/ 
			$IPD_conv = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_conv =  $total_ETC_conv + $IPD_conv;		
			//--- Conventional MCU ---/ 
			$MCU_conv = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_conv =  $total_ETC_conv + $MCU_conv;			

			//--- Panoramic ETC ---/	
			$ETC_pano = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_pano =  $total_ETC_pano + $ETC_pano;			
			//--- Panoramic OPD ---/ 
			$OPD_pano = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_OPD_pano =  $total_OPD_pano + $OPD_pano;
			//--- Panoramic RET ---/	
			$RET_pano = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_RET_pano =  $total_RET_pano + $RET_pano;			
			//--- Panoramic IPD ---/ 
			$IPD_pano = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_IPD_pano =  $total_IPD_pano + $IPD_pano;		
			//--- Panoramic MCU ---/ 
			$MCU_pano = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_MCU_pano =  $total_MCU_pano + $MCU_pano;				
			
			//--- CT 256 Slices ETC ---/    
			$ETC_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_ct =  $total_ETC_ct + $ETC_ct;
			//--- CT 256 Slices OPD ---/    
			$OPD_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_OPD_ct =  $total_OPD_ct + $OPD_ct;
						//--- CT 256 Slices ETC ---/    
			$ETC_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_ct =  $total_ETC_ct + $ETC_ct;
			//--- CT 256 Slices OPD ---/    
			$OPD_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_OPD_ct =  $total_OPD_ct + $OPD_ct;
			//--- CT 256 Slices RET ---/ 
			$RET_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_RET_ct =  $total_RET_ct + $RET_ct;			
			//--- CT 256 Slices IPD ---/    
			$IPD_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_IPD_ct =  $total_IPD_ct + $IPD_ct;	
			//--- CT 256 Slices MCU ---/    
			$MCU_ct = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_MCU_ct =  $total_MCU_ct + $MCU_ct;

			//--- USG ETC ---/    
			$ETC_usg = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_ETC_usg =  $total_ETC_usg + $ETC_usg;
			//--- USG OPD ---/    
			$ETC_usg = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_diagnostic_MCU =  $total_diagnostic_MCU + $diagnostic_MCU;
			//--- USG RET ---/    
			$diagnostic_OPD = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_diagnostic_OPD =  $total_diagnostic_OPD + $diagnostic_OPD;
			//--- USG IPD ---/    
			$diagnostic_IPD = $this->special_report_model->get_count_trougput( $datestart, $dateend, $i);
			$total_diagnostic_IPD =  $total_diagnostic_IPD + $diagnostic_IPD;
			
			//--- Radiology ETC ---/    
			$radiology_ETC = $this->special_report_model->get_monthly_lob_report( $datestart, $dateend, $i);
			$total_radiology_ETC =  $total_radiology_ETC + $radiology_ETC;
			//--- Radiology MCU ---/    
			$radiology_MCU = $this->special_report_model->get_mcu_report( $datestart, $dateend, $i);
			$total_radiology_MCU =  $total_radiology_MCU + $radiology_MCU;
			//--- Radiology OPD ---/    
			$radiology_OPD = $this->special_report_model->get_monthly_lob_report( $datestart, $dateend, $i);
			$total_radiology_OPD =  $total_radiology_OPD + $radiology_OPD;
			//--- Radiology IPD ---/    
			$radiology_IPD = $this->special_report_model->get_monthly_lob_report( $datestart, $dateend, $i);
			$total_radiology_IPD =  $total_radiology_IPD + $radiology_IPD;

			//--- Cath Lab OPD ---/    
			$cath_lab_OPD = $this->special_report_model->get_monthly_lob_report( "'Cath Lab'", 'OPD', $repyear,$i);
			$total_cath_lab_OPD =  $total_cath_lab_OPD + $cath_lab_OPD;
			//--- Cath Lab IPD ---/    
			$cath_lab_IPD = $this->special_report_model->get_monthly_lob_report( "'Cath Lab'", 'IPD', $repyear,$i);
			$total_cath_lab_IPD =  $total_cath_lab_IPD + $cath_lab_IPD;			
			
			  ?>
			  <tr>
			  <td><?php echo $monthname[$i];?></td>
			  <td><?php echo number_format($medical_rehab_OPD);?></td>
			  <td><?php echo number_format($medical_rehab_IPD);?></td>
			 <!--Total Medical Rehab-->
			  <td><b><?php echo number_format(($medical_rehab_OPD + $medical_rehab_IPD));?></b></td>
			  <td><?php echo number_format($diagnostic_OPD);?></td>
			  <td><?php echo number_format($diagnostic_ETC);?></td>
			  <td><?php echo number_format($diagnostic_MCU);?></td>
			  <td><?php echo number_format($diagnostic_IPD);?></td>
			 <!--Total Diagnostic-->
			  <td><b><?php echo number_format(($diagnostic_OPD + $diagnostic_ETC + $diagnostic_MCU + $diagnostic_IPD));?></b></td>
			  <td><?php echo number_format($laboratory_OPD);?></td>
			  <td><?php echo number_format($laboratory_ETC);?></td>
			  <td><?php echo number_format($laboratory_IPD);?></td>
			  <td><?php echo number_format($laboratory_MCU);?></td>
			 <!--Total laboratory-->
			  <td><b><?php echo number_format(($laboratory_ETC + $laboratory_MCU + $laboratory_OPD + $laboratory_IPD));?></b></td>
			  <td><?php echo number_format($radiology_OPD);?></td>
			  <td><?php echo number_format($radiology_ETC);?></td>
			  <td><?php echo number_format($radiology_IPD);?></td>
			  <td><?php echo number_format($radiology_MCU);?></td>
			 <!--Total Diagnostic-->
			  <td><b><?php echo number_format(($radiology_ETC + $radiology_MCU + $radiology_OPD + $radiology_IPD));?></b></td>
			  <td><?php echo number_format($cath_lab_OPD);?></td>
			  <td><?php echo number_format($cath_lab_IPD);?></td>
			 <!--Total Cath Lab-->
			  <td><b><?php echo number_format(($cath_lab_OPD + $cath_lab_IPD));?></b></td>			  
			  </tr>

			  <?php } ?>
			  <tr>
			  <td><b>Total</b></td>
			  <td><b><?php echo number_format($total_med_rehab_OPD); ?></b></td>
			  <td><b><?php echo number_format($total_med_rehab_IPD); ?></b></td>
			  <td><b><?php echo number_format(($total_med_rehab_OPD + $total_med_rehab_IPD)); ?></td>
			  
			  <td><b><?php echo number_format($total_diagnostic_OPD); ?></b></td>
			  <td><b><?php echo number_format($total_diagnostic_ETC); ?></b></td>
			  <td><b><?php echo number_format($total_diagnostic_MCU); ?></b></td>	
			  <td><b><?php echo number_format($total_diagnostic_IPD); ?></b></td>	
			  <td><b><?php echo number_format(($total_diagnostic_OPD + $total_diagnostic_ETC + $total_diagnostic_MCU + $total_diagnostic_IPD)); ?></td>
			  
			  <td><b><?php echo number_format($total_laboratory_OPD); ?></b></td>
			  <td><b><?php echo number_format($total_laboratory_ETC); ?></b></td>
			  <td><b><?php echo number_format($total_laboratory_IPD); ?></b></td>	
			  <td><b><?php echo number_format($total_laboratory_MCU); ?></b></td>	
			  <td><b><?php echo number_format(($total_laboratory_OPD + $total_diagnostic_ETC + $total_laboratory_IPD + $total_laboratory_MCU)); ?></td>

			  <td><b><?php echo number_format($total_radiology_OPD); ?></b></td>
			  <td><b><?php echo number_format($total_radiology_ETC); ?></b></td>
			  <td><b><?php echo number_format($total_radiology_IPD); ?></b></td>	
			  <td><b><?php echo number_format($total_radiology_MCU); ?></b></td>	
			  <td><b><?php echo (($total_radiology_OPD + $total_radiology_ETC + $total_radiology_IPD + $total_radiology_MCU)); ?></td>
			  
			  <td><b><?php echo number_format($total_cath_lab_OPD); ?></b></td>	
			  <td><b><?php echo number_format($total_cath_lab_IPD); ?></b></td>	
			  <td><b><?php echo number_format(($total_cath_lab_OPD + $total_cath_lab_IPD)); ?></td>

			  </tr>
			</tbody>
    </table>
<div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
</div>
</div>