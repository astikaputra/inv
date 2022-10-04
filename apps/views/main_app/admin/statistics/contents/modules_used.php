<div class="row-fluid">
<div class="span12">
<div class="grid simple ">
    <div class="grid-title">
    <h3>User Module Access <span class="semi-bold">List</span></h3>
    </div>
    <div class="grid-body ">
    <table cellpadding="0" cellspacing="0" border="0" class="table " id="example3" width="100%">
        <thead>
         <tr>
            <th>No.</th>
            <th>Username</th>
            <th>Modules Access</th>
            <th>Function Name</th>
            <th>IP Address</th>
            </tr>
        </thead>
                <tbody>
                    <?php $i = 0;
                        foreach ($all_stats as $items) {
                    $i++; ?>
                    <tr>
                  <td><?php echo $i;?></td>
				  <td><?php echo $items->user_id;?></td>
				  <td><?php echo $items->modul_name;?></td>
                  <td><?php echo $items->sub_modul_name;?></td>
                  <td><?php echo $items->ip_add;?></td>
                    </tr>
                    <?php } ?>
                </tbody>
        </table>
     </div>
</div>
</div>
</div>