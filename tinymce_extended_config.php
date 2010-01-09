<?php
/**
 * Plugin Name: TinyMCE Extended Config
 * Plugin URI: http://willshouse.com/tinymce-extended-config/
 * Description: Allows one to configure some of the advanced settings of the TinyMCE editor, like the block formats. (theme_advanced_blockformats)
 * Version: 0.1.0
 * Author: Will Clarke
 * Author URI: http://www.willshouse.com/
 * 
 * Allows one to configure some of the advanced settings of the TinyMCE 
 * editor, like the block formats. (theme_advanced_blockformats)
 * 
 * Copyright (C) 2008-2009
 */

/**
 * Activation hook
 */
function tmec_activate() {
    if ( ! get_option('tmec_theme_advanced_blockformats') ) {
        add_option('tmec_theme_advanced_blockformats', '');
    }
    if ( ! get_option('tmec_content_css') ) {
        add_option('tmec_content_css', '');
    }
		
		return;
}

/**
 * Deactivation hook
 */
function tmec_deactivate() {
    delete_option('tmec_theme_advanced_blockformats');
    delete_option('tmec_content_css');
}


function tmec_add_admin_pages() {
    add_management_page('TinyMCE Extended Config', 'TinyMCE Extended Config', 10, __FILE__, 'tmec_admin_menu');
}


function tmec_is_alnum( $str ) {
    return strspn($str, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789") == strlen($str);
}

function tmec_is_alnumcsv( $str ) {
    return strspn($str, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789, ") == strlen($str);
}


function tmec_is_alpha( $str ) {
    return strspn($str, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == strlen($str);
}

if ( ! function_exists('tmec_set_extended_config') ) {
	function tmec_set_extended_config($init) {

		$block_formats = get_option('tmec_theme_advanced_blockformats');
		if(!empty($block_formats)){
			$init['theme_advanced_blockformats'] = $block_formats;
		}

		$tmec_content_css = get_option('tmec_content_css');
		if(is_file(TEMPLATEPATH.'/'.$tmec_content_css)){
			$init['content_css'] = get_bloginfo('template_url').'/'.$tmec_content_css;
		}elseif(is_file(ABSPATH.$tmec_content_css)){
			$init['content_css'] = get_bloginfo('wpurl').'/'.$tmec_content_css;
		}

		return $init;
	}
}


function tmec_do_actions() {
    $mesg = '';
    $emesg = '';

    if ( isset( $_GET[ 'tmec_theme_advanced_blockformats' ] ) ) {
        if ( ! empty( $_GET[ 'tmec_theme_advanced_blockformats' ] ) ) {
            if ( tmec_is_alnumcsv( $_GET[ 'tmec_theme_advanced_blockformats' ] ) ) {
                update_option('tmec_theme_advanced_blockformats', $_GET[ 'tmec_theme_advanced_blockformats' ]);
                $mesg = 'Block elements set to  \'' . $_GET[ 'tmec_theme_advanced_blockformats' ] . '\'. Refresh TinyMCE (ctrl + F5).';
                }
							else {
                $emesg = "New tags must contain numbers and letters only, comma separated eg: (p,address,pre,h1,h2,h3,h4,h5,h6).";
            }
        } else {
            $emesg = "New tags can't be empty. Defaults are (p,address,pre,h1,h2,h3,h4,h5,h6)";
        }
			}


    if ( isset( $_GET[ 'tmec_content_css' ] ) ) {
        if ( ! empty( $_GET[ 'tmec_content_css' ] ) ) {
						$valid_chars = 'a-zA-Z0-9:\/\\';
            if ( strlen($_GET[ 'tmec_content_css']) == strlen(eregi_replace("/$valid_chars/",'', $_GET[ 'tmec_content_css'])) ) {
                update_option('tmec_content_css', $_GET[ 'tmec_content_css' ]);
                $mesg = 'TinyMCE CSS path set to  \'' . $_GET[ 'tmec_content_css' ] . '\'. Refresh TinyMCE (ctrl + F5).';
                }
							else {
                $emesg = "New tags must contain numbers and letters only, comma separated eg: (p,address,pre,h1,h2,h3,h4,h5,h6).";
            }
        } else {
            $mesg = "CSS path successfully deleted";
            update_option('tmec_content_css', '');
        }
			}
    
    if ( ! empty( $mesg ) ) {
        echo '<div id="message" class="updated fade"><p>'. $mesg . '</p></div>';
    }
    if ( ! empty( $emesg ) ) {
        echo '<div id="message" class="error fade" style="background-color: red"><p>'. $emesg . '</p></div>';
    }
}


function tmec_admin_menu() {
    tmec_do_actions();
		tmec_show_config();
		return;
}

function tmec_show_config(){
	$tmec_content_css = get_option('tmec_content_css');
?>
	<div class="wrap">
		<h2>TinyMCE Extended Configuration</h2>
		<h3>Edit Block Formats:</h3>
    <form name="add_element_form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>"/>
      <input type="text" name="tmec_theme_advanced_blockformats" size="55" 
				value="<?php echo (isset($_GET[ 'tmec_theme_advanced_blockformats' ])?$_GET[ 'tmec_theme_advanced_blockformats' ]:get_option('tmec_theme_advanced_blockformats')); ?>" />
      <input type="submit" name="Submit" value="Update" />
    </form>

		<h3>Edit CSS include path:</h3>
		<strong>Checking these locations</strong>:<br />
		<code><?php echo TEMPLATEPATH.'/'.$tmec_content_css.' ('.(is_file(TEMPLATEPATH.'/'.$tmec_content_css)?'found':'not found').')'; ?> 
		<br /><?php echo ABSPATH.$tmec_content_css.' ('.(is_file(ABSPATH.$tmec_content_css)?'found':'not found').')'; ?> </code>
    <form name="add_element_form" method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>"/>
      <input type="text" name="tmec_content_css" size="55" 
				value="<?php echo (isset($_GET[ 'tmec_content_css' ])?$_GET[ 'tmec_content_css' ]:get_option('tmec_content_css')); ?>" />
      <input type="submit" name="Submit" value="Update" />
    </form>
		Example: '/css/tinymce.css'
	</div>
<?php
}

register_activation_hook(__FILE__, 'tmec_activate');
register_deactivation_hook( __FILE__, 'tmec_deactivate');

add_action('admin_menu', 'tmec_add_admin_pages');

add_filter('tiny_mce_before_init', 'tmec_set_extended_config');