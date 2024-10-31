<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/*
Plugin Name: AtlasPath
Description: A AtlasPath plugin for WordPress.
Version: 1.0.4
Tested up to: 6.4
Author: AtlasPath Artificial Intelligence Platform by www.AtlasPath.com
*/

// Enqueue CSS file for styling
function remodel_ai_chatbot_enqueue_styles() {
    wp_enqueue_style('remodel-ai-chatbot-ui-style', plugins_url('css/chatbot-ui.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'remodel_ai_chatbot_enqueue_styles');

// Enqueue JavaScript file for functionality
function remodel_ai_chatbot_enqueue_scripts() {
    // Retrieve custom parameters from the plugin settings
    $param1 = get_option('remodel_ai_chatbot_param1');

    wp_enqueue_script('remodel-ai-chatbot-ui-script', plugins_url('js/chatbot-ui.js', __FILE__), array('jquery'), '1.0.0', true);
    $params = array(
        'param1' => esc_js($param1), // Escaping the parameter before passing it to JavaScript
    );

    // Localize the script and pass the parameters
    wp_localize_script('remodel-ai-chatbot-ui-script', 'remodel_ai_chatbot_Params', $params);
}
add_action('wp_enqueue_scripts', 'remodel_ai_chatbot_enqueue_scripts');

// Add settings page to WordPress admin
function remodel_ai_chatbot_settings_page()
{
    // Save custom parameters if form is submitted
    if (isset($_POST['submit'])) {
        // Get the submitted parameter value and sanitize it
        $chatbot_param1 = sanitize_text_field($_POST['remodel_ai_chatbot_param-1']);

        // Update the plugin options
        update_option('remodel_ai_chatbot_param1', $chatbot_param1);

        // Trigger parameter update in the chat-ui.js file
        echo '<script>updateChatbotParams(' . wp_json_encode(array('param1' => esc_js($chatbot_param1))) . ');</script>';

        // If needed, you can also perform additional actions with the data, like sending it to an external API
        $response = wp_remote_post('https://example.com/api/endpoint', array(
            'body' => array(
                'param1' => $chatbot_param1
            )
        ));
    }

    // Retrieve custom parameters from the plugin settings
    $param1 = get_option('remodel_ai_chatbot_param1');

    // Display settings page HTML
    ?>
    <div class="remodel-ai-chatbot_settings-wrapper">
        <h1>RemodelAI Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="remodel_ai_chatbot_param-1">Enter your chatbotID: </label></th>
                        <td><input style="height: 40px" name="remodel_ai_chatbot_param-1" type="password" id="remodel_ai_chatbot_param-1" value="<?php echo esc_attr($param1); ?>" class="regular-text"></td>
                    </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
        </form>
    </div>
    <?php
}

// Add action for the settings page
function remodel_ai_chatbot_add_settings_page()
{
    add_menu_page(
        'Remodel AI',
        'Remodel AI',
        'manage_options',
        'remodel-ai-chatbot',
        'remodel_ai_chatbot_settings_page',
        'dashicons-format-status',
        99
    );
}
add_action('admin_menu', 'remodel_ai_chatbot_add_settings_page');
