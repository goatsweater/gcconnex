<?php
/**
 * WET 4 Theme plugin
 *
 * @package wet4Theme
 */

elgg_register_event_handler('init','system','wet4_theme_init');

function wet4_theme_init() {
    
    //reload groups library to have our sidebar changes
    elgg_register_library('elgg:groups', elgg_get_plugins_path() . 'wet4/lib/groups.php');
    
	elgg_register_event_handler('pagesetup', 'system', 'wet4_theme_pagesetup', 1000);
    elgg_register_event_handler('pagesetup', 'system', 'wet4_riverItem_remove');
    elgg_register_event_handler('pagesetup', 'system', 'messages_notifier');
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_elgg_entity_menu_setup');
    elgg_register_plugin_hook_handler('register', 'menu:river', 'wet4_elgg_river_menu_setup');
    
    elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_likes_entity_menu_setup', 400);
    //elgg_register_plugin_hook_handler('register', 'menu:entity', 'wet4_delete_entity_menu', 400);
    
	// theme specific CSS
	elgg_extend_view('css/elgg', 'wet4_theme/css');

	//elgg_unextend_view('page/elements/header', 'search/header');
	//elgg_extend_view('page/elements/sidebar', 'search/header', 0);
	
	elgg_register_plugin_hook_handler('head', 'page', 'wet4_theme_setup_head');
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'my_owner_block_handler');
    
    //replace files lost while removing require.js
    elgg_register_js('elgg/dev', elgg_get_site_url() . 'mod/wet4/views/default/js/elgg/dev.js', 'footer');
    elgg_register_js('elgg/reportedcontent', elgg_get_site_url() . 'mod/wet4/views/default/js/elgg/reportedcontent.js', 'footer');
    
	// non-members do not get visible links to RSS feeds
	if (!elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('output:before', 'layout', 'elgg_views_add_rss_link');
	}
    
    
}

/**
 * Rearrange menu items
 */
function wet4_theme_pagesetup() {
    
    //elgg_load_js('elgg/dev');
    //elgg_load_js('elgg/reportedcontent');
    
	if (elgg_is_logged_in()) {

		elgg_register_menu_item('topbar', array(
			'name' => 'account',
			'text' => elgg_echo('account'),
			'href' => "#",
			'priority' => 100,
			'section' => 'alt',
			'link_class' => 'elgg-topbar-dropdown',
		));

		if (elgg_is_active_plugin('dashboard')) {
			$item = elgg_unregister_menu_item('topbar', 'dashboard');
			if ($item) {
				$item->setText(elgg_echo('dashboard'));
				$item->setSection('default');
				elgg_register_menu_item('site', $item);
			}
		}
		
		$item = elgg_get_menu_item('topbar', 'usersettings');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('settings'));
			$item->setPriority(103);
		}

		$item = elgg_get_menu_item('topbar', 'logout');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('logout'));
			$item->setPriority(104);
		}

		$item = elgg_get_menu_item('topbar', 'administration');
		if ($item) {
			$item->setParentName('account');
			$item->setText(elgg_echo('admin'));
			$item->setPriority(101);
		}

		if (elgg_is_active_plugin('site_notifications')) {
			$item = elgg_get_menu_item('topbar', 'site_notifications');
			if ($item) {
				$item->setParentName('account');
				$item->setText(elgg_echo('site_notifications:topbar'));
				$item->setPriority(102);
			}
		}

		if (elgg_is_active_plugin('reportedcontent')) {
			$item = elgg_unregister_menu_item('footer', 'report_this');
			if ($item) {
				$item->setText(elgg_view_icon('report-this'));
				$item->setPriority(500);
				$item->setSection('default');
				elgg_register_menu_item('extras', $item);
			}
		}
        /*
        if ($item->canEdit()) {
            $control = elgg_view("output/url",array(
            'href' => elgg_get_site_url() . "action/plugin_name/delete?guid=" . $entity->guid,
            'text' => 'Delete ME!',
            'is_action' => true,
            'is_trusted' => true,
            'confirm' => elgg_echo('deleteconfirm'),
            'class' => 'testing',
                   ));   
                }*/
        
        
	}
    
    
/*
*    Control colleague requests in topbar menu
*    taken from friend_request module
*    edited to place badge on colleagues instead of creating new icon
*/
    $user = elgg_get_logged_in_user_entity();
    
    $params = array(
				"name" => "Colleagues",
				"href" => "friends/" . $user->username,
				"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">' . elgg_echo("friends") . '</span>',
				"title" => elgg_echo('friends'),
                "class" => '',
                'item_class' => '',
				'priority' => '1'
			);
			
			elgg_register_menu_item("user_menu", $params);
    
    
    $context = elgg_get_context();
	$page_owner = elgg_get_page_owner_entity();
	
	// Remove link to friendsof
	elgg_unregister_menu_item("page", "friends:of");
	
	
	if (!empty($user)) {
		$options = array(
			"type" => "user",
			"count" => true,
			"relationship" => "friendrequest",
			"relationship_guid" => $user->getGUID(),
			"inverse_relationship" => true
		);
		
		$count = elgg_get_entities_from_relationship($options);
		if (!empty($count)) {
            
            //user menu
            
            $countTitle = $count;
            
            //display 9+ instead of huge numbers in notif badge
            if($count >= 10){
                $count = '9+';
            }
            
			$params = array(
				"name" => "Colleagues",
				"href" => "friends/" . $user->username,
				"text" => '<i class="fa fa-users mrgn-rght-sm mrgn-tp-sm fa-lg"></i><span class="hidden-xs">'. elgg_echo("friends") . "</span><span class='notif-badge'>" . $count . "</span>",
				"title" => elgg_echo('userMenu:colleagues') . ' - ' . $countTitle . ' ' . elgg_echo('friend_request') .'(s)',
                "class" => '',
                'item_class' => '',
				'priority' => '1'
			);
			
			elgg_register_menu_item("user_menu", $params);
            
            
            
            //topbar
            
            $params = array(
				"name" => "friends",
				"href" => "friends/" . $user->username,
				"text" => elgg_echo("friends") . "<span class='badge'>" . $count . "</span>",
				"title" => elgg_echo('friends') . ' - Requests(' . $count .')',
                "class" => 'friend-icon',

		
			);
			
			elgg_register_menu_item("topbar", $params);
            
		}
	}
    
    
    
    //likes and stuff yo
    $item = elgg_get_menu_item('entity', 'likes');
		if ($item) {
			$item->setText('likes');
            $item->setItemClass('msg-icon');
           
		}
    
    $item = elgg_get_menu_item('entity', 'delete');
		if ($item){
          echo '<div> What that mean?</div>';          
        }
    
    	if (elgg_is_logged_in() && elgg_get_config('allow_registration')) {
		$params = array(
			'name' => 'invite',
			'text' => elgg_echo('friends:invite'),
			'href' => "invite",
			'contexts' => array('friends'),
            'priority' => 300,
		);
		elgg_register_menu_item('page', $params);
	}
	
	
    
    
}



/**
 * Register items for the html head
 *
 * @param string $hook Hook name ('head')
 * @param string $type Hook type ('page')
 * @param array  $data Array of items for head
 * @return array
 */
function wet4_theme_setup_head($hook, $type, $data) {
	$data['metas']['viewport'] = array(
		'name' => 'viewport',
		'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0',
	);

	$data['links']['apple-touch-icon'] = array(
		'rel' => 'apple-touch-icon',
		'href' => elgg_normalize_url('mod/wet4_theme/graphics/homescreen.png'),
	);

	return $data;
}






function wet4_likes_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	/* @var ElggEntity $entity */

	if ($entity->canAnnotate(0, 'likes')) {
		$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($entity->guid);
		
		// Always register both. That makes it super easy to toggle with javascript
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes',
			'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">Like This</span>',
			'title' => elgg_echo('likes:likethis'),
			'item_class' => $hasLiked ? 'hidden' : '',
			'priority' => 1000,
		));
		$return[] = ElggMenuItem::factory(array(
			'name' => 'unlike',
			'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$entity->guid}"),
			'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">Like This</span>',
			'title' => elgg_echo('likes:remove'),
			'item_class' => $hasLiked ? '' : 'hidden',
			'priority' => 1000,
		));
	}
    
    	
		
		
	
    // Always register both. That makes it super easy to toggle with javascript
    /*
    if($entity->canEditMetadata(1, 'delete')){
      $return[] = array(
			'name' => 'delete',
			'href' =>  elgg_get_site_url() . "action/plugin_name/delete?guid=" . $entity->guid,
			'text' => 'delete yo',
			'title' => elgg_echo('likes:likethis'),
			
			'priority' => 100,
		);  
    }
*/

	
	
	// likes count
	$count = elgg_view('likes/count', array('entity' => $entity));
	if ($count) {
		$options = array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 1001,
		);
		$return[] = ElggMenuItem::factory($options);
	}


    
	return $return;
}


function wet4_elgg_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}
	
	$entity = $params['entity'];
	/* @var \ElggEntity $entity */
	$handler = elgg_extract('handler', $params, false);

    if($entity->canAnnotate()){
        $options = array(
			'name' => 'thewire_tools_reshare',
			'text' => '<i class="fa fa-share-alt fa-lg icon-unsel"><span class="wb-inv">Share this on the Wire</span></i>',
			'title' => elgg_echo('thewire_tools:reshare'),
			'href' => 'ajax/view/thewire_tools/reshare?reshare_guid=' . $reshare_guid,
			'link_class' => 'elgg-lightbox',
			'is_trusted' => true,
			'priority' => 500
		);
		$return[] = \ElggMenuItem::factory($options);   
    }
	
	if ($entity->canEdit() && $handler) {
		// edit link
        /*
		$options = array(
			'name' => 'edit',
			'text' => '<i class="fa fa-edit fa-lg"></i>',
			'title' => elgg_echo('edit:this'),
			'href' => "$handler/edit/{$entity->getGUID()}",
			'priority' => 200,
		);
		$return[] = \ElggMenuItem::factory($options);
        */
		// delete link
		$options = array(
			'name' => 'delete',
			'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">Delete This</span></i>',
			'title' => elgg_echo('delete:this'),
			'href' => "action/$handler/delete?guid={$entity->getGUID()}",
			'confirm' => elgg_echo('deleteconfirm'),
			'priority' => 300,
		);
		$return[] = \ElggMenuItem::factory($options);
        

	}

	return $return;
}

function wet4_riverItem_remove(){
    elgg_unregister_menu_item('river', 'comment'); 
    elgg_unregister_menu_item('river', 'reply'); 
}

function wet4_elgg_river_menu_setup($hook, $type, $return, $params){
    
    
	if (elgg_is_logged_in()) {
		$item = $params['item'];
		/* @var \ElggRiverItem $item */
		$object = $item->getObjectEntity();
		// add comment link but annotations cannot be commented on
		if ($item->annotation_id == 0) {
			if ($object->canComment()) {
                /*
				$options = array(
					'name' => 'comment',
					'href' => "#comments-add-$object->guid",
					'text' => '<i class="fa fa-comment-o fa-lg icon-unsel"><span class="wb-inv">Comment on this</span></i>',
					'title' => elgg_echo('comment:this'),
					//'rel' => 'toggle',
                   'data-toggle' => 'collapse',
                    'aria-expanded' => 'false',
					'priority' => 50,
				);
				$return[] = \ElggMenuItem::factory($options);
                */
                
            }else{
                /*
                      $options = array(
					'name' => 'reply',
					'href' => "#comments-add-$object->guid",
					'text' => '<i class="fa fa-comment-o fa-lg icon-unsel"><span class="wb-inv">Comment on this</span></i>',
					'title' => 'Reply to this',
					//'rel' => 'toggle',
                         'data-toggle' => 'collapse',
                  'aria-expanded' => 'false',
					'priority' => 50,
				);
				$return[] = \ElggMenuItem::factory($options);  */
            }
            

    
		}
        

        
        	$object = $item->getObjectEntity();
	if (!$object || !$object->canAnnotate(0, 'likes')) {
		return;
	}

	$hasLiked = \Elgg\Likes\DataService::instance()->currentUserLikesEntity($object->guid);

	// Always register both. That makes it super easy to toggle with javascript
	$return[] = ElggMenuItem::factory(array(
		'name' => 'likes',
		'href' => elgg_add_action_tokens_to_url("/action/likes/add?guid={$object->guid}"),
		'text' => '<i class="fa fa-thumbs-up fa-lg icon-unsel"></i><span class="wb-inv">Like This</span>',
		'title' => elgg_echo('likes:likethis'),
		'item_class' => $hasLiked ? 'hidden' : '',
		'priority' => 100,
	));
	$return[] = ElggMenuItem::factory(array(
		'name' => 'unlike',
		'href' => elgg_add_action_tokens_to_url("/action/likes/delete?guid={$object->guid}"),
		'text' => '<i class="fa fa-thumbs-up fa-lg icon-sel"></i><span class="wb-inv">Like This</span>',
		'title' => elgg_echo('likes:remove'),
		'item_class' => $hasLiked ? '' : 'hidden',
		'priority' => 100,
	));

	// likes count
	$count = elgg_view('likes/count', array('entity' => $object));
	if ($count) {
		$return[] = ElggMenuItem::factory(array(
			'name' => 'likes_count',
			'text' => $count,
			'href' => false,
			'priority' => 101,
		));
	}
        
		
		if (elgg_is_admin_logged_in()) {
			$options = array(
				'name' => 'delete',
				'href' => elgg_add_action_tokens_to_url("action/river/delete?id=$item->id"),
				'text' => '<i class="fa fa-trash-o fa-lg icon-unsel"><span class="wb-inv">Delete This</span></i>',
				'title' => elgg_echo('river:delete'),
				'confirm' => elgg_echo('deleteconfirm'),
				'priority' => 200,
			);
			$return[] = \ElggMenuItem::factory($options);
		}
        

	}

	return $return;
}


//arrange owner block menu
function my_owner_block_handler($hook, $type, $menu, $params){
    
    /*
     *
     * If new tool has been added to group tools
     * Make sure the priority is less then 100
     *
     */
    
    
    //rearrange menu items
    if(elgg_get_context() == 'group_profile'){
        
        elgg_unregister_menu_item('owner_block', 'Activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:discussion')));
                    $item->setPriority('1');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:files')));
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:blogs')));
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:calendar')));
                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:pages')));
                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:bookmarks')));
                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:polls')));
                    $item->setPriority('8');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:tasks')));
                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:photoCatch')));
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:albums')));
                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->setHref('#' . strtolower(elgg_echo('gprofile:ideas')));
                    $item->setPriority('12');
                    break;
                case 'activity':
                    elgg_unregister_menu_item('owner_block', 'activity');
                    $item->setText('Activity');
                    $item->setHref('#activity');
                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                
            }
            
        }
        
        
    }
    
    
    //rearrange menu items
    if(elgg_get_context() == 'groupSubPage'){
        
        elgg_unregister_menu_item('owner_block', 'activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));

                    $item->setPriority('1');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));

                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));

                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));

                    $item->setPriority('5');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));

                    $item->setPriority('6');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));

                    $item->setPriority('7');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));

                    $item->setPriority('8');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));

                    $item->setPriority('9');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('10');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));

                    $item->setPriority('11');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));

                    $item->setPriority('12');
                    break;
                case 'activity':
                    $item->setText('Activity');

                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                
            }
            
        }
    }
        
        //rearrange menu items
    if(elgg_get_context() == 'profile'){
        
        elgg_unregister_menu_item('owner_block', 'activity');
        
        //turn owner_block  menu into tabs
        foreach ($menu as $key => $item){
             
            switch ($item->getName()) {
                case 'discussion':
                    $item->setText(elgg_echo('gprofile:discussion'));
                    
                    $item->setPriority('1');
                    break;
                case 'file':
                    $item->setText(elgg_echo('gprofile:files'));
                    $item->setHref('#file');
                    $item->setPriority('2');
                    break;
                case 'blog':
                    $item->setText(elgg_echo('gprofile:blogs'));
                    $item->setHref('#blog');
                    $item->setPriority('3');
                    break;
                case 'event_calendar':
                    $item->setText(elgg_echo('gprofile:events'));
                    $item->setHref('#events');
                    $item->setPriority('6');
                    break;
                case 'pages':
                    $item->setText(elgg_echo('gprofile:pages'));
                    $item->setHref('#page_top');
                    $item->setPriority('7');
                    break;
                case 'bookmarks':
                    $item->setText(elgg_echo('gprofile:bookmarks'));
                    $item->setHref('#bookmarks');
                    $item->setPriority('8');
                    break;
                case 'polls':
                    $item->setText(elgg_echo('gprofile:polls'));
                    $item->setHref('#poll');
                    $item->setPriority('9');
                    break;
                case 'tasks':
                    $item->setText(elgg_echo('gprofile:tasks'));
                    $item->setHref('#task_top');
                    $item->setPriority('10');
                    break;
                case 'photos':
                    $item->setText(elgg_echo('gprofile:photos'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('11');
                    break;
                case 'photo_albums':
                    $item->setText(elgg_echo('gprofile:albumsCatch'));
                    $item->setHref('#album');
                    $item->setPriority('12');
                    break;
                case 'ideas':
                    $item->setText(elgg_echo('gprofile:ideas'));
                    $item->addItemClass('removeMe');
                    $item->setPriority('12');
                    break;
                case 'thewire':
                    //$item->setText(elgg_echo('The Wire'));
                    $item->setHref('#thewire');
                    $item->setPriority('5');
                    break;
                case 'activity':
                    $item->setText('Activity');

                    $item->setPriority('13');
                    $item->addItemClass('removeMe');
                    break;
                
            }
            
        }
    
        
        
    }
    
}



