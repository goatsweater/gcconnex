<?php

	/**
	 * Elgg file browser
	 * 
	 * @package ElggFile
	 * @author Canadian Defence Academy - Canadian Advanced Distributed Learning Lab
	 * @copyright Government of Canada 2013
	 * @link http://www.forces.gc.ca/en/training-prof-dev/canadian-defence-academy.page
	 */
	
	
	// Initialization of the plugin.
	// We clear out all previously included CSS views that other plugins have put in (using elgg_extend_view)
	function wet_theme_init() {
		//Remove topbar elgg logo
		elgg_unregister_menu_item('topbar', 'elgg_logo');
		elgg_extend_view('css/elgg', 'search/css');
	}
	
	// Register our initialization function. We put a huge priority number to ensure that it runs last and can clear out all existing CSS
	elgg_register_event_handler('init','system','wet_theme_init', 9999999999999);
	
	
	if(isset($_GET['lang']) && in_array($_GET['lang'], array("en", "fr"))){		
		$_SESSION['lang']=$_GET['lang'];		
		header("Location: ".$_SERVER['HTTP_REFERER']);
		die();
	}
	if(isset($_SESSION['lang'])){
		$user=elgg_get_logged_in_user_entity();
		if($user){
			$user->language=$_SESSION['lang'];
			$user->save();
		} else {		
			elgg_set_config("language",$_SESSION['lang']);
		}
	}
		
	
?>