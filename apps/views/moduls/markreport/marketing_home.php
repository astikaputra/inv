 <style type='text/css'>
 img.hoverImages {
	margin:16px;
	-webkit-transition: margin 0.5s ease-out;
    -moz-transition: margin 0.5s ease-out;
    -o-transition: margin 0.5s ease-out;
}
 
img.hoverImages:hover {
	cursor:pointer;
    margin-top: 12px;
	margin-bottom: 12px;
}
	  
.fade {
  opacity: 0;
  -webkit-transition: opacity 0.15s linear;
  -moz-transition: opacity 0.15s linear;
  -o-transition: opacity 0.15s linear;
  transition: opacity 0.15s linear;
}

.fade.in {
  opacity: 1;
}  

a {
  color: #0088cc;
  text-decoration: none;
    -webkit-transition: text-shadow 0.2s linear;
    -moz-transition: text-shadow 0.2s linear;
    -ms-transition: text-shadow 0.2s linear;
    -o-transition: text-shadow 0.2s linear;
    transition: text-shadow 0.2s linear;
}

a:hover,
a:focus {
  color: #005580;
  text-decoration:;
  text-shadow: 0 0 10px rgba(0, 255, 255, 0.6);
	}

/*
| -------------------------------------------------- |
| Chat Bar Style               
| -------------------------------------------------- |
*/		
	
#chat-bar {
	background-color: #333333 ;
	border-top: 1px solid #CCCCCC ;
	bottom: 0px ;
	font-family: verdana, arial ;
	font-size: 11px ;
	height: 50px ;
	position: fixed ;
	width: 100% ;
	z-index: 1000 ;
	}
	
#chat-bar-frame {
	height: 30px ;
	margin: 0px 10px 0px 10px ;
	position: relative ;
	}

#chat-bar-content {
	padding: 3px 0px 0px 0px ;
	}

#chat-btn {
	background-color: #336699 ;
	border: 1px solid #4477aa ;
	color: #fff ;
	display: block ;
	width: 260px;
	text-align: center ;
	text-decoration: none ;
	float:right;
	}

#menu a {
background-color: #F0EEEF ;
border: 1px solid #FFFFFF ;
color: #000000 ;
display: block ;
margin-bottom: 4px ;
padding: 5px 0px 5px 5px ;
text-decoration: none ;
	}

#menu a:hover {
	background-color: #666666 ;
	border-color: #000000 ;
	color: #FFFFFF ;
	}

/*
| -------------------------------------------------- |
| Chat Popup styling                
| -------------------------------------------------- |
*/	

.headerchat{
    background-color: #006dcc ;
    width: 100%;
    padding-top: 3px;
    padding-bottom: 3px;
    font-weight: bold;
    color: #fff;
	height: 30px;
	line-height: 30px;
}
.users {
    background-color: #fff ;
    border: 1px solid #999 ;
    bottom: 30px ;
    display: none ;
    left: 11px ;
    position: fixed ;
    width: 300px ;
    min-height: 300px;
	float:right;
}
.messages {
    background-color: #fff ;
    border: 1px solid #999 ;
    bottom: 30px ;
    display: none ;
    left: 11px ;
    position: fixed ;
    width: 300px ;
    min-height: 150px;
    max-height: 500px;
}
.gray{
    color:#aaa;
}
.chat{
    word-wrap:break-word;
    width: 290px;
    overflow:hidden;
	padding: 5px;
}
.username{
    text-decoration: none;
    color: #336699;
}
.username:hover{
    text-decoration: none;
    color: #6699aa;
}
.conversation{
    width:80%;
    padding: 3px;
    border-bottom: 1px dotted #999;
    float: right;
}
.conversationpicture{
    float:left;
}
.closecontainer{
    float: right;
}
.buddycontainer
{
    float:left;
}
.formchattext
{
    font-family:verdana;
    font-size:10px;
    border:1px solid #ccc;
    width:270px;
}
.newmessage
{
    float:left;
    height: 100px;
    vertical-align: middle;
	margin-left: -140px;
	margin-top: -7px;
}	
	
 </style>
 <br />
 <br />
<body>
 <div class="container-fluid">
	 <?php foreach($sub_modul as $tools)
	  {
	  ?>
	  <center>
	  <div class="span2 menu">
		<a href="<?php echo base_url().$tools->modul_url;?>" class="to_modal">
		<img class="wobble-horizontal" src="<?php echo $this->config->item('template').'icon/'.$tools->modul_icon;?>" alt="<?php echo $tools->modul_description;?>" style="max-width:50%;" />
		  <p><b><?php echo $tools->modul_name;?></b></p>
                </a>
          </div>
	  </center>
       <?php 
	   }
	   ?>
	   	<center>
		<div class="span2 menu">
		  <a href="<?php echo base_url();?>tools" class="to_modal">
		  <img class="wobble-horizontal" src="<?php echo $this->config->item('template').'icon/';?>backward.png" alt="<?php echo $tools->modul_description;?>" style="max-width:50%;" />
                  <p><b>Backward</b></p>
		  </a>
                </div>
		</center>
	   <center>
		<div class="span2 menu">
		  <a href="<?php echo base_url();?>core/logout" class="to_modal">
		  <img class="wobble-horizontal" src="<?php echo $this->config->item('template').'icon/';?>logout.png" alt="<?php echo $tools->modul_description;?>" style="max-width:50%;" />
                  <p><b>Change User</b></p>
		  </a>
                </div>
		</center>
			<div class="span4 pull-right">
				<div id="myAlert" class="alert alert-dismissible alert-info">
				      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<strong>You are Connected To :</strong> <?php echo $this->session->userdata('hospital_name').' ON '. $this->session->userdata('env_type').' Environment';?>
				</div>
			</div>
</div>	
	
	
<div id="chat-bar" class="fixed-position">
	 <div id="chat-bar-frame">
		 <div id="chat-bar-content">
		 <a id="chat-btn" href="<?php echo base_url();?>chat/" class="btn-primary btn-large">Support Chat</a>
		 <div id="newmessage" class="newmessage"></div>
		 </div>
	 </div>
 </div>
	
</body>
</html>

<script>
function showAlert(){
  $("#myAlert").addClass("in")
}

/*
|-------------------------------------------------------------------------
| Copyright (c) 2013 
| This script may be used for non-commercial purposes only. For any
| commercial purposes, please contact the author at sammkaranja@gmail.com
|-------------------------------------------------------------------------
*/

/*
|-------------------------------------------------------------------------
| Funtion to trigger the refresh event
|-------------------------------------------------------------------------
*/
var refresh;

function beginRefresh()
{
	refresh = setInterval(function()
    {
        var timestring = new Date().getTime();
        $('#chatmessage').load(base+'chat/index/'+ timestring);
    }, 2000);
}
/*
|----------------------------------------------------------------------------
| function to Stop refreshing
|----------------------------------------------------------------------------
*/

function endrefresh()
{
    clearInterval(refresh);
}
/*
|-------------------------------------------------------------------------
| Displaying the online users popup by clicking the open chat button
|-------------------------------------------------------------------------
*/
jQuery(function( $ ){
 var chat_btn = $("#chat-btn");
 var chat_area = $("#chat-area");
 var users_online = $("#users");
 
 chat_btn.attr( "href", "javascript:void( 0 )" ).click(function()
 {
	chat_area.hide();
	users_online.toggle();
	$("#messagediv").html('');
	endrefresh();
	var timestring = new Date().getTime();
	$('#onlineusers').load(base+'users/index/'+ timestring);
	chat_btn.blur();
	return (false);
 });
	$(document).click(function(event){
	if (users_online.is( ":visible" ) && !$( event.target ).closest( "#users" ).size()){
            users_online.hide();
        }
	
	});
});

/*
|---------------------------------------------------------------------------
| Triggers to send new message and minimize users list
|---------------------------------------------------------------------------
*/
$(document).ready(function() {
    $("form#newmessageform").submit(function(){
        $.post(base+"chat/sendmessage",{
        message: $("#message").val()
        });
        $("#message").val("");
        return false;
    });
	$("#chat-btn").click(function(){
		$.post(base+"chat/close_buddy");
	});
});

/*
|------------------------------------------------------------------------------
| Timer code to get new chat requests
|------------------------------------------------------------------------------
*/

var newMessages = setInterval(function()
{
    var timestring = new Date().getTime();
    $('#newmessage').load(base+'chat/get_new_messages/'+ timestring);
}, 2000);

/*
|------------------------------------------------------------------------------
| Timer to get online users available for chatting
|------------------------------------------------------------------------------
*/

var onlineusers = setInterval(function()
{
    var timestring = new Date().getTime();
    $('#onlineusers').load(base+'users/index/'+ timestring);
}, 10000);

/*

/*
|----------------------------------------------------------------------------
| End of file
|----------------------------------------------------------------------------
*/

</script>

 <script> 
    var time = 0;
  
    var updateTime = function (cb) {
      $.getJSON("index.php/chat/time", function (data) {
          cb(~~data);
      });
    };
    
    var sendChat = function (message, cb) {
      $.getJSON("index.php/chat/insert_chat?message=" + message, function (data){
        cb();
      });
    }
    
    var addDataToReceived = function (arrayOfData) {
      arrayOfData.forEach(function (data) {
        $("#received").val($("#received").val() + "\n" + data[0]);
      });
    }
    
    var getNewChats = function () {
      $.getJSON("index.php/chat/get_chats?time=" + time, function (data){
        addDataToReceived(data);
        // reset scroll height
        setTimeout(function(){
           $('#received').scrollTop($('#received')[0].scrollHeight);
        }, 0);
        time = data[data.length-1][1];
      });      
    }
  
    // using JQUERY's ready method to know when all dom elements are rendered
    $( document ).ready ( function () {
      // set an on click on the button
      $("form").submit(function (evt) {
        evt.preventDefault();
        var data = $("#text").val();
        $("#text").val('');
        // get the time if clicked via a ajax get queury
        sendChat(data, function (){
          alert("dane");
        });
      });
      setInterval(function (){
        getNewChats(0);
      },1500);
    });
    
  </script>
