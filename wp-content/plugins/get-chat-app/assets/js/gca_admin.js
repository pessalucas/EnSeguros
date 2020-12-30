document.addEventListener("DOMContentLoaded", function() {
	gcap_updateDemo();

	document.getElementById('welcomeMessage').addEventListener('input', () => { 
	   gcap_updateDemo();
	}, false); 
	document.getElementById('welcomeMessage').addEventListener('onpropertychange', () => { 
	   gcap_updateDemo();
	}, false); 


	document.getElementById('titleMessage').addEventListener('input', () => { 
	   gcap_updateDemo();
	}, false); 
	document.getElementById('titleMessage').addEventListener('onpropertychange', () => { 
	   gcap_updateDemo();
	}, false); 


	if (document.getElementById('gcaCustomIcon')) {
		document.getElementById('gcaCustomIcon').addEventListener('input', () => { 
		   gcap_updateDemo();
		}, false); 
		document.getElementById('gcaCustomIcon').addEventListener('onpropertychange', () => { 
		   gcap_updateDemo();
		}, false); 
	}



	document.getElementById('hoverMessage').addEventListener('input', () => { 
	   gcap_updateDemo();
	}, false); 
	document.getElementById('hoverMessage').addEventListener('onpropertychange', () => { 
	   gcap_updateDemo();
	}, false); 

	if (document.getElementById('facebookPageId')) {
		document.getElementById('facebookPageId').addEventListener('input', () => { 
			gcap_updateDemo();
		 }, false); 
		 document.getElementById('facebookPageId').addEventListener('onpropertychange', () => { 
			gcap_updateDemo();
		 }, false); 
	
	}
	gcap_updateDemo();
		jQuery('input.platform-option').on('change', function() {
			gcap_updateDemo();
		});

	if (document.getElementById("showProFeatures")) {
		document.getElementById("showProApps").style.display = 'block';
		document.getElementById("showProFeatures").addEventListener('click', () => { 
			document.getElementById("showProFeatures").style.display = 'none';
			
			document.getElementById("hideProFeatures").style.display = 'block';
			document.getElementById("gcaProFeaturesDiv").style.display = 'block';
		   
		}, false);  
		document.getElementById("hideProFeatures").addEventListener('click', () => { 
			document.getElementById("hideProFeatures").style.display = 'none';
			document.getElementById("showProFeatures").style.display = 'block';
			document.getElementById("gcaProFeaturesDiv").style.display = 'none';
		   
		}, false);  
	}
});


jQuery(document).ready(function($){
    


    $('body').on('click', '#gcaSaveSettings', function(e) {
    	
		let gcaEnabled = $('#gcaEnabled').val();
		let whatsapp = $('input[name="displayplatformRadio1"]:checked').val();
		let facebook = $('input[name="displayplatformRadio2"]:checked').val();
		let email = $('input[name="displayplatformRadio3"]:checked').val();
		let mobileNumber = $('#mobileNumber').val();
		let gcaEmailAddress = $('#gcaEmailAddress').val();
		let gcaEmailSubject = $('#gcaEmailSubject').val();
		let facebookPageId = $('#facebookPageId').val();
    	let titleMessage = $('#titleMessage').val();
    	let welcomeMessage = $('#welcomeMessage').val();
    	let position = $('input[name="positionRadio"]:checked').val();

    	let hover = $('input[name="hoverRadio"]:checked').val();
    	let hoverDuration = $('#hoverd').val();
    	let hoverMessage = $('#hoverMessage').val();
    	let display = $('input[name="displayRadio"]:checked').val();
    	let branding = $('input[name="displayBrandingRadio"]:checked').val();
    	let encrypted = $('input[name="encryptedRadio"]:checked').val();
    	
		let apikey = $('#gcaApiKey').val();
		let customIcon = $('#gcaCustomIcon').val();
    	

    	formData = new FormData();

    	formData.append('status', gcaEnabled);
		formData.append('mobileNumber', mobileNumber);
		formData.append('gcaEmailAddress', gcaEmailAddress);
		formData.append('gcaEmailSubject', gcaEmailSubject);
		
		formData.append('facebookPageId', facebookPageId);
		formData.append('whatsapp', whatsapp);
		
		formData.append('facebook', facebook);
		formData.append('email', email);
    	formData.append('titleMessage', titleMessage);
    	formData.append('welcomeMessage', welcomeMessage);
    	formData.append('position', position);

    	formData.append('hover', hover);
    	formData.append('hoverDuration', hoverDuration);
    	formData.append('hoverMessage', hoverMessage);
    	formData.append('display', display);
    	formData.append('branding', branding);
    	formData.append('encrypted', encrypted);

    	formData.append('apikey', apikey);

    	formData.append('customIcon', customIcon);

    	formData.append('action', 'gcapSaveSettings');
    	formData.append('security', gcap_nonce);
    	

    	
    	
    	jQuery.ajax({
            url: gcap_ajaxurl,
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response !== "1") {
                    $('#gcaStatus').html('<span style="color:#25d365; font-weight:bold;">Problem.</span>');
                } else {
                	$('#gcaStatus').html('<span style="color:#25d365; font-weight:bold;">Settings Saved.</span>');
                    
                }
            },
            error: function (response) {
                $('#gcaStatus').html('<span style="color:#25d365; font-weight:bold;">Problem.</span>');
            }
        });

    	

    });


	$('body').on('click', '#apiKeyUnlockBtn', function(e){
		removeError();
		let apikey = $('#apiKeyUnlock').val();
		

	    $.post("https://getchat.app/api/api.php", {
	    	unlock: "1",
	    	apikey: apikey
	  	},
		  function(data, status){
		    let response = JSON.parse(data);

		    if (response) {

		    	if (response.success) {
		    		
		    		unlockProFeatures();
		    	} else {
		    		/* something went wrong here */
		    		
		    		showError(response.error);
		    		lockProFeatures();
		    	}
		    } else {
		    	showError('Something went wrong.');
		    	lockProFeatures();
		    }
		  }
	  	);



	});

	function removeError() {
		$('#error').html('');

	}
	function showError(error) {
		$('#error').html(error);
	}

	function unlockProFeatures() {


		$(".profeature").removeAttr('disabled');
		$(".profeature").removeAttr('readonly');
		$('#success').html('Pro features unlocked!');
		$('#proUpgradeRow').hide();

	}
	function lockProFeatures() {
		$(".profeature").attr("disabled", true);		
		$(".profeature").attr("readonly", true);
		$('#success').html('');
		$('#proUpgradeRow').show();
	}

});


function parse_query_string(query) {
  var vars = query.split("&");
  var query_string = {};
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    var key = decodeURIComponent(pair[0]);
    var value = decodeURIComponent(pair[1]);
    // If first entry with this name
    if (typeof query_string[key] === "undefined") {
      query_string[key] = decodeURIComponent(value);
      // If second entry with this name
    } else if (typeof query_string[key] === "string") {
      var arr = [query_string[key], decodeURIComponent(value)];
      query_string[key] = arr;
      // If third or later entry with this name
    } else {
      query_string[key].push(decodeURIComponent(value));
    }
  }
  return query_string;
}

var currentlyDisplaying = false;

function gcap_updateDemo() {



	//Assign platforms
	let whatsapp = jQuery('input[name="displayplatformRadio1"]').prop('checked');
	let facebook = jQuery('input[name="displayplatformRadio2"]').prop('checked');
	let email = jQuery('input[name="displayplatformRadio3"]').prop('checked');

	//Automatically assume only 1 platform is active. 
	// We will remove this class later if you have more platforms enabled
	jQuery('.demo-container').addClass('single-platform');

	// See if basic is enabled
	if (!gcaIsPro){
		// Only allow 1 selected platform with basic enabled
		jQuery('input.platform-option').on('change', function() {
		jQuery('input.platform-option').not(this).prop('checked', false); 
		});
	}

	// Whatsapp enabled
	if (whatsapp) {
		jQuery('.gcaWhatsappOnly, .mobileNumber').show();
		jQuery('#DEMO_gcaMainButton_2, #DEMO_gcaMainCard').removeClass('gca_hidden');
		if (currentlyDisplaying === 'whatsapp') {
			jQuery('#DEMO_gcaMainCard').addClass('gcaDisplay');	
		}
		
	} else{
		jQuery('.gcaWhatsappOnly, .mobileNumber').hide();
		jQuery('#DEMO_gcaMainCard').removeClass('gcaDisplay');
		jQuery('#DEMO_gcaMainButton_2, #DEMO_gcaMainCard').addClass('gca_hidden');
	}
	// Facebook enabled
	if (facebook) {
		jQuery('.facebookPageId').show();
		jQuery('#DEMO_gcaMainButton3, #DEMO_gcaFacebookMainCard').removeClass('gca_hidden');
		if (currentlyDisplaying === 'facebook') {
			jQuery('#DEMO_gcaFacebookMainCard').addClass('gcaDisplay');
		}
		
	} else {
		jQuery('.facebookPageId').hide();
		jQuery('#DEMO_gcaFacebookMainCard').removeClass('gcaDisplay');
		jQuery('#DEMO_gcaMainButton3, #DEMO_gcaFacebookMainCard').addClass('gca_hidden');
	}
	// Email enabled
	if (email) {
		jQuery('.gcaEmailAddress, gcaEmailSubject').show();
		jQuery('#DEMO_gcaMainButton4').removeClass('gca_hidden');
		
	} else {
		jQuery('.gcaEmailAddress, gcaEmailSubject').hide();
		jQuery('#DEMO_gcaMainButton4').addClass('gca_hidden');
	}

	// See if pro is enabled and if we have selected more than 1 platform
	if(gcaIsPro == true && jQuery("input.platform-option:checked").length > 1) {

		// Displat the multiplatform icon
		jQuery('#DEMO_gcaMainButton5').removeClass('gca_hidden');
		jQuery('.demo-container').removeClass('single-platform');
		

		// Add micro class to all the platforms
		jQuery('#DEMO_gcaMainButton_2, #DEMO_gcaMainButton3, #DEMO_gcaMainButton4').addClass('DemoMicro');

		// Hide whatsapp card
		if(!jQuery('#DEMO_gcaMainCard').hasClass('platform_enabled')) {
			jQuery('#DEMO_gcaMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaMainCard').removeClass('gcaDisplay');	
		
		}
		// Hide facebook card
		if(!jQuery('#DEMO_gcaFacebookMainCard').hasClass('platform_enabled')) {
			jQuery('#DEMO_gcaFacebookMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaFacebookMainCard').removeClass('gcaDisplay');
		}

	} else {

		// Only 1 platform enabled, hide the multi platform icon
		jQuery('#DEMO_gcaMainButton5').addClass('gca_hidden');
		jQuery('.demo-container').addClass('single-platform');

		//Remove the micro class from the platforms
		jQuery('#DEMO_gcaMainButton_2, #DEMO_gcaMainButton3, #DEMO_gcaMainButton4').removeClass('DemoMicro');

	}

		
	if (document.getElementById('welcomeMessage')) {	
		let welcomeMessage = document.getElementById('welcomeMessage').value;
		document.getElementById('DEMO_gcaMainCardInnerBodyMessage').innerHTML = gcap_nl2br(welcomeMessage);
	}

	if (document.getElementById('titleMessage')) {	
		let titleMessage = document.getElementById('titleMessage').value;
		document.getElementById('DEMO_gcaMainCardInnerTopContent').innerHTML = titleMessage;
	}

	if (document.getElementById('hoverMessage') && document.getElementById('gcaMainHoverInnerInnerMessage')) {	
			let hoverMessage = document.getElementById('hoverMessage').value;
		document.getElementById('gcaMainHoverInnerInnerMessage').innerHTML = hoverMessage;
	}
	if (document.getElementById('facebookPageId')) {
		 facebookPageId = document.getElementById('facebookPageId').value;
		fbiFrameLink = 'https://web.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2F' + facebookPageId + '&tabs=messages&width=302&height=300&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId%22&_rdc=1&_rdr';
		document.getElementById('gcaFbIframe').setAttribute("src", fbiFrameLink);
	}

	if (document.getElementById('gcaCustomIcon')) {
		let gcaCustomIcon = document.getElementById('gcaCustomIcon').value;
	
		if (gcaCustomIcon !== '') { 
			document.getElementById('DEMO_gcaMainButton_2').style.backgroundImage = "url('"+gcaCustomIcon+"')";
		} else {
			document.getElementById('DEMO_gcaMainButton_2').style.backgroundImage = "url('https://getchat.app/assets/img/whatsapp.svg')";
		}
	}

	//Whatsapp click
	document.getElementById("DEMO_gcaMainButton_2").addEventListener('click', (evt) => {

		currentlyDisplaying = 'whatsapp';

		//Make sure more than 1 platform is selected
		if(gcaIsPro == true && jQuery("input.platform-option:checked").length > 1 ) {

			jQuery('#DEMO_gcaMainCard').toggleClass('gca_hidden');
			jQuery('#DEMO_gcaMainCard').toggleClass('gcaDisplay');
			jQuery('#DEMO_gcaMainCard').toggleClass('platform_enabled');
			//Hide facebook cards
			jQuery('#DEMO_gcaFacebookMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaFacebookMainCard').removeClass('gcaDisplay');
		}
		else if (!gcaIsPro) {
			jQuery('#DEMO_gcaMainCard').removeClass('gca_hidden');
			jQuery('#DEMO_gcaMainCard').addClass('gcaDisplay');
		}
		//Make sure this only runs once
		evt.stopImmediatePropagation();
	});

	//Facebook click
	document.getElementById("DEMO_gcaMainButton3").addEventListener('click', (evt) => { 
		currentlyDisplaying = 'facebook';

		//Make sure more than 1 platform is selected
		if(gcaIsPro == true && jQuery("input.platform-option:checked").length > 1){
			jQuery('#DEMO_gcaFacebookMainCard').toggleClass('gca_hidden');
			jQuery('#DEMO_gcaFacebookMainCard').toggleClass('gcaDisplay');
			jQuery('#DEMO_gcaFacebookMainCard').toggleClass('platform_enabled');

			//Hide Whatsapp cards
			jQuery('#DEMO_gcaMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaMainCard').removeClass('gcaDisplay');
		}
		else if (!gcaIsPro) {
			jQuery('#DEMO_gcaFacebookMainCard').removeClass('gca_hidden');
			jQuery('#DEMO_gcaFacebookMainCard').addClass('gcaDisplay');
		}
	//Make sure this only runs once
	evt.stopImmediatePropagation();
	});

	//Multiple platform button click
	document.getElementById("DEMO_gcaMainButton5").addEventListener('click', (evt) => {

		//Make sure more than 1 platform is selected
		if(gcaIsPro == true && jQuery("input.platform-option:checked").length > 1 ){

			// Hide all the cards
			jQuery('#DEMO_gcaFacebookMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaFacebookMainCard').removeClass('gcaDisplay');
			jQuery('#DEMO_gcaMainCard').addClass('gca_hidden');
			jQuery('#DEMO_gcaMainCard').removeClass('gcaDisplay');
			}
			//Make sure this only runs once
			evt.stopImmediatePropagation();
	});
		

}
function gcap_nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}




