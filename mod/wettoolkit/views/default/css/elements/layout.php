<?php
/**
 * Page Layout
 ************Changed for EasyTheme (line 25)****************
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 */

?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
/*.elgg-page-default {
	-moz-box-shadow: 0px 0px 10px 4px white !important;
	-webkit-box-shadow: 0px 0px 10px 4px white !important;
	box-shadow: 0px 0px 10px 4px white !important;
	width: 100%;

}*/



/*-----------Page Width ------------*/

.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	padding: 5px 0;
	border-top: 0px solid #DEDEDE;
	
}

/*----------- Elgg Default Search Bar --------------*/

.elgg-search input[type="text"] {
	position: absolute !important;
    top:-520px !important;
    right:0px !important;
    width: 300px !important;
    z-index: 99999 !important;
}

/*-- Stretch menu bar 100% of body and align on page --*/
ul.elgg-menu.elgg-menu-site.elgg-menu-site-default.clearfix {
	width: 100%;
	position: absolute;
	top: 0px;
}

/*---------- Hides default Elgg text in h1 --------- */
h1 {
	text-indent: -999em;
}

h3 {
	width: 100% !important;
}

/*---------- Removes unnecessary border between logged in navigation and main navigation -----------*/
div {
border: none !important;
}

.elgg-module-livesearch {
width: 300px !important;

}
.elgg-module-livesearch > .elgg-head h3 {
background-color: black;
}
.elgg-module-livesearch > .elgg-head {
background: black;
}

/*------------Elgg Login Button Dropdown--------------*/
.elgg-button-dropdown {
padding: 3px 6px;
text-decoration: none;
display: block;
font-weight: bold;
position: relative;
margin-left: 0;
color: white;
border: 1px solid #71B9F7;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
-webkit-box-shadow: 0 0 0;
-moz-box-shadow: 0 0 0;
box-shadow: 0 0 0;
top: 25px;
right: 20px;
}

/*-------- Removes 1px of white bg not required --------*/
.elgg-page-body {
background: none !important;
}

/*------ Index Widgets ----------*/

body {
	background-color: #003366 !important;
}


.elgg-widget-content {
    -moz-box-shadow:    3px 3px 2px 6px white;
  -webkit-box-shadow: 3px 3px 2px 6px white;
  box-shadow:         3px 3px 2px 6px white;

}
/***** TOPBAR ******/
.elgg-page-topbar {
	background: #000099;
	border-bottom: 1px solid #000000;
	position: relative;
	height: 24px;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 24px;
	right: 20px;
	max-width: 500px;
z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}


/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>mod/easytheme/graphics/sidebar_background.gif) repeat-y right top;
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	width: 210px;
	margin: 0 0 0 10px;
	
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
	
}
.elgg-main {
	position: relative;
	min-height: 360px;
	padding: 10px;
}
.elgg-page-body {
	background: #FFF;
}
.elgg-layout-one-sidebar {
	background: #EEECE9;



}
/*------------------------------CHANGE CSS IN THIS FILE ONLY-----------------------------------------------------*/
/*------- Change the color of all anchors in the body ------*/
.elgg-body a {
	color: #1D63A3;
}
ul.elgg-list.elgg-list-entity > li:hover {
	background: white;
}
ul.elgg-list.elgg-list-river.elgg-river > li:hover {
	background: white;
}
ul.elgg-gallery.tidypics-gallery > li:hover {
	background: white;
}

/*----------------------------------------DROPDOWN STYLES-----------------------------*/
ul.elgg-menu.elgg-child-menu {
	background: #EEECE9;
	
}
ul.elgg-menu.elgg-child-menu > li a {
	color: #555555;
}
a.elgg-menu-closed.elgg-menu-parent {
	padding-right: 20px;
	background: url(<?php echo elgg_get_site_url(); ?>mod/wettoolkit/graphics/elgg_sprites.png) no-repeat scroll right center transparent;
	background-position-y: 3px;


}
.elgg-menu-site-default > .elgg-state-selected > a.elgg-menu-closed.elgg-menu-parent, .elgg-menu-site-default > li:hover > a.elgg-menu-closed.elgg-menu-parent {
	background:url(<?php echo elgg_get_site_url(); ?>mod/wettoolkit/graphics/elgg_sprites.png) no-repeat scroll right center transparent;
	background: #EEECE9;
}


.elgg-page-topbar {
	background-image:url(<?php echo elgg_get_site_url(); ?>mod/wettoolkit/graphics/gradient.png);
	z-index: 1;
}

.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}
.elgg-menu-site-default {
	background:url(<?php echo elgg_get_site_url(); ?>mod/wettoolkit/graphics/gradient.png) !important;
}

.elgg-menu-site-default > .elgg-state-selected > a, .elgg-menu-site-default > li:hover > a {
	background: #EEECE9;
	
	border-bottom: 4px solid #EEECE9;
	
}
.elgg-menu-site-default > .elgg-state-selected, .elgg-menu-site-default > li {
		top: -4px;
		padding-bottom: 3px
}

.elgg-module-widget > .elgg-head {
	background-color: #000099;
}

.elgg-page-default .elgg-state-header . elgg-inner {
	width: 100%;
	height: 120px;
}
.elgg-module-widget a.widget-manager-widget-title-link {
	color: white;
}
.elgg-page-header {
	position: relative;
}






/*----------*/

h1 {
height: 0px !important;
}

#wb-main-in a:visited, #wb-main-in a.ui-link:visited {
color: black;
}

.elgg-menu-site-default {
height: 30px !important;
}


.elgg-menu-site-default > li > a {
color: white !important;
padding-top: 10px !important;

}



.elgg-menu-site-default > .elgg-state-selected > a, .elgg-menu-site-default > li:hover > a {
background: #145788 !important;
border-bottom: 4px solid #000000 !important;
padding-top: 10px !important;
}



ul.elgg-menu.elgg-menu-entity.elgg-menu-hz.elgg-menu-entity-default a {
	color: #1D63A3;

}
span.elgg-icon.elgg-icon-delete {
	background-position: 0px -252px !important;
}
a.elgg-button.elgg-button-submit {
	color: white;

}
a.elgg-button.elgg-button-delete {
	color: white;
}


/*******************------------ Bookmark Icon - Topbar ---------------**********/
.elgg-menu-item-bmark a {
	width: 16px;
	height: 24px;
	background: url(<?php echo elgg_get_site_url(); ?>/mod/wettoolkit/graphics/bmark.gif) no-repeat;
	background-position: 0px 5.5px;

}

.elgg-menu-item-bmark a:hover {
	width: 16px;
	height: 24px;
	background: url(<?php echo elgg_get_site_url(); ?>mod/wettoolkit/graphics/bmark_hover1.png) no-repeat;
	background-position: 0px 5.5px;

}
/*--------------------------Groups UI-------------------------*/

/***** PAGE FOOTER ******/
.elgg-page-footer {
	position: relative;
}
.elgg-page-footer {
	color: #999;
}
.elgg-page-footer a:hover {
	color: #666;
}



/* these are for narrowing the WET body content to match elgg  -------------------------------------- */

/* ---- these are unused (old attempt that didnt pan out with ie7)
#wb-body #wb-main{
	width:990px !important;
}
#gcwu-psnb .mb-menu, #wb-core-in, #gcwu-gcnb-in, #gcwu-bnr-in, #gcwu-psnb-in, #gcwu-bc-in, #gcwu-gcft-in, #gcwu-sft-in{
	width:990px !important;
}
#wb-main-in{
	padding-bottom:10px !important;
}
*/

.elgg-page-body{
	margin-top:12px;
	padding:10px;
}

.elgg-page-default .elgg-page-body > .elgg-inner, .elgg-page-default {
	width: auto !important;
	*width: 99% !important;
}
.elgg-page-default{
	-webkit-box-shadow: none !important;
	-box-shadow: none !important;
	min-width:0 !important;
	display:table !important;
}
/*
.elgg-body{
	width:990px !important;
}
*/

/* this is for the left profile nav on the profile page --------------------------------------------- */

.elgg-menu-owner-block li a:hover{
	color: #FFF !important;
}

/* this is for a similar navigation on the webinar page --------------------------------------------- */

.elgg-menu-page li a:hover, .elgg-menu-page li.elgg-state-selected a{
	color: #FFF !important;
}


/* this sets widget titles to white (WET styles were overridin) */

.elgg-module-widget a.widget-manager-widget-title-link{
	color:#FFF !important;
}


