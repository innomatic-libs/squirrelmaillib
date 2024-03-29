<?php

/**
 * plugin.php
 *
 * Copyright (c) 1999-2003 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This file provides the framework for a plugin architecture.
 *
 * Documentation on how to write plugins might show up some time.
 *
 * $Id: plugin.php,v 1.1 2003-06-21 13:17:20 alex Exp $
 */

require_once(SM_PATH . 'functions/global.php');

global $squirrelmail_plugin_hooks;
$squirrelmail_plugin_hooks = array();

/* This function adds a plugin. */
function use_plugin ($name) {
    if (file_exists(SM_PATH . "plugins/$name/setup.php")) {
        include_once(SM_PATH . "plugins/$name/setup.php");
        $function = "squirrelmail_plugin_init_$name";
        if (function_exists($function)) {
            $function();
        }
    }
}

/* This function executes a hook. */
function do_hook ($name) {
    global $squirrelmail_plugin_hooks;
    $data = func_get_args();
    $ret = '';

    if (isset($squirrelmail_plugin_hooks[$name])
          && is_array($squirrelmail_plugin_hooks[$name])) {
        foreach ($squirrelmail_plugin_hooks[$name] as $function) {
            /* Add something to set correct gettext domain for plugin. */
            if (function_exists($function)) {
                $function($data);
            }
        }
    }

    /* Variable-length argument lists have a slight problem when */
    /* passing values by reference. Pity. This is a workaround.  */
    return $data;
}

/* This function executes a hook. */
function do_hook_function($name,$parm=NULL) {
    global $squirrelmail_plugin_hooks;
    $ret = '';

    if (isset($squirrelmail_plugin_hooks[$name])
          && is_array($squirrelmail_plugin_hooks[$name])) {
        foreach ($squirrelmail_plugin_hooks[$name] as $function) {
            /* Add something to set correct gettext domain for plugin. */
            if (function_exists($function)) {
                $ret = $function($parm);
            }
        }
    }

    /* Variable-length argument lists have a slight problem when */
    /* passing values by reference. Pity. This is a workaround.  */
    return $ret;
}

/* This function executes a hook. */
function concat_hook_function($name,$parm=NULL) {
    global $squirrelmail_plugin_hooks;
    $ret = '';

    if (isset($squirrelmail_plugin_hooks[$name])
          && is_array($squirrelmail_plugin_hooks[$name])) {
        foreach ($squirrelmail_plugin_hooks[$name] as $function) {
            /* Concatenate results from hook. */
            if (function_exists($function)) {
                $ret .= $function($parm);
            }
        }
    }

    /* Variable-length argument lists have a slight problem when */
    /* passing values by reference. Pity. This is a workaround.  */
    return $ret;
}

/**
 * This function checks whether the user's USER_AGENT is known to
 * be broken. If so, returns true and the plugin is invisible to the
 * offending browser.
 */
function soupNazi(){

    $soup_menu = array('Mozilla/3','Mozilla/2','Mozilla/1', 'Opera 4',
                       'Opera/4', 'OmniWeb', 'Lynx');
    sqgetGlobalVar('HTTP_USER_AGENT', $user_agent, SQ_SERVER);
    foreach($soup_menu as $browser) {
        if(stristr($user_agent, $browser)) {
            return 1;
        }
    }
    return 0;
}
/*************************************/
/*** MAIN PLUGIN LOADING CODE HERE ***/
/*************************************/

/* On startup, register all plugins configured for use. */
if (isset($plugins) && is_array($plugins)) {
    foreach ($plugins as $name) {
        use_plugin($name);
    }
}

?>
