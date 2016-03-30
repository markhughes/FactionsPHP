<?php

namespace FactionsPHP;

class BukkitTools {

    private static $path = null;
    private static $json = null;

    private static $idMap = array();
    private static $nameMap = array();

    public static function enableUserCache($path) {
        self::$path = $path;
        self::$json = json_decode(file_get_contents($path));

        foreach(self::$json as $row) {
            self::$idMap[strtolower($row->uuid)] = $row->name;
            self::$nameMap[strtolower($row->name)] = $row->uuid;
        }
    }

    public static function name2id($name) {
        if (self::$path == null || self::$json == null) return null;
        return self::$nameMap[strtolower($name)];
    }

    public static function id2name($id) {
        if (self::$path == null || self::$json == null) return null;
        return self::$idMap[strtolower($id)];
    }
}
