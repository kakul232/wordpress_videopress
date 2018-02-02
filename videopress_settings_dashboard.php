
<!-- Polling Form Start Here ---->

 <?php do_action('bootsrtap_hook'); 

  echo $need_video_comment=get_user_meta (get_current_user_id(), 'need_video_comment', true );
  echo $need_askme=get_user_meta (get_current_user_id(), 'need_askme', true );
  echo $need_itro=get_user_meta (get_current_user_id(), 'need_itro', true );


 ?>
 
<div class="poll-wrap">
  
<div>

  <div class="pull-right">
Welcome @ <?php echo get_user_meta (get_current_user_id(), 'frankly', true ); ?>
<span id="logout">logout</span>
    
  </div>
  
  <div class="clear"></div>
  
<div class="row">
	<h1 class="col-xs-12 mr-bt-20">Videopress Settings</h1> 
	<div class="clear"></div>
  <?php echo @$msg; ?>
		<div class="clear mr-bt-20"></div>
    
	<form name="polling form" method="post" accept="<?php echo $_SERVER['php_self']; ?>">
		<div class="form-group mr-bt-10 clearfix">
			<label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Need Video Comment:</label>
      <input type="hidden" name="need_video_comment" value="">
			<input class="video_checkbox" type="checkbox" name="need_video_comment" id="need_video_comment">
      
			 <span class="error" id="error"></span>
		</div>

    <div class="form-group mr-bt-10 clearfix">
      <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Display Ask me Widget:</label>
      <input type="hidden" name="need_askme" value="">
      <input class="video_checkbox" type="checkbox" name="need_askme" id="need_askme">
      
       <span class="error" id="error"></span>
    </div>

    <div class="form-group mr-bt-10 clearfix">
      <label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Display Intro Video:</label>
      <input type="hidden" name="need_itro" value="">
      <input class="video_checkbox" type="checkbox" name="need_itro" id="need_itro">
      
       <span class="error" id="error"></span>
    </div>

		<div class="form-group col-xs-12">
			<input type="submit" id="save_frankly" name="save_frankly" class="btn button-primary button-large submit-btn" placeholder="" value="Save Change">
		</div>
	</form>

</div>


</div>

</div>

<script type="text/javascript">
/**********************************************************************************
@ Logout Button Call
***********************************************************************************/
(function($){
                $('#logout').click(function(){


                    $.ajax({
                            method: 'POST',
                            url: ajaxurl,
                            data: {
                                    
                                    'action': 'my_logout',
                                    

                                 },
                            success: function(response)
                            {
                                 var obj = JSON.parse(response);
                                 console.log(obj);
                                if(obj.flag=='1')
                                {
                                     window.location.assign('admin.php?page=Frankly');
                                }else{
                                     $('#user-result').html('<img src="' + '<?php echo plugins_url( 'images/not-available.png' , __FILE__ );?>' + '" /> Unable to proceed request !');
                                }
                              console.log(response);
                            }
                        });

                });
                 



/****************************************************************************************************
                        Checkbox true False
*****************************************************************************************************/


                $("#poll").bind("input",function(e){
									
									
							
									
                        var count_poll_char=$(this).val().length;
									
                        $('#charCount').html(count_poll_char+'/300');
                        if(count_poll_char<15 || count_poll_char>300)
                        {
                          $('#AskFrankly').attr("disabled", 'disabled');
                          $("#error").html('<font color="red">Question Should Be Between 15 -300 Character Long</font>');
                        }else
                        {
                          $('#AskFrankly').removeAttr('disabled');
                          $("#error").html("");
                        }


                        
                  });

               

})(jQuery);
            
</script>
<!-- Display poll End Here ---->

<script src="https://frankly.me/js/franklywidgets.js"> </script>

