<?php
/**
 * Deliver_SendMail.class.php
 *
 * Copyright (c) 1999-2003 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * Delivery backend for the Deliver class.
 *
 * $Id: Deliver_SendMail.class.php,v 1.1 2003-06-21 13:17:15 alex Exp $
 */

require_once(SM_PATH . 'class/deliver/Deliver.class.php');

class Deliver_SendMail extends Deliver {

    function preWriteToStream(&$s) {
       if ($s) {
    	  $s = str_replace("\r\n", "\n", $s);
       }
    }
    
    function initStream($message, $sendmail_path) {
        $rfc822_header = $message->rfc822_header;
	$from = $rfc822_header->from[0];
	$genvelopefrom = $from->mailbox.'@'.$from->host;
	if (strstr($sendmail_path, "qmail-inject")) {
    	    $stream = popen (escapeshellcmd("$sendmail_path -i -fgenvelopefrom"), "w");
	} else {
    	    $stream = popen (escapeshellcmd("$sendmail_path -i -t -fgenvelopefrom"), "w");
	}
	return $stream;
    }
    
    function finalizeStream($stream) {
	pclose($stream);
	return true;
    }
    
    function getBcc() {
       return true;
    }
    
}
?>
