<?php
class Database{
    public static function getConnection(){
        $dbFile=__DIR__ . '/../data/db.sqlite';
        $instance = null;
        if ($instance === null) {
            $instance = new PDO('sqlite:' . $dbFile);
            $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $instance->exec('PRAGMA foreign_keys = ON;');
        }
        return $instance;
    }
}