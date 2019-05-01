<?php
if (!defined('ABSPATH')) {
    die;
}

// Hooking up our function to theme setup
add_action('init', 'pjcf_cpt');
// Our custom post type function
function pjcf_cpt()
{
    register_post_type('emails',
        // CPT Options
        array(
            'labels' => array(
                'name' => __('Emails', 'pjcf'),
                'singular_name' => __('Email', 'pjcf')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'emails'),
            'supports' => array('title'),
            'register_meta_box_cb' => 'pjcf_email_info_meta_box'
        )
    );
}


// Add ShortCode
add_shortcode('pjcf', 'pjcf_shortcode');
function pjcf_shortcode()
{ ?>
    <h1 class="my-4 text-center"><?php esc_html_e('Add Email', 'pjcf'); ?></h1>
    <form method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
        <div class="form-group my-3">
            <input type="text" name="fname" class="form-control"
                   placeholder="<?php esc_attr_e('First Name', 'pjcf') ?>">
        </div>
        <div class="form-group my-3">
            <input type="text" name="lname" class="form-control" placeholder="<?php esc_attr_e('Last Name', 'pjcf') ?>">
        </div>
        <div class="form-group my-3">
            <input type="text" name="title" class="form-control" placeholder="<?php esc_attr_e('Title', 'pjcf') ?>">
        </div>
        <div class="form-group my-3">
            <input type="text" name="subject" class="form-control" placeholder="<?php esc_attr_e('Subject', 'pjcf') ?>">
        </div>
        <div class="form-group my-3">
            <input type="email" name="email" class="form-control" placeholder="<?php esc_attr_e('Email', 'pjcf') ?>">
        </div>
        <div class="form-group my-3">
            <textarea name="message" cols="30" rows="10" class="form-control"
                      placeholder="<?php esc_attr_e('Message', 'pjcf') ?>"></textarea>
        </div>
        <input type="hidden" name="action" value="new_email">
        <button type="submit" class="btn btn-info"><?php esc_html_e('Send Email', 'pjcf') ?></button>
    </form>
<?php }

// Add Email
add_action('admin_post_new_email', 'pjcf_new_email');
add_action('admin_post_nopriv_new_email', 'pjcf_new_email');
function pjcf_new_email()
{
    $args = [
        'post_title' => sanitize_text_field($_POST['title']),
        'post_status' => 'publish',
        'post_type' => 'emails',
        'meta_input' => array(
            'pjcf_fname'    => sanitize_text_field($_POST['fname']),
            'pjcf_lname'    => sanitize_text_field($_POST['lname']),
            'pjcf_subject'  => sanitize_text_field($_POST['subject']),
            'pjcf_email'    => sanitize_email($_POST['email']),
            'pjcf_message'  => sanitize_textarea_field($_POST['message'])
        ),

    ];
    $post_id    = wp_insert_post($args);
    $content    = '';
    $content    .= 'First Name: '  . sanitize_text_field($_POST['fname']) . '<br>';
    $content    .= 'Last Name: '   . sanitize_text_field($_POST['lname']) . '<br>';
    $content    .= 'Subject: '     . sanitize_text_field($_POST['subject']) . '<br>';
    $content    .= 'Email: '       . sanitize_email($_POST['email']) . '<br>';
    $content    .= 'Message: '     . sanitize_textarea_field($_POST['message']) . '<br>';

    $to         = sanitize_email(get_option('receiver_email'));
    $subject    = sanitize_text_field($_POST['subject']);
    $sender     = 'PJ Contact Form';
    $message    = $content;
    $headers[]  = 'MIME-Version: 1.0' . "\r\n";
    $headers[]  = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[]  = "X-Mailer: PHP \r\n";
    $headers[]  = 'From: ' . $sender . ' <no-reply@example.com>' . "\r\n";
    if (!is_wp_error($post_id)) {
        $mail = wp_mail($to, $subject, $message, $headers);
    }

    wp_redirect(home_url('/'));
    exit;
}

add_action('admin_post_receiver_email_process','pjcf_receiver_email');
function pjcf_receiver_email() {
    if(isset($_POST['wp_nonce_check'])){
        if ( ! wp_verify_nonce( $_POST['wp_nonce_check'], 'receiver_email' ) ) {
            return;
        }

        if(isset($_POST['receiver_email']) && is_email($_POST['receiver_email'])) {
            update_option('receiver_email',sanitize_email($_POST['receiver_email']));
            wp_safe_redirect( admin_url( '/admin.php?page=pj_contact_form' ) );
            exit;
        }



    }
}
