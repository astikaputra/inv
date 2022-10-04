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

ul{font-size: 15px;padding:0;margin:0 0 10px 25px; background-color: rgba(0, 255, 215, 0.6);}
ul ul,ul ol,ol ol,ol ul{margin-bottom:0}
li{line-height:20px}
ul.unstyled,ol.unstyled{margin-left:0;list-style:none}
ul.inline,ol.inline{margin-left:0;list-style:none}
ul.inline>li,ol.inline>li{display:inline-block;*display:inline;padding-right:5px;padding-left:5px;*zoom:1}

</style>
	
</head>
<body>

<div class="container-fluid">
<h3 class="text-left"><?php echo $detail_title;?></h3>

        <div class="accordion">
            <div class="accordion-group">
            	<div class="accordion-heading">

			  <p>
			  <li class="text-left"><b>Patient Name : <?php echo $depositdetail->PatientName; ?></b>
			  <li class="text-left"><b>Birthdate : <?php echo date('d-m-Y',strtotime($depositdetail->Birthdate)); ?></b><br />
			  <li class="text-left"><b>Blood Type : <?php echo $depositdetail->BloodType; ?></b>
			  <li class="text-left"><b>Gender : <?php echo $depositdetail->Gender;?></b><br />
			  <li class="text-left"><b>Payer Name : <?php echo $depositdetail->PayerInstitution;?></b>
			  <li class="text-right"><b>Reg No : <?php echo $depositdetail->RegNumber; ?></b>
			  <li class="text-right"><b>Mr No : <?php echo $depositdetail->MedicalRecordNumber; ?></b><br />
			  <li class="text-right"><b>Deposit Amount : <?php echo 'Rp. '. number_format($depositdetail->AmmountDeposit, 2, ',', '.'); ?></b> <button type="button" class="btn" data-toggle="collapse" data-target="#get_details"><span class="icon icon-bookmark"></span>Deposit Details</button>
              <li class="text-right"><b>Deposit Used : <?php echo 'Rp. '. number_format($depositdetail->DepositUsed, 2, ',', '.'); ?></b><br />
			  <li class="text-right"><b>Deposit Remaining : <?php echo 'Rp. '. number_format($depositdetail->Remaining, 2, ',', '.'); ?></b>
			  </p>
		
			<div id="get_details" class="accordion-body collapse">
              <div class="accordion-inner">
			  <br />
			  <br />
			<table class="table table-striped table-bordered" >
			<thead>
                <tr>
                  <th>Patient Name</th>
				  <th>Bed Type</th>
				  <th>Deposit</th>
				  <th>Deposit Date</th>
				  <th>Admitted Date</th>
				  <th>Payment Method</th>
                </tr>
            </thead>
              <tbody>
			  <?php foreach($depositlog as $logdetails) 
			  { ?>
				<tr>
				<td><?php echo $logdetails->PatientName;?></td>
				<td><?php echo $logdetails->BedType; ?></td>
				<td><?php echo number_format($logdetails->Amount, 0, ',', '.'); ?></td>
				<td><?php echo date('d-m-Y',strtotime($logdetails->DepositDate)); ?></td>
				<td><?php echo date('d-m-Y',strtotime($logdetails->AdmitDate)); ?></td>
				<td><?php echo $logdetails->NameValue;?></td>
				</tr>
				<?php  }?>
			   </tbody>
			</table>
				</div>
			</div>
			
			</div>
			</div>
		</div>
		
<br/>
<table class="table table-striped table-bordered" >
			  <thead>
                <tr>
                  <th>Charge Name</th>
				  <th>Charge Category</th>
				  <th>Cost</th>
				  <th>Qty</th>
				  <th>Discount (%)</th>
				  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
			<?php foreach($depositdata as $details) 
			  {?>
              <tr>
			  <td><?php echo $details->CategoryName;?></td>
              <td><?php echo $details->Category;?></td>
			  <td><?php echo number_format($details->Cost, 0, ',', '.') ;?></td>
			  <td><?php echo $details->Qty;?></td>
			  <td><?php echo number_format($details->Discount, 0, ',', '.').' %';?></td>
			  <td><?php echo number_format($details->Amount, 0, ',', '.') ;?></td>
			  </tr>
			  <?php  }?>
			  <tr>
			  <td colspan="5"><b>Total Amount :</b></td>
			  <td><b><?php echo 'Rp. '. number_format($depositdetail->DepositUsed, 2, ',', '.'); ?></b></td>
			  </tr>
			  </tbody>
    </table>

</div>

</body>
</html>