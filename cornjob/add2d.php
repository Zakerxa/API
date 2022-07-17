<?php

require join(DIRECTORY_SEPARATOR, array(__DIR__, "..", "app/class", "2dClass.php"));

if ((date("N") != '6') && (date("N") != '7')) {
  Myanmar2D::AddHistory();  
}


