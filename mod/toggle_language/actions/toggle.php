<?php

    /**
	 * Toggle language action
	 */
	
	// Register actions
	//register_action("togglelang");
	
    // Toggle language 
	//global $SESSION;
	
	if (_elgg_services()->session->get('language') == 'en') {
		$_SESSION['language'] = "fr";
	} else {
		$_SESSION['language'] = "en";
	}
	
	forward($_SERVER['HTTP_REFERER']);

?>