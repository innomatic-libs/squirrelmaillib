<?php

require_once('innomatic/io/filesystem/DirectoryUtils.php');
DirectoryUtils::unlinkTree( InnomaticContainer::instance('innomaticcontainer')->getHome().'WEB-INF/applications/squirrelmaillib/squirrelmail' );
DirectoryUtils::dircopy( $this->basedir.'/WEB-INF/squirrelmail/', InnomaticContainer::instance('innomaticcontainer')->getHome().'WEB-INF/applications/squirrelmaillib/squirrelmail/' );

?>
