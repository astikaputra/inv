<style>
#timeline {
  list-style: none;
  position: relative;
}
#timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 2px;
  background-color: #4997cd;
  left: 50%;
  margin-left: -1.5px;
}
#timeline .clearFix {
  clear: both;
  height: 0;
}
#timeline .timeline-badge {
  color: #fff;
  width: 50px;
  height: 50px;
  font-size: 1.2em;
  text-align: center;
  position: absolute;
  top: 20px;
  left: 50%;
  margin-left: -25px;
  background-color: #4997cd;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
#timeline .timeline-badge span.timeline-balloon-date-day {
  font-size: 1.4em;
}
#timeline .timeline-badge span.timeline-balloon-date-month {
  font-size: .7em;
  position: relative;
  top: -10px;
}
#timeline .timeline-badge.timeline-filter-movement {
  background-color: #ffffff;
  font-size: 1.7em;
  height: 35px;
  margin-left: -18px;
  width: 35px;
  top: 40px;
}
#timeline .timeline-badge.timeline-filter-movement a span {
  color: #4997cd;
  font-size: 1.3em;
  top: -1px;
}
#timeline .timeline-badge.timeline-future-movement {
  background-color: #ffffff;
  height: 35px;
  width: 35px;
  font-size: 1.7em;
  top: -16px;
  margin-left: -18px;
}
#timeline .timeline-badge.timeline-future-movement a span {
  color: #4997cd;
  font-size: .9em;
  top: 2px;
  left: 1px;
}
#timeline .timeline-movement {
  border-bottom: dashed 1px #4997cd;
  position: relative;
}
#timeline .timeline-movement.timeline-movement-top {
  height: 60px;
}
#timeline .timeline-movement .timeline-item {
  padding: 20px 0;
}
#timeline .timeline-movement .timeline-item .timeline-panel {
  border: 1px solid #d4d4d4;
  border-radius: 3px;
  background-color: #FFFFFF;
  color: #666;
  padding: 10px;
  position: relative;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
#timeline .timeline-movement .timeline-item .timeline-panel .timeline-panel-ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
#timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul {
  text-align: right;
}
#timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li {
  color: #666;
}
#timeline .timeline-movement .timeline-item .timeline-panel.credits .timeline-panel-ul li span.importo {
  color: #468c1f;
  font-size: 1.3em;
}
#timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul {
  text-align: left;
}
#timeline .timeline-movement .timeline-item .timeline-panel.debits .timeline-panel-ul span.importo {
  color: #e2001a;
  font-size: 1.3em;
}
</style> 

 <div class="container-fluid">

      <div class="row-fluid">
      <div class="well">
      <p class="dashboard_header">
<img class="medicos_header_logo" src="<?php echo base_url().'assets/template/images/medicos.png';?>" alt="Medical Information Solution">

<img class="hospital_logo" src="<?php echo base_url().'assets/template/icon/logo.png';?>" alt="Siloam Hospitals">
</p>
          
    <h2 class="text-center"> <?php echo $content_title; ?> </h2>
    <br />
       <div class="control-group">

                <table class="table table-bordered" id="nutrition_dtbl"  >
                      <thead>
                        <tr>
                          <th>Patient Name</th> 
                          <th>MR Number</th>
                          <th>Primary Doctor Name</th>
                          <th>Diagnose</th>
                          <th>Room</th>
                          <th>Bedname</th>
                          <th>Bed Status</th>
                          <th>Class</th>
                          <th>Ward/Floor</th>
                          <th>Admit Date</th>
                        </tr>
                       </thead>
                    <tbody>
                    <?php foreach($nutrition_list as $nut_data) 
                    {?>
                    <tr>
                    <td><?php echo $nut_data->PatientName; ?></td>
                    <td><?php echo $nut_data->MedicalRecordNumber;?></td>
                    <td><?php echo $nut_data->DoctorName;?></td>
                    <td><?php echo $nut_data->Diagnosis;?></td>
                    <td><?php echo $nut_data->RoomName;?></td>
                    <td><?php echo $nut_data->BedName;?></td>
                    <td><a class=' <?php if($nut_data->BedStatus=='Vacant')
                      {echo 'btn btn-success disabled';}
                    else if($nut_data->BedStatus=='Alloted Not Occupied')
                      {echo 'btn btn-warning disabled';}
                    else if($nut_data->BedStatus=='Released Not Vacated')
                      {echo 'btn btn-inverse disabled';}
                    else if($nut_data->BedStatus=='Occupied')
                      {echo 'btn btn-primary disabled';}
                      ?>'><?php echo $nut_data->BedStatus;?></a></td>
                    <td><?php echo $nut_data->Class;?></td>
                    <td><?php echo $nut_data->WardName;?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($nut_data->AdmitDate)); ?></td>
                    <?php } ?>
                    </tr>
                    </tbody>
                </table>
      
       </div>
      </div>

  </div>
      <div class="row">
  <a href="<?php echo base_url().'tools';?>" class="btn btn-success">Kembali Ke Menu Utama</a>
    </div>
</div>

  <script>
 $(document).ready(function() {
 
  TableTools.DEFAULTS.aButtons = [
              "copy",
              "print",
              {
                "sExtends":    "collection",
                "sButtonText": 'Save <span class="caret" />',
                "aButtons":    [ "csv", "xls",
                {
                "sExtends": "pdf",
                "sPdfOrientation": "landscape"
                }
                ]
              }
            ];
            
    TableTools.DEFAULTS.sSwfPath = "<?php echo $this->config->item('template') .
'TableTools'; ?>/media/swf/copy_csv_xls_pdf.swf";

  var nutritionrep = $('#nutrition_dtbl').dataTable({
              "iDisplayLength": 10,
              "bAutoWidth": false,
              "sDom": '<"top"i>rt<"bottom"flp><"clear">',
              "sDom": "<'row-fluid'<'span2'T><'span2'l><'span2'f>r>t<'row-fluid'<'span6'i><'span6 center'p>>",
              
              "iDisplayLength": '100',
              "paging": false,
              "oTableTools": {
              "aButtons": [ "copy","print",
              {
              "sExtends":    "collection",
              "sButtonText": "Save",
              "aButtons":    [ "csv", "xls", "pdf" ]
              }             
              ]
              }
              } );
    
  });
  
   var auto_refresh = setInterval(tbl_data,120000);
  
</script>