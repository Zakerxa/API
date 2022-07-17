<?php

require join(DIRECTORY_SEPARATOR, array(__DIR__, "..", "app/class", "3dClass.php"));

if ((date("j") == '1') || (date("j") == '16' || (date("j") == '17') || (date("j") == '30') || (date("j") == '31'))) {
    Myanmar3D::AddHistory();
}else{
    echo "1,16,17,30,31";
}