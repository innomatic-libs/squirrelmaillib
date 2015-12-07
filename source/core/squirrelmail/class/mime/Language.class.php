<?php

/**
 * Language.class.php
 *
 * Copyright (c) 2003 The SquirrelMail Project Team
 * Licensed under the GNU GPL. For full terms see the file COPYING.
 *
 * This contains functions needed to handle mime messages.
 *
 * $Id: Language.class.php,v 1.1 2003-06-21 13:17:16 alex Exp $
 */

class Language {
    function Language($name) {
       $this->name = $name;
       $this->properties = array();
    }
}

?>
