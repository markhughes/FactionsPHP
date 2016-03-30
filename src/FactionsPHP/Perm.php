<?php

namespace FactionsPHP;

class Perm {

    private $name;
    private $perms;

    function __construct($name, $perms = null) {
        $this->name = $name;

        if($perms != null) {
            $this->perms = $perms;
        } else {
            $path = Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mperm" . DIRECTORY_SEPARATOR . $name . ".json";
            $rawJSON = json_decode(file_get_contents($path));

            $this->perms = $rawJSON->standard;

        }
    }

    function getName() {
        return $this->name;
    }

    function getAllowed() {
        return $this->perms;
    }

    function isAllowed($what) {
        return in_array($this->perms, $what);
    }

}
