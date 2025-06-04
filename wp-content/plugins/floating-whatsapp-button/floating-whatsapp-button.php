<?php
/*
Plugin Name: Floating WhatsApp Button
Description: Adds a floating WhatsApp button to a specific page.
Version: 1.0
Author: Al Amin Robin
*/

add_action('wp_footer', function() {
    if (is_page('contact')) {
        $plugin_url = plugin_dir_url(__FILE__);
        ?>
        <style>
            .floating-whatsapp-button {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                cursor: pointer;
            }
            .floating-whatsapp-button img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
            }
        </style>
        <a href="https://wa.me/16473825749?text=I%20want%20to%20reserve%20a%20car" target="_blank" class="floating-whatsapp-button">
            <img src="<?php echo $plugin_url; ?>assets/floatingChat.png" alt="Chat with us on WhatsApp" />
        </a>
        <?php
    }
});
?>
