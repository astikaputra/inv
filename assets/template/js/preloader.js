rotate = 1;
function hide_preloader() { //DOM
rotate = 0;
$("#preloader").fadeOut(1000);
}



$(document).ready(function(){

// calculate height 
var screen_ht = $(window).height();
var preloader_ht = 10;
var padding =(screen_ht/2)-preloader_ht;

$("#preloader").css("padding-top",padding+"px");

// loading animation using script

	function anim(){ $("#preloader_image").animate({left:'-1400px'}, 8000,
	function(){ $("#preloader_image").animate({left:'0px'}, 5000 ); if(rotate==1){ anim();}  } );
	}

	anim();

});