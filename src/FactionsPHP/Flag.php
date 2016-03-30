<?php

namespace FactionsPHP;

use FactionsPHP\Factions;

class Flag {
    private $name;
    private $state;

    function __construct($name, $state = null) {
        $this->name = $name;

        if ($state != null) {
            $this->state = $state;
        } else {
            $path = Factions::getMStorePath() . DIRECTORY_SEPARATOR . "factions_mflag" . DIRECTORY_SEPARATOR . $name . ".json";
            $rawJSON = json_decode(file_get_contents($path));
            
            if ($rawJSON->standard == "true" || $rawJSON->standard == true || $rawJSON->standard == 1 || $rawJSON->standard == "1") {
                $this->state == true;
            } else {
                $this->state == false;
            }

            $this->name = $rawJSON->name;
        }

        // Ensure the state value is nice and tidy
        if ($this->state == 1 || $this->state == true) {
            $this->state = true;
        } else {
            $this->state = false;
        }

    }

    public function getName() {
        return $this->name;
    }

    public function getState() {
        return $this->state;
    }

}
