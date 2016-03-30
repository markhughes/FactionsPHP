<?php

namespace FactionsPHP;

use FactionsPHP\Factions;

class Flags {

    private static $default_flags = null;

    public static function getDefaults() {
        if (self::$default_flags == null) {
            $flags = array();

            foreach (scandir(Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mflag") as $key => $flagRaw) {
                if ( ! in_array($flagRaw, array(".", ".."))) {
                    $path = Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mflag" . DIRECTORY_SEPARATOR . $flagRaw;

                    if (is_file($path)) {
                        $flagName = basename($flagRaw, ".json");
                        $flag = new Flag($flagName);

                        $flags[$flagName] = $flag;
                    }
                }
            }

            self::$default_flags = $flags;
        }

        return self::$default_flags;
    }

    public static function getDefault($flagName) {
        return self::getDefaults()["$flagName"];
    }

}
