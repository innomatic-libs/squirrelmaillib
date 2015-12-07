<?php

require_once('innomatic/io/filesystem/DirectoryUtils.php');
DirectoryUtils::unlinkTree( InnomaticContainer::instance('innomaticcontainer')->getHome().'WEB-INF/applications/squirrelmaillib/squirrelmail' );

?>
