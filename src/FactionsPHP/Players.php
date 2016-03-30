<?php

namespace FactionsPHP;

use FactionsPHP\Player;

use FactionsPHP\Faction;
use FactionsPHP\Factions;

use FactionsPHP\BukkitTools;

class Players {

    private static $player_cache;

    public static function getAll() {
        if (self::$player_cache == null) {
            $players = array();

            if ( ! Factions::checkMStore(true)) return $players;

            foreach (scandir(Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mplayer") as $key => $playerRaw) {
                if ( ! in_array($playerRaw, array(".", ".."))) {
                    $path = Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mplayer" . DIRECTORY_SEPARATOR . $playerRaw;
                    if (is_file($path)) {
                        $playerId = basename($path, ".json");
                        $player = new Player($playerId);

                        $players[$playerId] = $player;

                    }
                }
            }

            self::$player_cache = $players;
        }

        return self::$player_cache;

    }

    public static function getById($id) {
        if (isset(self::getAll()[$id])) return self::getAll()[$id];
        return null;
    }

    public static function getByName($name) {
        return self::getById(BukkitTools::name2id($name));
    }
}
