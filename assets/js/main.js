var $ = jQuery.noConflict();
jQuery(document).ready(function(){

	jQuery('#jb-submit-button').click(function(e){
        e.preventDefault();
        var title = $('#jb-title').val();
        var content = $('#jb-content').val();
        jQuery.ajax({
            type: 'POST',
            url: jbSettings.ajaxUrl,
            data: {
                action: 'jb_post_form',
                ajax_nonce: jbSettings.ajaxNonce,
                title: title,
                content: content
            },
            beforeSend: function(){
            	jQuery('#jb-submit-button').hide();
            	jQuery('.jb-loader').show();
            },
            success: function(response){
            	setTimeout(function () {
                    console.log(response);
                    jQuery('#jb-submit-button').show();
                    jQuery('.jb-loader').hide();
	                if(response == 'empty'){
	                	$('.jb-response-block .jb-validation-title').show();
	                	$('.jb-response-block .jb-validation').hide();
	                } else if(response == 'exists'){
	                	$('.jb-response-block .jb-validation').show();
	                	$('.jb-response-block .jb-validation-title').hide();
	                } else {
	                	$('#jb-title, #jb-content').val('');
		                $('.jb-response-block p').hide();
		                $('.jb-response-block .jb-success').show();
	                }
                }, 500)
            },
            error: function(){
                $('.jb-response-block .jb-error').show();
            }

        });
    });

});