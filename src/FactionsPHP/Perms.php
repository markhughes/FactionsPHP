<?php

namespace FactionsPHP;

class Perms {

    private static $default_perms = null;

    public static function getDefaults() {
        if (self::$default_perms == null) {
            $perms = array();

            foreach (scandir(Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mperm") as $key => $permRaw) {
                if ( ! in_array($permRaw, array(".", ".."))) {
                    $path = Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mperm" . DIRECTORY_SEPARATOR . $permRaw;

                    if (is_file($path)) {
                        $permName = basename($permRaw, ".json");
                        $perm = new Perm($permName);

                        $perms[$permName] = $perm;
                    }
                }
            }

            self::$default_perms = $perms;
        }

        return self::$default_perms;
    }

}
