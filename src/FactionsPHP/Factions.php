<?php

namespace FactionsPHP;

class Factions {
    // Path to mstore, change using setMStorePath
    private static $mstore = "/spigot/mstore";
    // a cache of the mstore
    private static $mstore_json = null;

    public static function checkMStore($warn = false) {
        if ( ! is_dir(self::getMStorePath())) {
            trigger_error("MStore directory does not exist or was not set", E_USER_WARNING);
            return false;
        }

        return true;
    }

    // get all Factions
    public static function getAll($includePermanent = true) {
        $factions = array();

        if ( ! self::checkMStore(true)) return $factions;

        foreach (scandir(self::$mstore . DIRECTORY_SEPARATOR . "factions_faction") as $key => $factionRaw) {
            if ( ! in_array($factionRaw, array(".", ".."))) {
                $path = self::$mstore . DIRECTORY_SEPARATOR . "factions_faction" . DIRECTORY_SEPARATOR . $factionRaw;

                if (is_file($path)) {
                    $factionId = basename($factionRaw, ".json");
                    $faction = new Faction($factionId);

                    if ( ! $includePermanent && $faction->isPermanent()) {
                        continue;
                    }

                    $factions[$factionId] = $faction;

                }
            }
        }

        return $factions;
    }

    public static function getById($id) {
        return self::getAll()[$id];
    }

    public static function setMStorePath($path) {
        self::$mstore = $path;
    }

    public static function getMStorePath() {
        return self::$mstore;
    }

    public static function getMConf() {
        // Check for a cache of mconf, otherwise we'll grab it
        if (self::$mstore_json == null) {
            $instanceFile = self::$mstore . "factions_mconf/instance.json";
            $instanceContents = file_get_contents($instanceFile);
            $json = json_decode($instanceContents);
            self::$mstore_json = $json;
        }

        return self::$mstore_json;
    }

}
