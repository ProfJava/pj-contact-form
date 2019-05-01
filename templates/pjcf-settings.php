<div class="wrap">
    <h1>PJ Contact Form Settings</h1>
    <table class="form-table pjcf-email-info">
        <tbody>
        <tr>
            <th scope="row"><?php esc_html_e('Use The Shortcode To display The Contact Form : ','pjcf'); ?></th>
            <td>
                <p>[pjcf]</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php esc_html_e('Receiver Email : ','pjcf'); ?></th>
            <td>
                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                    <?php wp_nonce_field('receiver_email','wp_nonce_check') ?>
                    <input type="hidden" name="action" value="receiver_email_process">
                    <input type="email" name="receiver_email" value="<?php echo esc_attr(get_option('receiver_email')) ?>" class="regular-text">
                    <button type="submit" class="button button-primary">Save</button>
                </form>
            </td>
        </tr>
        </tbody>
    </table>
</div>