<?php
if (!defined('ABSPATH')) {
    die;
}

/**************************
 * Add CPT Emails Columns
 * ***********************/

add_filter('manage_emails_posts_columns', 'set_custom_edit_email_columns');
add_action('manage_emails_posts_custom_column', 'custom_email_column', 10, 2);

function set_custom_edit_email_columns($columns)
{
    unset($columns['author']);
    $columns['subject'] = __('Subject', 'pjcf');
    $columns['email'] = __('Email', 'pjcf');

    return $columns;
}

function custom_email_column($column, $post_id)
{
    switch ($column) {
        case 'subject' :
            echo get_post_meta($post_id, 'pjcf_subject', true);
            break;

        case 'email' :
            echo get_post_meta($post_id, 'pjcf_email', true);
            break;
    }
}

/*********************************
 * PJ Message Information Meta Box
 * ******************************/

function pjcf_email_info_meta_box()
{
    add_meta_box(
        'email-info',
        __('Message Information', 'pjcf'),
        'pjcf_email_info_meta_box_callback',
        'emails'
    );
}

add_action('add_meta_boxes', 'pjcf_email_info_meta_box');

function pjcf_email_info_meta_box_callback($post)
{
    // Add a nonce field so we can check for it later.
    wp_nonce_field('global_email_nonce', 'global_email_nonce');

    $first_name = get_post_meta($post->ID, 'pjcf_fname', true);
    $last_name  = get_post_meta($post->ID, 'pjcf_lname', true);
    $subject    = get_post_meta($post->ID, 'pjcf_subject', true);
    $email      = get_post_meta($post->ID, 'pjcf_email', true);
    $message    = get_post_meta($post->ID, 'pjcf_message', true);
?>

    <table class="form-table pjcf-email-info">
        <tbody>
            <tr>
                <th scope="row"><?php esc_html_e('First Name : ','pjcf'); ?></th>
                <td>
                    <?php echo esc_html($first_name) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Last Name : ','pjcf'); ?></th>
                <td>
                    <?php echo esc_html($last_name) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Subject : ','pjcf'); ?></th>
                <td>
                    <?php echo esc_html($subject) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Email : ','pjcf'); ?></th>
                <td>
                    <?php echo esc_html($email) ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Message : ','pjcf'); ?></th>
                <td>
                    <?php echo esc_html($message) ?>
                </td>
            </tr>
        </tbody>
    </table>

<?php }