<div class="wrap">
    <h2>Referer Specific Contacts</h2>
    <p>
        Use shortcodes <strong>[referer-contact-phone]</strong> for displaying phone number and <strong>[referer-contact-email]</strong> for displaying email address
    </p>
    <form method="post" action="options.php">
    <?php
        settings_fields( 'referer_specific_contact_option_group' );
        do_settings_sections($this->_menu_slug);
        submit_button();
    ?>
    </form>
</div>