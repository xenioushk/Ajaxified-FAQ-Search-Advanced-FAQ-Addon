<?php
/**
 * The template for displaying plugin settings page.
 *
 * Template Version: 1.0.0
 *
 * @package FTFWCWP
 * @since 1.0.0
 */
?>
<div class="wrap faq-wrapper baf-option-panel">

    <h2><?php echo esc_html( $page_title ); ?></h2>

    <?php if ( isset( $_GET['settings-updated'] ) ) { ?>
    <div id="message" class="updated">
    <p><strong>✅ <?php esc_html_e( 'Settings saved.', 'baf-faqtfw' ); ?></strong></p>
    </div>
    <?php } ?>

    <form action="options.php" method="post">

    <?php
        settings_fields( $options_id );
        do_settings_sections( $page_id );
    ?>

    <p class="submit">
        <input name="submit" type="submit" class="button-primary"
        value="<?php esc_html_e( 'Save Settings', 'baf-faqtfw' ); ?>" />
    </p>
    </form>

</div>
