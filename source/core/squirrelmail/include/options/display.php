<?php

/**
 * options_display.php
 *
 * Copyright (c) 1999-2003 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * Displays all optinos about display preferences
 *
 * $Id: display.php,v 1.1 2003-06-21 13:17:21 alex Exp $
 */

/* Define the group constants for the display options page. */
define('SMOPT_GRP_GENERAL', 0);
define('SMOPT_GRP_MAILBOX', 1);
define('SMOPT_GRP_MESSAGE', 2);

/* Define the optpage load function for the display options page. */
function load_optpage_data_display() {
    global $theme, $language, $languages, $js_autodetect_results,
    $compose_new_win, $default_use_mdn, $squirrelmail_language, $allow_thread_sort;

    /* Build a simple array into which we will build options. */
    $optgrps = array();
    $optvals = array();

    /******************************************************/
    /* LOAD EACH GROUP OF OPTIONS INTO THE OPTIONS ARRAY. */
    /******************************************************/

    /*** Load the General Options into the array ***/
    $optgrps[SMOPT_GRP_GENERAL] = _("General Display Options");
    $optvals[SMOPT_GRP_GENERAL] = array();

    /* Load the theme option. */
    $theme_values = array();
    foreach ($theme as $theme_key => $theme_attributes) {
        $theme_values[$theme_attributes['NAME']] = $theme_attributes['PATH'];
    }
    ksort($theme_values);
    $theme_values = array_flip($theme_values);
    $optvals[SMOPT_GRP_GENERAL][] = array(
        'name'    => 'chosen_theme',
        'caption' => _("Theme"),
        'type'    => SMOPT_TYPE_STRLIST,
        'refresh' => SMOPT_REFRESH_ALL,
        'posvals' => $theme_values,
        'save'    => 'save_option_theme'
    );
 
    $css_values = array( 'none' => _("Default" ) );
    $handle=opendir('../themes/css/');
    while ($file = readdir($handle) ) {
        if ( substr( $file, -4 ) == '.css' ) {
            $css_values[$file] = substr( $file, 0, strlen( $file ) - 4 );
        }
    }
    closedir($handle);
    
    if ( count( $css_values > 1 ) ) {
    
        $optvals[SMOPT_GRP_GENERAL][] = array(
            'name'    => 'custom_css',
            'caption' => _("Custom Stylesheet"),
            'type'    => SMOPT_TYPE_STRLIST,
            'refresh' => SMOPT_REFRESH_ALL,
            'posvals' => $css_values
        );
    
    }
    
    $language_values = array();
    foreach ($languages as $lang_key => $lang_attributes) {
        if (isset($lang_attributes['NAME'])) {
            $language_values[$lang_key] = $lang_attributes['NAME'];
        }
    }
    asort($language_values);
    $language_values =
        array_merge(array('' => _("Default")), $language_values);
    $language = $squirrelmail_language;
    $optvals[SMOPT_GRP_GENERAL][] = array(
        'name'    => 'language',
        'caption' => _("Language"),
        'type'    => SMOPT_TYPE_STRLIST,
        'refresh' => SMOPT_REFRESH_ALL,
        'posvals' => $language_values
    );

    /* Set values for the "use javascript" option. */
    $optvals[SMOPT_GRP_GENERAL][] = array(
        'name'    => 'javascript_setting',
        'caption' => _("Use Javascript"),
        'type'    => SMOPT_TYPE_STRLIST,
        'refresh' => SMOPT_REFRESH_ALL,
        'posvals' => array(SMPREF_JS_AUTODETECT => _("Autodetect"),
                           SMPREF_JS_ON         => _("Always"),
                           SMPREF_JS_OFF        => _("Never"))
    );

    $js_autodetect_script =
        "<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"text/javascript\"><!--\n".
           "document.forms[0].new_js_autodetect_results.value = '" . SMPREF_JS_ON . "';\n".
        "// --></SCRIPT>\n";
    $js_autodetect_results = SMPREF_JS_OFF;
    $optvals[SMOPT_GRP_GENERAL][] = array(
        'name'    => 'js_autodetect_results',
        'caption' => '',
        'type'    => SMOPT_TYPE_HIDDEN,
        'refresh' => SMOPT_REFRESH_NONE,
        'script'  => $js_autodetect_script,
        'save'    => 'save_option_javascript_autodetect'
    );

    /*** Load the General Options into the array ***/
    $optgrps[SMOPT_GRP_MAILBOX] = _("Mailbox Display Options");
    $optvals[SMOPT_GRP_MAILBOX] = array();

    $optvals[SMOPT_GRP_MAILBOX][] = array(
        'name'    => 'show_num',
        'caption' => _("Number of Messages to Index"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_NONE,
        'size'    => SMOPT_SIZE_TINY
    );

    $optvals[SMOPT_GRP_MAILBOX][] = array(
        'name'    => 'alt_index_colors',
        'caption' => _("Enable Alternating Row Colors"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MAILBOX][] = array(
        'name'    => 'page_selector',
        'caption' => _("Enable Page Selector"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MAILBOX][] = array(
        'name'    => 'page_selector_max',
        'caption' => _("Maximum Number of Pages to Show"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_NONE,
        'size'    => SMOPT_SIZE_TINY
    );

    /*** Load the General Options into the array ***/
    $optgrps[SMOPT_GRP_MESSAGE] = _("Message Display and Composition");
    $optvals[SMOPT_GRP_MESSAGE] = array();

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'wrap_at',
        'caption' => _("Wrap Incoming Text At"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_NONE,
        'size'    => SMOPT_SIZE_TINY
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'editor_size',
        'caption' => _("Size of Editor Window"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_NONE,
        'size'    => SMOPT_SIZE_TINY
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'location_of_buttons',
        'caption' => _("Location of Buttons when Composing"),
        'type'    => SMOPT_TYPE_STRLIST,
        'refresh' => SMOPT_REFRESH_NONE,
        'posvals' => array(SMPREF_LOC_TOP     => _("Before headers"),
                           SMPREF_LOC_BETWEEN => _("Between headers and message body"),
                           SMPREF_LOC_BOTTOM  => _("After message body"))
    );


    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'use_javascript_addr_book',
        'caption' => _("Addressbook Display Format"),
        'type'    => SMOPT_TYPE_STRLIST,
        'refresh' => SMOPT_REFRESH_NONE,
        'posvals' => array('1' => _("Javascript"),
                           '0' => _("HTML"))
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'show_html_default',
        'caption' => _("Show HTML Version by Default"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'enable_forward_as_attachment',
        'caption' => _("Enable Forward as Attachment"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'forward_cc',
        'caption' => _("Include CCs when Forwarding Messages"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'include_self_reply_all',
        'caption' => _("Include Me in CC when I Reply All"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'show_xmailer_default',
        'caption' => _("Enable Mailer Display"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'attachment_common_show_images',
        'caption' => _("Display Attached Images with Message"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'pf_cleandisplay',
        'caption' => _("Enable Printer Friendly Clean Display"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    if ($default_use_mdn) {
        $optvals[SMOPT_GRP_MESSAGE][] = array(
            'name'    => 'mdn_user_support',
            'caption' => _("Enable Mail Delivery Notification"),
            'type'    => SMOPT_TYPE_BOOLEAN,
            'refresh' => SMOPT_REFRESH_NONE
        );
    }

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'compose_new_win',
        'caption' => _("Compose Messages in New Window"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_ALL
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'compose_width',
        'caption' => _("Width of Compose Window"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_ALL,
        'size'    => SMOPT_SIZE_TINY
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'compose_height',
        'caption' => _("Height of Compose Window"),
        'type'    => SMOPT_TYPE_INTEGER,
        'refresh' => SMOPT_REFRESH_ALL,
        'size'    => SMOPT_SIZE_TINY
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'sig_first',
        'caption' => _("Append Signature before Reply/Forward Text"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_NONE
    );

    $optvals[SMOPT_GRP_MESSAGE][] = array(
        'name'    => 'internal_date_sort',
        'caption' => _("Enable Sort by of Receive Date"),
        'type'    => SMOPT_TYPE_BOOLEAN,
        'refresh' => SMOPT_REFRESH_ALL
    );
    if ($allow_thread_sort == TRUE) {
        $optvals[SMOPT_GRP_MESSAGE][] = array(
            'name'    => 'sort_by_ref',
            'caption' => _("Enable Thread Sort by References Header"),
            'type'    => SMOPT_TYPE_BOOLEAN,
            'refresh' => SMOPT_REFRESH_ALL
        );
    }
    /* Assemble all this together and return it as our result. */
    $result = array(
        'grps' => $optgrps,
        'vals' => $optvals
    );
    return ($result);
}

/******************************************************************/
/** Define any specialized save functions for this option page. ***/
/******************************************************************/

function save_option_theme($option) {
    global $theme;

    /* Do checking to make sure $new_theme is in the array. */
    $theme_in_array = false;
    for ($i = 0; $i < count($theme); ++$i) {
        if ($theme[$i]['PATH'] == $option->new_value) {
            $theme_in_array = true;
            break;
        }
    }

    if (!$theme_in_array) {
        $option->new_value = '';
    }

    /* Save the option like normal. */
    save_option($option);
}

function save_option_javascript_autodetect($option) {
    global $data_dir, $username, $new_javascript_setting;

    /* Set javascript either on or off. */
    if ($new_javascript_setting == SMPREF_JS_AUTODETECT) {
        if ($option->new_value == SMPREF_JS_ON) {
            setPref($data_dir, $username, 'javascript_on', SMPREF_JS_ON);
        } else {
            setPref($data_dir, $username, 'javascript_on', SMPREF_JS_OFF);
        }
    } else {
        setPref($data_dir, $username, 'javascript_on', $new_javascript_setting);
    }
}

?>
