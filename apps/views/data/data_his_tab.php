<!DOCTYPE html>
<html lang="en">
<head>

<style type='text/css'>
	.media
    {
        /*box-shadow:0px 0px 4px -2px #000;*/
        margin: 20px 0;
        padding:30px;
    }
	.dp
    {
        border:10px solid #eee;
        transition: all 0.2s ease-in-out;
    }
    .dp:hover
    {
        border:2px solid #eee;
        transform:rotate(360deg);
        -ms-transform:rotate(360deg);  
        -webkit-transform:rotate(360deg);  
        /*-webkit-font-smoothing:antialiased;*/
    }
	
	.table tbody tr > td.success {
  background-color: #dff0d8 !important;
}

.table tbody tr > td.error {
  background-color: #f2dede !important;
}

.table tbody tr > td.warning {
  background-color: #fcf8e3 !important;
}

.table tbody tr > td.info {
  background-color: #d9edf7 !important;
}

.table-hover tbody tr:hover > td.success {
  background-color: #d0e9c6 !important;
}

.table-hover tbody tr:hover > td.error {
  background-color: #ebcccc !important;
}

.table-hover tbody tr:hover > td.warning {
  background-color: #faf2cc !important;
}

.table-hover tbody tr:hover > td.info {
  background-color: #c4e3f3 !important;
}

pre,
  blockquote {
    border: 1px solid #999;
    page-break-inside: avoid;
}
  
pre {
  padding: 0 3px 2px;
  font-family: Monaco, Menlo, Consolas, "Courier New", monospace;
  font-size: 14px;
  color: #333333;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
}

pre {
  display: block;
  padding: 9.5px;
  margin: 0 0 10px;
  font-size: 15px;
  line-height: 20px;
  word-break: break-all;
  word-wrap: break-word;
  white-space: pre;
  white-space: pre-wrap;
  background-color: #34D7E3;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.15);
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
}

</style>
	
</head>
<body>

<div class="container-fluid">

<div class="thumbnail" style="padding: 0">
			
			<a class="pull-left" href="#">
			<img alt="patientpic!" style="width: 100px;height:100px;" class="media-object dp img-circle" src="<?php echo $this->config->item('template').'icon/';?>user_prof.png">
			</a>
			<h2 class="text-left"><?php echo $patientname->MedicalRecordNumber; ?><br/><?php echo $patientname->PatientName; ?></h2>

			<pre>
			  <ul class="unstyled text-right">
			  <li><i class="icon icon-gift"></i><?php echo $patientname->Birthplace; ?>,<?php echo date('d-m-Y',strtotime($patientname->Birthdate));?></li>
			  <li><i class="icon icon-user"></i><?php echo $patientname->Gender; ?>,<?php echo $patientname->Age; ?><sup>th</sup></li>
              <li><i class="icon icon-map-marker"></i><?php echo $patientname->Address; ?></li>
			  <li><i class="icon icon-envelope"></i><?php echo $patientname->Email; ?>-<?php echo $patientname->PhoneNumber; ?></li>
			  <li><i class="icon-folder-close"></i><?php echo $patientname->IdentityType; ?>-<?php echo $patientname->IdCardNumber; ?></li>
			  </ul>
			  <br />
			  <button type="button" class="btn" data-toggle="collapse" data-target="#get_details"><span class="icon icon-bookmark"></span>Get Patient Details</button> 
			</pre>

            <div id="get_details" class="collapse">
              <div class="row-fluid">
			  <br />
			  <br />
			<table class="table table-striped table-bordered" >
			<thead>
                <tr>
                  <th >Marital Status</th>
				  <th>Religion</th>
				  <th>Ethnic</th>
				  <th>Family Relation</th>
				  <th>Occupation</th>
				  <th>Education</th>
				  <th>Blood Type</th>
				  <th>Weight</th>
				  <th>Height</th>
				  <th>Address Details</th>
                </tr>
            </thead>
              <tbody>
				<td><?php echo $patientname->Marital;?></td>
				<td><?php echo $patientname->Religion; ?></td>
				<td><?php echo $patientname->Ethnic; ?></td>
				<td><?php echo $patientname->Salutation;?></td>
				<td><?php echo $patientname->Occupation;?></td>
				<td><?php echo $patientname->Education; ?></td>
				<td><?php echo $patientname->BloodType; ?></td>
				<td><?php echo $patientname->Weight; ?></td>
				<td><?php echo $patientname->Height; ?></td>
				<td><?php echo $patientname->Area;?>,<?php echo $patientname->City;?>,<?php echo $patientname->Province;?>,<?php echo $patientname->Country; ?></td>
			   </tbody>
			</table>
				</div>
			  </div>
</div>
</div>
<br/>
<table class="table table-striped table-bordered" >
        <thead>
                <tr>
                  <th>Registration Code</th>
				  <th>Registration Time</th>
				  <th>Class</th>
				  <th>Doctor Name</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($hisdata as $patienthis) 
			  {?>
              <tr>
			  <td><?php echo $patienthis->RegistrationCode;?></td>
              <td><?php echo date('d-m-Y H:i:s',strtotime($patienthis->RegistrationTime));?></td>
			  <td>
			  <?php  {if (isset($patienthis->Class)) { ?>
			  <div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="<?php echo '#history'.$patienthis->AdmisionId,$patienthis->DoctorsCode;?>">
						<span class="badge badge-info"><?php echo $patienthis->Class;?></span>
						</a>
					</div>
					<div id="<?php echo 'history'.$patienthis->AdmisionId,$patienthis->DoctorsCode;?>" class="accordion-body collapse">
							<div class="accordion-inner">
				<?php
				  foreach($this->patient_his_model->get_historical_class($patienthis->AdmisionId) as $class)
				  {
					echo '<center><i class="icon-arrow-up"></i><br /><br /><span class="label label-info"> <span class="badge badge-inverse"><b>'.$class->Classes.'</b></span> '.date('d M y h:i:s',strtotime($class->FromDate)).'</span></center><br />';
				  }
				  ?>
							</div>
					</div>
			 </div>
			 <?php } else {} }?>
			  </td>
              <td><?php echo $patienthis->DoctorName;?></td>
			<?php } ?>
			</tbody>
    </table>

</div>

</body>
</html>	