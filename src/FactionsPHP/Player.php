<?php

namespace FactionsPHP;

use FactionsPHP\Factions;
use FactionsPHP\BukkitTools;

class Player {

    private $id;
    private $json;

    function __construct($id) {
        $this->id = $id;

        $this->getJSON();

    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return BukkitTools::id2name($this->id);
    }

    public function getFaction() {
        return Factions::getById($this->json->factionId);
    }

    public function getFactionId() {
        return $this->json->factionId;
    }

    public function getPower() {
        return $this->json->power;
    }

    public function getPowerboost() {
        return $this->json->powerBoost;
    }

    public function getRole() {
        return $this->json->role;
    }

    public function getLastActivityMillis() {
        return $this->json->lastActivityMillis;
    }

    /*------------------------------------------------------------
     * Internal Functions
     *------------------------------------------------------------
     * These are simple internal functions used to help organise
     * the information and add defaults
     *
     */

    private function getJSON() {
        if ($this->json == null) {
            $contents = file_get_contents($this->getPathToJSON());
            $this->json = json_decode($contents);
        }
        return $this->json;
    }

    private function getPathToJSON() {
        return Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mplayer" . DIRECTORY_SEPARATOR . $this->id . ".json";
    }
}
