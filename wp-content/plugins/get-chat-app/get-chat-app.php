<?php
/*
Plugin Name: Get Chat App
Plugin URI: https://getchat.app
Description: Add a WhatsApp chat button to your website in seconds. Allow visitors to simply tap to chat through WhatsApp.
Version: 1.1.00
Author: Code Cabin
Author URI: https://www.codecabin.io
Text Domain: getchatapp
Domain Path: /languages
*/

/*
 * 1.1.00 - 2020-10-29
 * Added in support for Facebook and Email buttons
 * 
 * 1.0.05 - 2020-10-15
 * TrustedOrigin added
 * 
 * 1.0.04 - 2020-09-30
 * Added a support link on the main settings page
 * 
 * 1.0.03 - 2020-09-23
 * Fixed a bug where the demo wasnt updating properly
 * Fixed a styling bug
 * Added support for the new pro feature - Custom Icon
 * 
 * 1.0.02 - 2020-09-14
 * Added UT8 support for some databases that didnt like storing the Emojis
 * 
 * 1.0.01 - 2020-08-31
 * Changes to the Pro menu
 * 
 * 1.0.00 - 2020-08-28
 * Launch!
 * 
 
*/

register_activation_hook( __FILE__, 'gcap_activate');
register_deactivation_hook(__FILE__, 'gcap_deactivate');
register_uninstall_hook(__FILE__, 'gcap_uninstall');

global $gcap_version;
global $gcap_version_string;

$gcap_version = "1.0.05";
$gcap_version_string = "Basic";

add_action('admin_menu', 'gcap_add_menu_items');
 
function gcap_add_menu_items(){
	$icon = plugin_dir_url( __FILE__ ) . 'assets/img/whatsapp-menu-icon.png';
    add_menu_page( 'GetChatApp', 'Get Chat App', 'manage_options', 'gcap', 'gcap_main_page', $icon );
}
 
add_action( 'wp_footer', 'gcap_add_code', 10 );

function gcap_add_code() {

	$options = get_option('gcap_settings');
	
	if ($options['status']) { $enabled = $options['status']; } else { $enabled = '1'; }
	if ($options['whatsapp']) { $whatsapp = $options['whatsapp']; } else { $whatsapp = 'false'; }
	if ($options['facebook']) { $facebook = $options['facebook']; } else { $facebook = 'false'; }
	if ($options['email']) { $email = $options['email']; } else { $email = 'false'; }
	if ($options['mobileNumber']) { $mobileNumber = $options['mobileNumber']; } else { $mobileNumber = ''; }
	if ($options['facebookPageId']) { $facebookPageId = $options['facebookPageId']; } else { $facebookPageId = ''; }
	if ($options['gcaEmailAddress']) { $gcaEmailAddress = $options['gcaEmailAddress']; } else { $gcaEmailAddress = ''; }
	if ($options['gcaEmailSubject']) { $gcaEmailSubject = $options['gcaEmailSubject']; } else { $gcaEmailSubject = ''; }
	if ($options['titleMessage']) { $titleMessage = $options['titleMessage']; } else { $titleMessage = '👋 Chat with me on WhatsApp!'; }
	if ($options['position']) { $position = $options['position']; } else { $position = 'right'; }
	if ($options['welcomeMessage']) { $welcomeMessage = $options['welcomeMessage']; } else { $welcomeMessage = "Hey there!🙌

Get in touch with me by typing a message here. It will go straight to my phone! 🔥

~Your Name"; }

	if($whatsapp == 'whatsapp')
	{
		$whatsapp = 'true';
		$facebook = 'false';
		$email = 'false';
	}
		if($facebook == 'facebook')
		{
			$whatsapp = 'false';
			$facebook = 'true';
			$email = 'false';
		}
		elseif($email == 'email')
		{
			$whatsapp = 'false';
			$facebook = 'false';
			$email = 'true';
		}

		if ($mobileNumber == '' && $whatsapp == 'true' || $facebookPageId == '' && $facebook == 'true' || $gcaEmailAddress == '' && $email == 'true' || $enabled == '0') {
			// there is no mobile number - do not show.
			// in future: still show it but put a warning on the front end
			return false;
		} else {
			wp_enqueue_script( 'get-chat-app', 'https://getchat.app/___test/__getchatapp.js', false, '1.0.0', false );
		

		?>

		
		
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			var gcaMain = new GetChatApp({
				'mobileNumber' : '<?php echo $mobileNumber; ?>',
				'titleMessage' : '<?php echo $titleMessage; ?>',
				'welcomeMessage': '<?php echo trim(preg_replace('/\s+/', ' ', $welcomeMessage)); ?>',
				'position' : '<?php echo $position; ?>',
				'platforms' : {
					'whatsapp' : <?php echo $whatsapp; ?>,
					'facebook' : <?php echo $facebook; ?>,
					'email' :  <?php echo $email; ?>,
				},
				'facebookPageId' : '<?php echo $facebookPageId; ?>',
				'gcaEmailAddress' : '<?php echo $gcaEmailAddress; ?>',
				'gcaEmailSubject' : '<?php echo $gcaEmailSubject; ?>',
			});
		});
		</script>



		<?php


	}

}


function gcap_main_page(){
	$icon = plugin_dir_url( __FILE__ ) . 'assets/img/whatsapp-icon-30x30.png';
    
    echo "<h1><img class='gcap-admin-icon' src='".$icon."'/> GetChat.App</h1>";


    $options = get_option('gcap_settings');
    
    if ($options) {
		$enabled = $options['status'];
		$whatsapp = $options['whatsapp'];
		$facebook = $options['facebook'];
		$email = $options['email'];
	    $mobileNumber = $options['mobileNumber'];
	    $titleMessage = $options['titleMessage'];
	    $welcomeMessage = preg_replace('#<br\s*/?>#i', "\n", $options['welcomeMessage']);
		$position = $options['position'];
		$facebookPageId = $options['facebookPageId'];
		$gcaEmailAddress = $options['gcaEmailAddress'];
		$gcaEmailSubject = $options['gcaEmailSubject'];
	} else {
		$enabled = '1';
		$whatsapp = true;
		$facebook = false;
		$email = false;
		$mobileNumber = '';
		$titleMessage = '👋 Chat with me on WhatsApp!';
		$welcomeMessage = "Hey there!🙌

Get in touch with me by typing a message here. It will go straight to my phone! 🔥

~Your Name";
		$position = 'right';
		$facebookPageId = '';
		$gcaEmailAddress = '';
		$gcaEmailSubject = '';
	}


    ?>

	<p>&nbsp;</p>


	<div class='gcaContent'>
		<div class="row">
	        <div class="col-md-12 col-sm-6 col-xs-12 text-left">

            	<div class="row  mb-20">
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
						<div class="row  mb-20">
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Status</label>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<select name='gcaEnabled' id='gcaEnabled'>
									<option value='1' <?php echo ($enabled == '1') ? 'selected' : ''; ?>>Enabled</option>
									<option value='0' <?php echo ($enabled == '0') ? 'selected' : ''; ?>>Disabled</option>
								</select>
							</div>

						</div>
                	</div>

				</div>
				<div class="row  mb-20">
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
						<div class="row  mb-20" id="basicPlatforms">
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Select a platform:</label>
								<br><p id="showProApps">(<em >Select multiple platforms with the <a target='_BLANK' href='https://getchat.app/wordpress/?utm_campaign=multiple&utm_source=gcaplugin&utm_medium=click'>Pro version</a></em>)</p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<ul class="platforms-list" id="chat-platforms">
									<li>
										<button class="whatsapp-btn platform-btn">
											<input type="checkbox" value="whatsapp" id="whatsappMainBtn" name="displayplatformRadio1" class="whatsappMainBtn platform-option" <?php echo $whatsapp; ?> <?php echo ($whatsapp == 'whatsapp') ? 'checked="checked"' : ''; ?>>
										</button>
									</li>
									<li>
										<button class="facebook-btn platform-btn">
											<input type="checkbox" value="facebook" id="facebookMainButton" name="displayplatformRadio2" class="facebookMainButton platform-option" <?php echo $facebook; ?> <?php echo ($facebook == 'facebook') ? 'checked="checked"' : ''; ?>>
										</button>
									</li>
									<li>
										<button class="email-btn platform-btn">
											<input type="checkbox" value="email" id="emailMainBtn" name="displayplatformRadio3" class="emailMainBtn platform-option" <?php echo ($email == 'email') ? 'checked="checked"' : ''; ?>>
										</button>
									</li>
								</ul>
	                		</div>
	            		</div>
                	</div>

				</div>
			</div>

	        <div class="col-md-6 col-sm-6 col-xs-12 text-left">
				<div class="row  mb-20 mobileNumber">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
						<div class="row ">
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left" >
								<label>Your Mobile Number</label>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
						<input type="text" id="mobileNumber" class="demoInputArea" value="<?php echo $mobileNumber; ?>"><br>
						<p class="exampleText">Example: +1 541 754 3010</p>
					</div>
				</div>

				<div class="row  mb-20 facebookPageId">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
						<div class="row ">
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Your Facebook Page ID</label>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
						<input type="text" id="facebookPageId" class="demoInputArea" value="<?php echo $facebookPageId; ?>"><br>
						<p class="exampleText">Example: GetChatApp</p>
					</div>
				</div>


				<div class="row  mb-20 gcaEmailAddress">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
						<div class="row " >
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Your Email Address</label>
							</div>
						</div>
					</div>
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <input type="text" id="gcaEmailAddress" class="demoInputArea" value="<?php echo $gcaEmailAddress; ?>"><br>
	                    <p class="exampleText">Example: test@test.com</p>
	                </div>
				</div>

				<div class="row  mb-20 gcaEmailAddress">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
						<div class="row " >
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Your Email Subject</label>
							</div>
						</div>
					</div>
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <input type="text" id="gcaEmailSubject" class="demoInputArea" value="<?php echo $gcaEmailSubject; ?>"><br>
	                    <p class="exampleText">Example: Get Chat App</p>
	                </div>
				</div>

				<div class="row  mb-20 gcaWhatsappOnly">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
	            		<div class="row ">
							<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
								<label>Custom title</label>
							</div>
						</div>
					</div>
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <textarea type="text" id="titleMessage" style="height:50px;" class="demoTextArea"><?php echo $titleMessage; ?></textarea>  
	                </div>
	            </div>

				<div class="row  mb-20 gcaWhatsappOnly">
					<div class="col-md-6 col-sm-6 col-xs-12 text-left">
	            		<div class="row ">
	                		<div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    		<label>Custom welcome message</label>
	                		</div>
						</div>
					</div>
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <textarea type="text" id="welcomeMessage" style="height:135px;" class="demoTextArea"><?php echo $welcomeMessage; ?></textarea>  
	                </div>
	            </div>

	            

	            <div class="row mb-20">
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <label>Position</label>
	                </div>
	                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
	                    <label class="radio-inline">
	                        <input class="" id="position1" type="radio" name="positionRadio" value="left" <?php echo ($position == 'left') ? 'checked="checked"' : ''; ?>>
	                        Left
	                    </label>
	                    <label class="radio-inline">
	                        <input class="" id="position1" type="radio" name="positionRadio" value="right" <?php echo ($position == 'right') ? 'checked="checked"' : ''; ?>>
	                        Right
	                    </label>
	                    
	                </div>

	            </div>
				<?php do_action('gcap_pro_features_show_button', $options); ?>         

	        </div>  <!--//.COL-->
	        <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center">

				<div class="demo-container">
					<div class="demo-card-container">
					
						<div id="DEMO_gcaMainCard" class="gcaMainCard gca_hidden">
							<div id="DEMO_gcaMainCardInner" class="gcaMainCardInner">
								<div id="DEMO_gcaMainCardInnerTop" class="gcaMainCardInnerTop">
									<div id="DEMO_gcaMainCardInnerTopContent" class="gcaMainCardInnerTopContent">👋 &nbsp; Chat with us on WhatsApp!
									</div>
								</div>
								<div id="DEMO_gcaMainCardInnerBody" class="gcaMainCardInnerBody">
									<div id="DEMO_gcaMainCardInnerBodyMessage" class="gcaMainCardInnerBodyMessage" style="text-align: left;">Hey there!🙌<br><br>Get in touch with me by typing a message here. It will go straight to my phone! 🔥<br /><br>~Your Name
									</div>
								</div>
								<div id="DEMO_gcaMainCardInnerChatBox" class="gcaMainCardInnerChatBox">
									<textarea id="DEMO_gcaMainCardInnerChatBoxTextArea" class="gcaMainCardInnerChatBoxTextArea"></textarea>
									<span id="DEMO_gcaMainCardInnerChatBoxSend" class="gcaMainCardInnerChatBoxSend"></span>
								</div>
							
							</div>
						</div>
								
		
			
						<div id="DEMO_gcaFacebookMainCard" class="gcaFacebookMainCard gca_hidden">
							<iframe id="gcaFbIframe" class="gca_hover_shared" src="https://web.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FGetChatApp&amp;tabs=messages&amp;width=302&amp;height=300&amp;small_header=true&amp;adapt_container_width=true&amp;hide_cover=true&amp;show_facepile=false&amp;appId%22&amp;_rdc=1&amp;_rdr" data-origwidth="" data-origheight=""></iframe>
						</div>
					</div>

					<div class="demo-button-container">
						<div id="DEMO_gcaMainButton4" class="gcaMainButton gca_hidden"></div>	
						<div id="DEMO_gcaMainButton3" class="gcaMainButton gca_hidden"></div>   
						<div id="DEMO_gcaMainButton_2" class="gcaMainButton gca_hidden"></div>
						<div id="DEMO_gcaMainButton5" class="gcaMainButton gca_hidden"></div>
					</div>
				</div>

    		</div>	
		</div>		

		<?php do_action('gcap_pro_features', $options); ?>

	    


		<div class="row">
	        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
				<a href='javascript:void(0);' title='Save Button' id='gcaSaveSettings' class='button button-primary'>Save Settings</a>
				<br />

				<span id='gcaStatus'></span>
				<br /><em><span>Need help or have any questions? <a target='_BLANK' href='https://getchat.app/?ref=startchat'>Start a chat with me on GetChat.app</a>.</span></em>

			</div>
		</div>

    </div>   

	

	

	





<?php
}

add_action('gcap_pro_features_show_button','gcap_pro_features_basic_show_button', 10);
function gcap_pro_features_basic_show_button($options) {
	?>
	<div class="row mb-50" id='proFeatures'>
	    <div class="col-md-6 col-sm-6 col-xs-12">
			  <label>Pro features</label>		

	    </div>
	    <div class="col-md-6 col-sm-6 col-xs-12 text-left">
			<a href='javascript:void(0);' class='button button-secondary' id='showProFeatures'>🔥 Show Pro Features</a>

			<a href='javascript:void(0);' class='button button-secondary' id='hideProFeatures' style='display:none'>😞 Hide Pro Features</a>



	    </div>

	</div>
	<?php
}


add_action('gcap_pro_features', 'gcap_upsell_pro_features', 10);
function gcap_upsell_pro_features($options) {
	?>

	<div class="row" id='gcaProFeaturesDiv' style='display:none;'>
		<div class="col-md-12 col-sm-12 col-xs-12">

		    <div class="row">
			    <div class="col-md-6 col-sm-6 col-xs-12 text-left">
					<h3>Pro features</h3>

				</div>
			</div>
		    <div class="row">
			    <div class="col-md-6 col-sm-6 col-xs-12 text-left">


					<div class="row mb-20">
                        <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
                            <label>Encrypt Mobile Number</label>
                            <br>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
                             <input class="profeature" type="checkbox" id="encrypted" name="encryptedRadio" value="encrypted" disabled='disabled' readonly='readonly'> Ensure mobile number is not indexed by Google
                            
                        </div>

                    </div>

                    <div class="row mb-20">
                        <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
                            <label>Custom Icon</label>
                            <br>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
                            <input id="gcaCustomIcon" type="text" name="gcaCustomIcon" value=""  disabled='disabled' readonly='readonly'> <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select', 'getchatap' ); ?>" id="" disabled='disabled' readonline='readonly'/>
                            
                        </div>

                    </div>	

			        <div class="row mb-20">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Enable Hover Message</label>
			                <br>(<em>Increases leads by 200%</em>)
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label class="radio-inline">
			                    <input class="profeature" id="hover1" type="radio" name="hoverRadio" value="no" disabled="disabled" checked="">
			                    No
			                </label>
			                <label class="radio-inline">
			                    <input class="profeature" id="hover2" type="radio" name="hoverRadio" value="yes" disabled="disabled">
			                    Yes
			                </label>
			                
			            </div>

			        </div>

			        <div class="row mb-20">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Message pops up in</label>                                                
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label class="">
			                    <span class="nobold">
			                    <input id="hoverd" class="demoInputArea profeature" type="number" name="hoverDuration" value="1" disabled="disabled" checked="">
			                    second(s)</span>
			                </label>
			                
			                
			            </div>

			        </div>

			        <div class="row">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Hover text</label>
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <textarea type="text" id="hoverMessage" class="demoTextArea profeature" disabled="" readonly="">Click here to chat with us directly</textarea>  
			            </div>

			        </div>

			        <div class="row mb-20">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Display on</label>
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label class="radio-inline">
			                    <input class="profeature" id="display1" type="radio" name="displayRadio" value="both" disabled="disabled" checked="">
			                    Both
			                </label>
			                <label class="radio-inline">
			                    <input class="profeature" id="display2" type="radio" name="displayRadio" value="desktop" disabled="disabled">
			                    Desktop
			                </label>
			                <label class="radio-inline">
			                    <input class="profeature" id="display3" type="radio" name="displayRadio" value="mobile" disabled="disabled">
			                    Mobile
			                </label>
			            </div>

			        </div>

			        <div class="row mb-20">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Disable Branding</label>
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                
			                <input class="profeature" type="checkbox" id="branding" name="displayBrandingRadio" value="branding" disabled="disabled">
			                Remove 'GetChat.app' link
			            
			                
			            </div>

			        </div>

			        



			        <div class="row mb-20" id="proUpgradeRow">
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                <label>Upgrade Now</label>
			            </div>
			            <div class="col-md-6 col-sm-6 col-xs-12 xs-text-left">
			                
			                <a href='https://getchat.app/wordpress/?utm_campaign=upgradebtn&utm_source=gcaplugin&utm_medium=click' title='Upgrade Now' class='button button-primary'>Upgrade Now</a><br /><span style="color:red; margin-left:2px;">Only $2/mo</span>
			               
			                
			            </div>

			        </div>



			        
			        
			    </div>  <!--//.COL-->
			    <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center">
			        <div id="DEMO_hoverdiv">
			            <div id="DEMO_gcaMainHover" class="gcaMainHover gcaDisplay">
			                <div id="DEMO_gcaMainHoverInner" class="gcaMainHoverInner">
			                    <div id="DEMO_gcaMainHoverInnerMessage" class="gcaMainHoverInnerMessage">👋 &nbsp; Click here to chat with us
			                    </div>
			                </div>
			            </div>
			            <div id="DEMO_gcaMainButton2" class="gcaMainButton"></div>
			        </div>
			                    
			    </div>

		    </div> 
		</div>
	</div>
	<script type="text/javascript">
		var gcaIsPro = false;
	</script>


	<?php
}


function gcap_activate() {

}


function gcap_deactivate() {

}


function gcap_uninstall() {

}

add_action( 'wp_ajax_gcapSaveSettings', 'gcap_ajax_callback' );
add_action( 'wp_ajax_nopriv_gcapSaveSettings', 'gcap_ajax_callback' );

function gcap_ajax_callback() {
	    $check = check_ajax_referer('gcap', 'security');
	    if ($check == 1) {
	    	 if ($_POST['action'] == "gcapSaveSettings" ) {
	        	
	    	 	// build the JS for the front end
	    	 	
	    	 	unset( $_POST['action'] );
	    	 	unset( $_POST['security'] );

	    	 	$tags = array();
	    	 	$tags['br'] = array();

	    	 	$data_store = array();

	    	 	if ( isset( $_POST['mobileNumber'] ) ) { $data_store['mobileNumber'] = sanitize_text_field( $_POST['mobileNumber'] ); }
				if ( isset( $_POST['whatsapp'] ) ) { $data_store['whatsapp'] = sanitize_text_field( $_POST['whatsapp'] ); }
				if ( isset( $_POST['facebook'] ) ) { $data_store['facebook'] = sanitize_text_field( $_POST['facebook'] ); }
				if ( isset( $_POST['email'] ) ) { $data_store['email'] = sanitize_text_field( $_POST['email'] ); } 
				if ( isset( $_POST['titleMessage'] ) ) { $data_store['titleMessage'] = wp_encode_emoji( sanitize_text_field( $_POST['titleMessage'] ) ); }
	    	 	if ( isset( $_POST['welcomeMessage'] ) ) { $data_store['welcomeMessage'] = wp_encode_emoji( wp_kses( str_replace("<br />\n<br />","<br />",trim( nl2br( $_POST['welcomeMessage'] ) ) ), $tags ) ); }
	    	 	if ( isset( $_POST['position'] ) ) { $data_store['position'] = sanitize_text_field( $_POST['position'] ); }
	    	 	if ( isset( $_POST['status'] ) ) { $data_store['status'] = sanitize_text_field( $_POST['status'] ); }
				if ( isset( $_POST['gcaEmailAddress'] ) ) { $data_store['gcaEmailAddress'] = sanitize_text_field( $_POST['gcaEmailAddress'] ); }
				if ( isset( $_POST['gcaEmailSubject'] ) ) { $data_store['gcaEmailSubject'] = sanitize_text_field( $_POST['gcaEmailSubject'] ); }
				 
				if ( isset( $_POST['facebookPageId'] ) ) { $data_store['facebookPageId'] = sanitize_text_field( $_POST['facebookPageId'] ); }
	    	 	$data_store = apply_filters("gcap_filter_save_settings", $data_store);		
	    	 	

	    	 	
	    	 	update_option( 'gcap_settings', $data_store );

	        	wp_die('1');
	        }

	    }

	}


add_action( 'admin_enqueue_scripts', 'gcap_load_admin_styles' );
add_action( 'admin_enqueue_scripts', 'gcap_load_admin_scripts' );

function gcap_load_admin_styles() {

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'gcap' ) {
		wp_enqueue_style( 'admin_css_gcap', plugin_dir_url( __FILE__ ) . '/assets/css/admin-style.min.css', false, '1.0.0' );
		wp_enqueue_style( 'admin_css_gcap_flexbox', plugin_dir_url( __FILE__ ) . '/assets/css/flexboxgrid.min.css', false, '1.0.0' );

		
	}
} 


function gcap_load_admin_scripts() {

	if ( isset( $_GET['page'] ) && $_GET['page'] == 'gcap' ) {
		$gcap_ajaxurl = admin_url('admin-ajax.php');
		$gcap_nonce = wp_create_nonce("gcap");
		wp_enqueue_script( 'gcap_admin', plugin_dir_url( __FILE__ ) . '/assets/js/gca_admin.js', false, '1.0.0', false );
		wp_localize_script( 'gcap_admin', 'gcap_ajaxurl', $gcap_ajaxurl );
		wp_localize_script( 'gcap_admin', 'gcap_nonce', $gcap_nonce );
		

		
	}
}