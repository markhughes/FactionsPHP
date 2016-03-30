<?php

    include("example-includes.php");
    include("../vendor/autoload.php");

    use FactionsPHP\Factions;

    use FactionsPHP\Players;

    use FactionsPHP\BukkitTools;

    // This next line is required - points us to the mstore folder
    Factions::setMStorePath("/Users/markhughes/Spigot/mstore");

    // This next line is optional, but lets us use players names (you should though)
    BukkitTools::enableUserCache("/Users/markhughes/Spigot/usercache.json");

    // Get all Factions (pass false to exclude permanent factions)
    foreach (Factions::getAll(true) as $faction) {
         // Get faction name
        $name = $faction->getName();

        // Get creation date, pass no args for timestamp
        $created = $faction->getCreationDate("d/m/Y");

        echol($name);
        echol("Created on " . $created);

        // Check for a leader
        if ($faction->getLeader() != null) {
            $leader = $faction->getLeader();
            $leaderName = $leader->getName();

            echol("The leader is: {$leaderName}");
        }

        echol("");
    }

    // You can also get by id
    $faction = Factions::getById("0268c6f1-66fc-4ba7-9091-097518064b56");


    // You can also get the player
    $player = Players::getByName("MarkehMe");
    // and their faction
    $playersFaction = $player->getFaction();

    // Of course, other general player information we managed to fetch
    echol($player->getPower());
    echol($player->getRole());
    echol($player->getLastActivityMillis());
