<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename = Dokter_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<style type="text/css">
	table.doctor-table {
	border: 1px solid #CCC; font-family: Arial, Helvetica, sans-serif
	font-size: 12px;
} 
.doctor-table td {
	padding: 4px;
	margin: 3px;
	border: 1px solid #ccc;
}
.doctor-table th {
	background-color: #2FA3EE; 
	color: #FFF;
	font-weight: bold;
}
</style><table class="doctor-table">
<tr class="doctor-firstrow"><th>ID</th><th>REG ID</th><th>Medical Record Number</th><th>LOB</th><th>Registration Number</th><th>Patiens Name</th><th>Registration Date & Time </th><th>Registration Date</th><th>Registration Time</th><th>Gender</th><th>Status</th><th>Create By</th><th>Modified By</th><th>Doctors</th><th>Total Bill</th></tr>
 <?php                            
    foreach($dokter->result() as $data)
    {
    echo '<tr>';                                
    echo '<td>'.$data->id.'</td>';
	echo '<td>'.$data->RegID.'</td>';
	echo '<td>'.$data->MedicalRecordNumber.'</td>';
    echo '<td>'.$data->Lob.'</td>'; 
    echo '<td>'.$data->RegistrationCode.'</td>';
    echo '<td>'.$data->PatientsName.'</td>';
    echo '<td>'.$data->RegistrationTime.'</td>'; 
    echo '<td>'.$data->DateRegistration.'</td>';
    echo '<td>'.$data->TimeRegistration.'</td>';
    echo '<td>'.$data->Genders.'</td>'; 
    echo '<td>'.$data->Status.'</td>';
    echo '<td>'.$data->CreatedBy.'</td>';
    echo '<td>'.$data->ModifiedBy.'</td>';
    echo '<td>'.$data->dokter.'</td>'; 
    echo '<td>'.$data->TotalBill.'</td>';      	
    echo '</tr>';                                
    }                      
    ;
 ?>
</table>