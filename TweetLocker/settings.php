<?php

if(isset($_POST['save-locker-settings'])){
    
    $unlock_type = $_POST['unlock_type'];
    $tweet_message = $_POST['tweet_message'];
    $follow_userid = $_POST['follow_userid'];
    $liketext = stripslashes($_POST['liketext']);
    
    global $wpdb;
    $wpdb->query('delete from locker_settings');
    $wpdb->insert('locker_settings',
                  array(
                        'unlock_type'=>$unlock_type,
                        'tweet'=>$tweet_message,
                        'follow_userid'=>$follow_userid,
                        'locked_content_text'=>$liketext
                        )
                  );
    
    $message = "<div class='updated'><h4>Settings saved successfully</h4></div>";
    
}

?>
<?php
add_action("admin_print_scripts", "js_libs");
function js_libs() {
    wp_enqueue_script('tiny_mce');
}

wp_tiny_mce( false , // true makes the editor "teeny"
    array(
        "editor_selector" => "liketext",
        "height" => 150,
        "width" => 300
    )
);
?>
<script>
tinyMCE.init({
    mode : "exact",
    elements: "liketext",
    theme : "simple"
});

</script>

<?php
    global $wpdb;
    $settings = $wpdb->get_row("select * from locker_settings",ARRAY_A);
?>
<h2><i>Like Locker Settings</i></h2>
<hr/>
<br/>
<?php echo $message; ?>
<br/>
<form name="locker-settings" action="<?php echo $_SERVER['PATH_INFO'] ?>" method="post" >
<h4>Unlock Type</h4>
<p><input type="radio" name="unlock_type" value="tweet" <?php if($settings['unlock_type']=='tweet'){echo "checked"; } ?>/>Tweet to Unlock</p>
<p><input type="radio" name="unlock_type" value="follow" <?php if($settings['unlock_type']=='follow'){echo "checked"; } ?> />Follow to Unlock</p>
<h4>Tweet Message</h4>
<textarea name="tweet_message" id="description"><?php echo $settings['tweet']; ?></textarea>

<h4>Twitter User ID to follow (example: bobitsme)</h4>
<input type="text" width="300" id="link" name="follow_userid" value="<?php echo $settings['follow_userid']; ?>" />

<h4> Locked Content Text</h4>
<textarea id="liketext" name="liketext" class="liketext" ><?php echo $settings['locked_content_text']; ?></textarea>
<br/>
<br/>
<input class ="button-primary" type="submit" name="save-locker-settings" value="Save Settings" />

</form>