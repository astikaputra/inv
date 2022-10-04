<style>
.radial-progress {
	@circle-size: 120px;
	@circle-background: #d6dadc;
	@circle-color: #97a71d;
	@inset-size: 90px;
	@inset-color: #fbfbfb;
	@transition-length: 1s;
	@shadow: 6px 6px 10px rgba(0,0,0,0.2);
	@percentage-color: #97a71d;
	@percentage-font-size: 22px;
	@percentage-text-width: 57px;

	margin: 50px;
	width:  @circle-size;
	height: @circle-size;

	background-color: @circle-background;
	border-radius: 50%;
	.circle {
		.mask, .fill, .shadow {
			width:    @circle-size;
			height:   @circle-size;
			position: absolute;
			border-radius: 50%;
		}
		.shadow {
			box-shadow: @shadow inset;
		}
		.mask, .fill {
			-webkit-backface-visibility: hidden;
			transition: -webkit-transform @transition-length;
			transition: -ms-transform @transition-length;
			transition: transform @transition-length;
			border-radius: 50%;
		}
		.mask {
			clip: rect(0px, @circle-size, @circle-size, @circle-size/2);
			.fill {
				clip: rect(0px, @circle-size/2, @circle-size, 0px);
				background-color: @circle-color;
			}
		}
	}
	.inset {
		width:       @inset-size;
		height:      @inset-size;
		position:    absolute;
		margin-left: (@circle-size - @inset-size)/2;
		margin-top:  (@circle-size - @inset-size)/2;

		background-color: @inset-color;
		border-radius: 50%;
		box-shadow: @shadow;
		.percentage {
			height:   @percentage-font-size;
			width:    @percentage-text-width;
			overflow: hidden;

			position: absolute;
			top:      (@inset-size - @percentage-font-size) / 2;
			left:     (@inset-size - @percentage-text-width) / 2;

			line-height: 1;
			.numbers {
				margin-top: -@percentage-font-size;
				transition: width @transition-length;
				span {
					width:          @percentage-text-width;
					display:        inline-block;
					vertical-align: top;
					text-align:     center;
					font-weight:    800;
					font-size:      @percentage-font-size;
					font-family:    "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
					color:          @percentage-color;
				}
			}
		}
	}

	@i: 0;
	@increment: 180deg / 100;
	.loop (@i) when (@i <= 100) {
		&[data-progress="@{i}"] {
			.circle {
				.mask.full, .fill {
					-webkit-transform: rotate(@increment * @i);
					-ms-transform: rotate(@increment * @i);
					transform: rotate(@increment * @i);
				}	
				.fill.fix {
					-webkit-transform: rotate(@increment * @i * 2);
					-ms-transform: rotate(@increment * @i * 2);
					transform: rotate(@increment * @i * 2);
				}
			}
			.inset .percentage .numbers {
				width: @i * @percentage-text-width + @percentage-text-width;
			}
		}
		.loop(@i + 1);
	}
	.loop(@i);
}
</style>

<div class="container-fluid">
<div class="radial-progress" data-progress="0" id="radial_progress">
	<div class="circle">
		<div class="mask full">
			<div class="fill"></div>
		</div>
		<div class="mask half">
			<div class="fill"></div>
			<div class="fill fix"></div>
		</div>
		<div class="shadow"></div>
	</div>
	<div class="inset">
		<div class="percentage">
			<div class="numbers"></div>
		</div>
	</div>
</div>
<div class="row-fluid">
<p>
<?php echo $this->session->userdata('startdate');?>
<?php echo $this->session->userdata('enddate');?>

Monthly revenue report has send to your email, please check your email for download the file
<br />

</p>
</div>
</div>

<script>
$('head style[type="text/css"]').attr('type', 'text/less');
less.refreshStyles();
window.randomize = function() {
	$('.radial-progress').attr('data-progress', Math.floor(Math.random() * 100));
}
setTimeout(window.randomize, 200);
$('.radial-progress').click(window.randomize);
</script>

<script type='text/javascript'>
window.open('', '_self', '');
setTimeout( function() { window.close(); }, 5000); 
</script>