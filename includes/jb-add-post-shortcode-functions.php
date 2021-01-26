<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function jb_scripts() {

	wp_enqueue_script('jquery');

	wp_enqueue_style('jb-style',
		plugin_dir_url( __FILE__ ) . '../assets/css/style.css'
	);
	wp_enqueue_script('jb-main-script',
		plugin_dir_url( __FILE__ ) . '../assets/js/main.js',
		array('jquery')
	);

	$public_settings = array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'ajaxNonce' => wp_create_nonce( 'ajax_nonce' ),
	);
	wp_localize_script( 'jb-main-script', 'jbSettings', $public_settings );
	
}

function jb_add_post_form_func() { ?>

	<div id="jb-form-wrap">
	    <form id="jb-form" method="post">
		    <p>
		    	<label for="jb-title"><?php _e('Title', 'jb'); ?></label>
		        <input type="text" id="jb-title" value="" />
		    </p>
		    <p>
		        <label for="jb-content"><?php _e('Content', 'jb'); ?></label>
		        <textarea id="jb-content" cols="50" rows="6"></textarea>
		    </p>
	    	<p class="jb-submit">
	    		<input type="submit" value="<?php _e('Publish', 'jb'); ?>" id="jb-submit-button" />
	    		<img class="jb-loader" style="display: none;" src="<?php echo plugins_url('../assets/images/ajax-loader.gif', __FILE__); ?>">
	    	</p>
	    
	    </form>
	    <div class="jb-response-block">
	    	<p class="jb-error">
	    		<?php _e('Form submission error!', 'jb'); ?>
	    	</p>
	    	<p class="jb-success">
	    		<?php _e('Post saved successfully!', 'jb'); ?>
	    	</p>
	    	<p class="jb-validation-title">
	    		<?php _e('Please enter a title!', 'jb'); ?>
	    	</p>
	    	<p class="jb-validation">
	    		<?php _e('Post with the same title already exists!', 'jb'); ?>
	    	</p>
	    </div>
	</div>

<?php }


function jb_send_post() {

    if( !isset( $_REQUEST['ajax_nonce'] ) || !wp_verify_nonce( $_REQUEST['ajax_nonce'], 'ajax_nonce' ) )
    die('Permission denied');	

    if ( !isset($_POST['title']) || $_POST['title'] == '') {
    	echo 'empty';
       	wp_die();
    }

    if( post_exists($_POST['title']) ) {
    	echo 'exists';
        wp_die();
    }

    $post = array(
        'post_title'    => $_POST['title'],
        'post_content'  => $_POST['content'],
        'post_status'   => 'draft',
        'post_type' 	=> 'post'
    );
    wp_insert_post($post);

	$jb_options = get_option( 'jb_options' );
	$email = $jb_options['jb_email'] ? : get_option('admin_email');

	$to = '<'.$email.'>';

	$subject = 'New post added to drafts!';
	$message = '<p>Title: '.$_POST['title'].'</p>';
	$message .= '<p>Content: '.$_POST['content'].'</p>';

	mail($to, $subject, $message);

	wp_die();

}
