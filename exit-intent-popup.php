<?php
/*
Plugin Name: Exit-Intent Popup
Plugin URI: https://www.evolurise.com/
Description: Allows admin to set an image with a link to display as an exit-intent popup.
Version: 1.0.0
Author: Walid Sadfi - Evolurise
Author URI: https://www.evolurise.com/
*/

// Add exit intent popup code to footer
function exit_intent_popup() {
    ?>
    <script>
        var exitIntentPopupShown = false;
        var exitIntentPopup;
        function exitIntentPopupClose() {
            exitIntentPopup.style.display = 'none';
            exitIntentOverlay.remove(); // remove the overlay
            function exitIntentPopupClose() {
            jQuery(exitIntentPopup).fadeOut(300, function() {
            exitIntentPopupOverlay.style.display = 'none';
             });
            }


        }
        document.addEventListener('mouseout', function(event) {
            if (event.clientY < 0 && !exitIntentPopupShown) {
                exitIntentPopup = document.createElement('div');
                exitIntentPopup.style.position = 'fixed';
                exitIntentPopup.style.left = '50%';
                exitIntentPopup.style.top = '50%';
                exitIntentPopup.style.transform = 'translate(-50%, -50%)';
                exitIntentPopup.style.padding = '0px';
                exitIntentPopup.style.background = '#fff';
                exitIntentPopup.style.border = 'none';
                exitIntentPopup.style.zIndex = '999999';
                var exitIntentPopupImage = document.createElement('img');
                exitIntentPopupImage.setAttribute('src', '<?php echo get_option('exit_intent_popup_image'); ?>');
                exitIntentPopupImage.style.maxWidth = '100%';
                var exitIntentPopupLink = document.createElement('a');
                exitIntentPopupLink.setAttribute('href', '<?php echo get_option('exit_intent_popup_link'); ?>');
                exitIntentPopupLink.setAttribute('target', '_blank');
                exitIntentPopupLink.appendChild(exitIntentPopupImage);
                var exitIntentPopupCloseButton = document.createElement('button');
                exitIntentPopupCloseButton.classList.add('close_button');
                exitIntentPopupCloseButton.innerHTML = 'X';
                exitIntentPopupCloseButton.style.position = 'absolute';
                exitIntentPopupCloseButton.style.top = '10px';
                exitIntentPopupCloseButton.style.right = '10px';
                exitIntentPopupCloseButton.addEventListener('click', exitIntentPopupClose);
                exitIntentPopup.appendChild(exitIntentPopupLink);
                exitIntentPopup.appendChild(exitIntentPopupCloseButton);
                document.body.appendChild(exitIntentPopup);
                exitIntentPopupShown = true;
                exitIntentOverlay = document.createElement('div');
        exitIntentOverlay.style.position = 'fixed';
        exitIntentOverlay.style.top = 0;
        exitIntentOverlay.style.left = 0;
        exitIntentOverlay.style.width = '100%';
        exitIntentOverlay.style.height = '100%';
        exitIntentOverlay.style.background = 'rgba(0, 0, 0, 0.5)';
        exitIntentOverlay.style.zIndex = '999998';
        document.body.appendChild(exitIntentOverlay);


            }
        });
    </script>
    <style>
        button.close_button {
    border: none;
    background: transparent;
    color: white;
    font-weight: bold;
}
</style>
    <?php
}

add_action('wp_footer', 'exit_intent_popup');

// Add settings page for the plugin
function exit_intent_popup_settings() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('exit_intent_popup'); ?>
            <?php do_settings_sections('exit_intent_popup'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('Popup Image', 'exit-intent-popup'); ?></th>
                    <td><input type="text" name="exit_intent_popup_image" value="<?php echo esc_attr(get_option('exit_intent_popup_image')); ?>" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Popup Link', 'exit-intent-popup'); ?></th>
                    <td><input type="text" name="exit_intent_popup_link" value="<?php echo esc_attr(get_option('exit_intent_popup_link')); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add settings page to admin menu
function exit_intent_popup_menu() {
    add_options_page(
        __('Exit Intent Popup Settings', 'exit-intent-popup'),
        __('Exit Intent Popup', 'exit-intent-popup'),
        'manage_options',
        'exit_intent_popup',
        'exit_intent_popup_settings'
    );
}
add_action('admin_menu', 'exit_intent_popup_menu');

// Register settings for the plugin
function exit_intent_popup_register_settings() {
    register_setting(
    'exit_intent_popup',
    'exit_intent_popup_image',
    'sanitize_text_field'
    );
    register_setting(
    'exit_intent_popup',
    'exit_intent_popup_link',
    'esc_url_raw'
    );
    }
    add_action('admin_init', 'exit_intent_popup_register_settings');
