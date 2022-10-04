<div class="container-fluid">
<p class="medicos_header_logo"><img src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals"></p>
<h3><?php echo $emr_title;?></h3>
<div class="table-responsive">
<?php 
if($emr_page == 'all_patient')
{
?>
<table class="table table-bordered" id="medical_record_grid" >
        <thead>
                <tr>
                  <th>MR Number</th>
                  <th>Registration Code</th>
				  <th>Patient Name</th>
                  <th>Birthplace And Birthdate</th>
				  <th>Age</th>
				  <th>Gender</th>
				  <th>Blood Type</th>
				  <th>Weight</th>
				  <th>Height</th>
				  <th>Identity Type</th>
				  <th>Identity CardNumber</th>
                  <th>Address</th>
                  <th>Phone Number / Fax</th>
                  <th>City</th>
                  <th>Province</th>
                  <th>Country</th>
                  <th>Ethnic</th>
                  <th>Religion</th>
                  <th>Marital</th>
                  <th>Occupation</th>
                  <th>Education</th>
                  <th>Registration Time</th>
                  <th>Registered By</th>                    
                  <th>Patients Description</th>                  
                  <th>Payer Institution</th>
                  <th>Payer Category</th>
                  <th>Admit Date</th>
                  <th>LOB</th>
                  <th>Triage</th>
			      <th>Doctors Code</th>
				  <th>Doctor Name</th>
				  <th>Position</th>
                  <th>Specialist Group</th>
                  <th>Specialist</th>
                  <th>Sub Specialist</th>
                  <th>Admission Diagnosis</th>
                  <th>Doctor Note Diagnose</th>
                  <th>Doctor Note DiagnoseICDCode</th>
                  <th>Doctor Note ICDCode</th>
                  <th>Doctor Note ICDName</th>                  
                  <th>Classes</th>                                                                       
                  <th>Wards / Floor</th>
                  <th>Rooms</th>
                  <th>Beds</th>                    
                  <th>Bed types</th>
                  <th>From Date</th> 
                  <th>To Date</th>                    
                  <th>Length Of Stay</th>
                  <th>Close Date</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php }
else if($emr_page == "unique_patient_reg")
{
?>
<table class="table table-bordered" id="medical_record_unique_patient_reg" >
        <thead>
                <tr>
				  <th>Registration Time</th>
                  <th>Registration Code</th>
                  <th>LOB</th>
                  <th>MR Number</th>
				  <th>Patient Name</th>                   
                  <th>Patients Description</th>                     
                  <th>Patients Category</th>  
                  <th>Birthplace And Birthdate</th>
				  <th>Age</th>
				  <th>Gender</th>
				  <th>Blood Type</th>
				  <th>Identity Type</th>
				  <th>Identity CardNumber</th>
				  <th>Email</th>
                  <th>Address 1</th>
				  <th>Address 2</th>
                  <th>Phone Number / Fax</th>
				  <th>Phone Number 2 / Fax 2</th>
                  <th>City</th>
                  <th>Province</th>
                  <th>Country</th>
                  <th>Ethnic</th>
                  <th>Religion</th>
                  <th>Marital</th>
                  <th>Occupation</th>
                  <th>Education</th>
                  <th>Registered By</th>  
                  <th>Patients Description</th>                
                  <th>Payer Institution</th>
                  <th>Payer Category</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
    <?php }
else if($emr_page == "patient_only")
{
?>
<table class="table table-bordered" id="medical_record_unique_patient" >
        <thead>
                <tr>
				  <th>MR Number</th>
				  <th>Patient Name</th>                                       
                  <th>Birthplace And Birthdate</th>
				  <th>Age</th>
				  <th>Age Detail</th>
				  <th>Gender</th>
				  <th>Blood Type</th>
   			      <th>Weight</th>
		          <th>Height</th>
				  <th>Identity Type</th>
				  <th>Identity CardNumber</th>
                  <th>Email</th>
                  <th>Address 1</th>
				  <th>Address 2</th>
                  <th>Phone Number / Fax</th>
				  <th>Phone Number 2 / Fax 2</th>
                  <th>City</th>
                  <th>Province</th>
                  <th>Country</th>
                  <th>Ethnic</th>
                  <th>Religion</th>
                  <th>Marital</th>
                  <th>Occupation</th>
                  <th>Education</th>                 
                  <th>Payer Institution</th>
                  <th>Payer Category</th>
                  <th>CreatedByOn</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php
}
else if($emr_page == "patient_discharge")
{
?>
<table class="table table-bordered" id="medical_record_discharge_patient" >
        <thead>
                <tr>
                  <th>MR Number</th>
                  <th>Registration Code</th>
				  <th>Patient Name</th>
                  <th>Classes</th>
				  <th>Start Date</th>
				  <th>To Date</th>
				  <th>Close Date</th>
				  <th>LOB</th>
				  <th>Patient Description</th>
				  <th>Patient Category</th>
				  <th>Birth Place</th>
                  <th>Birth Date</th>
				  <th>Age</th>
				  <th>Address</th>
                  <th>Phone Number / Fax</th>
				  <th>Country</th>
                  <th>Ethnic</th>
                  <th>Religion</th>
                  <th>Payer Institution</th>
				  <th>Payer Category</th>
				  <th>Created By / On</th>
                </tr>
              </thead>
              <tbody>
		
			</tbody>
    </table>
<?php
}
?>
	</div>

  <div class="row">
	    <div class="span12 back">
						<a href="<?php echo base_url().'tools';?>" class="btn btn-success">Back To Menu</a>
		</div>
			
  </div>
 </div>


