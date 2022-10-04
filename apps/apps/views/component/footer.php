
	<script src="<?php echo $this->config->item('template').'js/';?>jquery.min.js"></script>
    <script src="<?php echo $this->config->item('template').'bootstrap/';?>js/bootstrap.min.js"></script>
		<script>
	$(window).resize(function(){

    $('.main-menu').css({
        position:'absolute',
        left: ($(window).width() - $('.main-menu').outerWidth())/2,
        top: ($(window).height() - $('.main-menu').outerHeight())/2
    });

});

// To initially run the function:
$(window).resize();
</script>
<?php 
if(isset($page) == 'datatable')
{?>
<script type="text/javascript" language="javascript" src="<?php echo $this->config->item('template').'bootstrap/';?>js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
			
$(".recordstatus").click(function(){
	var kirim=$(this).attr('data');
	var ids=$(this).attr('id');
	alert(kirim);
	$.ajax({
		url: kirim,
		succes: function(result){
		if(result=='1'){
			$(ids).attr('class')='btn btn-mini btn-success recordstatus';
		}else{
			$(ids).attr('class')='btn btn-mini btn-inverse recordstatus';
		}
		}
		});
});
				$('#datatable').dataTable( {
					"bScrollInfinite": true,
					"bScrollCollapse": true,
					"sScrollY": "400px"
				} );
			} );
		</script>
<script type="text/javascript">

$('.openBtn').click(function(){
	var frameSrc = $(this).attr('data');

   $('#myModal').on('show', function () {
			$('iframe').attr("src",frameSrc);
      });
    $('#myModal').modal({show:true})
});
</script>
		
<?php } ?>

<?php 
if($page=='data')
{
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; }?>
<script type="text/javascript">
$(document).ready(function() {
    $("body").css("display", "none");
    $("body").fadeIn(500);
       
    function redirectPage() {
        window.location = linkLocation;
    }
});
</script>

	</body>
</html>
	<!-- Script Copyright By
	Tri Ismardiko Widyawan 
	tri.ismardiko@gmail.com/tri@simedika.com
	08881053478 08979222742
	page rendered on {elapsed_time} second
	-->