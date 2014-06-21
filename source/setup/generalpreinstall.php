<?php

require_once('innomatic/io/filesystem/DirectoryUtils.php');
DirectoryUtils::dircopy( $this->basedir.'/WEB-INF/squirrelmail/', InnomaticContainer::instance('innomaticcontainer')->getHome().'WEB-INF/applications/squirrelmaillib/squirrelmail/' );

?>
