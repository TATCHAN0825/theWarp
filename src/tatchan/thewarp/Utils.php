<?php
declare(strict_types=1);

namespace tatchan\thewarp;

use pocketmine\Server;
use pocketmine\world\World;

final class Utils {

    public static function getWorldByNameWithLoad(string $name): ?World {
        $world = Server::getInstance()->getWorldManager()->getWorldByName($name);
        if ($world !== null) {
            return $world;
        }
        Server::getInstance()->getWorldManager()->loadWorld($name);
        return Server::getInstance()->getWorldManager()->getWorldByName($name);
    }

    private function __construct() {
        //NOOP
    }

}