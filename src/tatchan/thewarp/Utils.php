<?php
/*
 * Copyright (c) 2022 tatchan.
 *
 * This file is part of theWarp.
 *
 * theWarp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * theWarp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with theWarp. If not, see <http://www.gnu.org/licenses/>.
 */

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