<?php
/*
 * Plugin Name:		Custom Login Link
 * Description:		Easily rememberable link in addition to wp-admin
 * Text Domain:		custom-login-link
 * Domain Path:		/languages
 * Version:			1.01
 * WordPress URI:	https://wordpress.org/plugins/custom-login-link/
 * Plugin URI:		https://puvox.software/wordpress/
 * Contributors: 	puvoxsoftware,ttodua
 * Author:			Puvox.software
 * Author URI:		https://puvox.software/
 * Donate Link:		https://paypal.me/Puvox
 * License:			GPL-3.0
 * License URI:		https://www.gnu.org/licenses/gpl-3.0.html
 
 * @copyright:		Puvox.software
*/


namespace CustomLoginLink
{
  if (!defined('ABSPATH')) exit;
  require_once( __DIR__."/library_default_puvox.php" );


  class PluginClass extends \Puvox\default_plugin
  {
	public function declare_settings()
	{
		$this->initial_static_options	= 
		[
			'has_pro_version'		=>0, 
			'show_opts'				=>true, 
			'show_rating_message'	=>true, 
			'show_donation_popup'	=>true, 
			'display_tabs'			=>[],
			'required_role'			=>'install_plugins', 
			'default_managed'		=>'network',			// network | singlesite
		];

		$this->initial_user_options		= 
		[	
			'suffix'	=> 'admin',
		]; 
	}

	public function __construct_my()
	{ 
		if ( $this->CalledBase() == $this->opts['suffix'] ){
			header('Location: '. admin_url() ); exit;
		}
	}
	// ============================================================================================================== //


	
 
	// =================================== Options page ================================ //

	public function homeUrl() { return trailingslashit(home_url()); }
	public function CalledBase() { return basename(parse_url($_SERVER['REQUEST_URI'])['path']); }
	
	public function opts_page_output()
	{ 
		$this->settings_page_part("start");
		?>

		<style> 
		</style>

		<?php if ($this->active_tab=="Options") 
		{ 
			//if form updated
			if( $this->checkSubmission() )
			{ 
				$this->opts['suffix']	=  sanitize_key($_POST[ $this->plugin_slug ]['suffix']) ;  
				$this->update_opts();  
			}
			?>
 
			<form class="mainForm" method="post" action="">
				<p class="description">
				   <?php _e('Note, this doesn\'t hide <code>wp-admin</code> (because there is not a much security gain with hiding it), instead this plugin just adds ability to use a short word in addition to <code>wp-admin</code>');?>
				</p>
			<table class="form-table">
				<tr class="def">
					<th scope="row">
						<?php _e('Enter desired custom word', 'custom-login-link'); ?>
					</th>
					<td>
						<fieldset>
							<p class="">
								<input name="<?php echo $this->plugin_slug;?>[suffix]" type="text" value="<?php echo $this->opts['suffix'];?>" oninput="(document.getElementById('suffix_preview').innerHTML=this.value)" />
							</p>
							<?php echo $this->homeUrl();?><code id="suffix_preview"><?php echo $this->opts['suffix'];?></code>
						</fieldset>
					</td>
				</tr> 
			</table>
			
						
			<?php $this->nonceSubmit(); ?>

			</form> 
		<?php 
		}
		

		$this->settings_page_part("end");
	}





  } // End Of Class

  $GLOBALS[__NAMESPACE__] = new PluginClass();

 
} // End Of NameSpace

?>