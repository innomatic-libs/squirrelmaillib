<?php

/**
 * Disposition.class.php
 *
 * Copyright (c) 2003 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This contains functions needed to handle mime messages.
 *
 * $Id: Disposition.class.php,v 1.1 2003-06-21 13:17:16 alex Exp $
 */

class Disposition {
    function Disposition($name) {
       $this->name = $name;
       $this->properties = array();
    }

    function getProperty($par) {
        $value = strtolower($par);
        if (isset($this->properties[$par])) {
            return $this->properties[$par];
        }
        return '';
    }
}

?>
