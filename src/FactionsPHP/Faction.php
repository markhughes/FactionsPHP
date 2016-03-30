<?php

namespace FactionsPHP;

use FactionsPHP\Flag;
use FactionsPHP\Flags;

use FactionsPHP\Perm;
use FactionsPHP\Perms;

use FactionsPHP\Player;
use FactionsPHP\Players;

class Faction {

    private $id;
    private $json = null;
    private $flags;
    private $perms;
    private $leader;
    private $members;
    private $officers = array();

    function __construct($id) {
        $this->id = $id;

        $this->getJSON();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->getJSON()->name;
    }

    public function getDescription() {
        return $this->getJSON()->description;
    }

    public function getCreationDate($format = null) {
        if ($format == null) return $this->getJSON()->createdAtMillis;

        return date($format, $this->getJSON()->createdAtMillis / 1000);
    }

    public function getFlags() {
        return $this->flags;
    }

    public function getFlag($flagName) {
        if ( ! isset($this->flags[$flagName])) {
            return false;
        }

        return $this->flags[$flagName]->getState();
    }

    public function hasFlag($flagName) {
        return isset($this->flags[$flagName]);
    }

    public function getPerms() {
        return $this->perms;
    }

    public function getPerm($permName) {
        return $this->perms[$permName];
    }

    public function hasPerm($permName){
        return isset($this->perms[$permName]);
    }

    public function isPermanent() {
        return $this->getFlag("permanent");
    }

    public function getLeader() {
        return $this->leader;
    }

    public function getMembers() {
        return $this->members;
    }

    public function getOfficers() {
        return $this->officers;
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
             $this->json = json_decode(file_get_contents($this->getPathToJSON()));

             // Load flags up nicely
             $this->flags = [];
             if (isset($this->json->flags)) {
                 foreach ($this->json->flags as $name => $state) {
                     $this->flags[$name] = new Flag($name, $state);
                 }
             }
             $this->ensureAllFlagsLogged();

             // Load perms up nicely too
             $this->perms = [];
             if (isset($this->json->perms)) {
                 foreach ($this->json->perms as $name => $perms) {
                     $this->perms[$name] = new Perm($name, $perms);
                 }
             }
             $this->ensureAllPermsLogged();

             foreach (Players::getAll() as $playerId => $player) {
                 if ($player->getFactionId() == $this->id) {
                     $this->members[$playerId] = $player;

                     if ($player->getRole() == "LEADER") {
                         $this->leader = $player;
                     }

                     if ($player->getRole() == "OFFICER") {
                         $this->officers[$playerId] = $player;
                     }

                 }
             }

         }

         return $this->json;
    }

    private function getPathToJSON() {
         return Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_faction" . DIRECTORY_SEPARATOR . $this->id . ".json";
    }

    private function ensureAllFlagsLogged() {
        foreach (Flags::getDefaults() as $flag) {
            if ( ! $this->hasFlag($flag->getName())) {
                $this->flags[$flag->getName()] = new Flag($flag->getName(), $flag->getState());
            }
        }
    }

    private function ensureAllPermsLogged() {
        foreach (Perms::getDefaults() as $perm) {
            if ( ! $this->hasPerm($perm->getName())) {
                $this->perms[$perm->getName()] = new Perm($perm->getName(), $perm->getAllowed());
            }
        }

    }

}
