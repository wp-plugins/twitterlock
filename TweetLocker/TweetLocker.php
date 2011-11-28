<?php 
/*
Plugin Name: TwitterLock - Social Lock for your content
Plugin URI: http://kgfog.com
Description: TweetLocker enables you to hide a part of your post or page 's content. The part will only be revealed when a person Follows or Tweets.  
Version: 1.0.0
Author: Mohit Jawanjal
Author URI: http://www.kgfog.com
*/

add_action('admin_menu','add_locker_menu');
register_activation_hook(__FILE__, 'locker_install');
function locker_install(){
    $createTbl = "create table locker_settings(
        unlock_type varchar(200),
        tweet varchar(300),
        follow_userid varchar(300),
        locked_content_text varchar(3000)
    );";
    
    require_once(ABSPATH . "wp-admin/includes/upgrade.php");
    global $wpdb;
    $wpdb->query($createTbl);
}

function add_locker_menu(){
    add_menu_page(__('TweetLocker','TweetLocker'),
                  __('TweetLocker','TweetLocker'),
                  'administrator',
                  basename(__FILE__),
                  'locker_admin');
    add_submenu_page(basename(__FILE__),
                     __('Settings'),
                     __('Settings','Settings'),
                     'administrator',
                     basename(__FILE__),
                     'locker_admin'
                    );  
}


function locker_admin(){
    include('settings.php');
}


function add_locker_shortcode($attrs, $content=null){
    global $wpdb;
    $settings = $wpdb->get_row("select * from locker_settings",ARRAY_A);
    $displaycontent = '<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>';
    $displaycontent .= "<div id='hider' style='border-style: dashed; display: block;border-width: 3px;n border-color: #29628D;padding: 10px;'>";
    $displaycontent .= $settings['locked_content_text'];
    if($settings['unlock_type']=='tweet'){
         $displaycontent .= '<div align="center"><a href="https://twitter.com/share" class="twitter-share-button" data-text="'. $settings['tweet'] . '">Tweet</a></div>';
    }else if ($settings['unlock_type']=='follow'){
        $displaycontent .= '<div align="center"><a href="https://twitter.com/'. $settings['follow_userid'] . '" class="twitter-follow-button">Follow '. $settings['follow_userid'] .'@twitterapi</a></div>';
    }
    $displaycontent .= '</div>';
    $displaycontent .= "<script src='". WP_PLUGIN_URL . "/TweetLocker/js/locker.js" . "'></script>";
    
    $displaycontent .="<div id = 'hiddencontent' style='display: none;'>" . $content;

    $displaycontent .= "</div>";
    $displaycontent .= "<br/><br/>";
    return $displaycontent;
}

add_shortcode('tweetlock','add_locker_shortcode');
?>