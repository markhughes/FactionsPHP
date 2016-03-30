<?php

    // Ignore this slab, does nice styling things :-D
    //  /---------------------------------------------------------\ //
    $eol_char = "<br>"; // browsers
    if(substr(php_sapi_name(), 0, 3) == "cli" || empty($_SERVER['REMOTE_ADDR'])) {
        $eol_char = "\r\n"; // terminals
    }
    // you don't have to use this function, it just makes it look nice
    // for terminals as well as web browers
    function echol($msg) {
        global $eol_char;
        echo($msg . $eol_char);
    }
    //  \---------------------------------------------------------/ //
 
