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
<h2><i>TwitterLock Settings</i></h2>
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
<br/>
<br/>
<br/>

<style type="text/css" media="screen">.o-form{background-color:#EBF1F7;border:1px solid #0077cc;}
.o-form form{margin:0px;padding:0px;}
.o-form .o-form-header{background-color:#0077cc;padding:9px;}
.o-form h2{color:#fff;font-family:Arial,sans-serif;font-size:18px;line-height:27px;margin:0px;padding:0px;}
.o-form p{color:#fff;font-family:Arial,sans-serif;font-size:12px;line-height:18px;margin:0px;padding:0px;}
.o-form .o-form-row{margin-top:9px;padding:0 9px;}
.o-form .o-form-row label{color:#0077cc;font-family:Arial,sans-serif;font-size:12px;display:block;font-weight:bold;}
.o-form input[type="text"]{border:1px solid #0077cc;color:#0077cc;padding:5px 7px;}
.o-form input[type="submit"]{margin:20px 9px 18px 9px;}</style>


<div class="o-form" align="center"><div class="o-form-header"><h2 id="o-form-title">IF you like this plugin, you can buy me a Coffee.  :)</h2></div>
<div class="o-form-row">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="http://kgfog.com/wp-content/uploads/2011/11/buy-me-a-coffee-widget-image.jpg" border="0" name="submit" alt="PayPal Ñ The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

</div>
<div class="o-form-header"><h2 id="o-form-title">Benefits of Buying me a Coffee</h2></div>
<div class="o-form-row">
<ul>
	<li>Programmers convert Caffeine into code. More Coffee, More features :D</li>
	<li>Stay updated about all new features up front</li>
	<li>Inclusion of YOUR suggestions on priority for next releases of the plugin</li>
	<li>Lifetime E-mail support for this plugin</li>

</ul>


</div>
</div>