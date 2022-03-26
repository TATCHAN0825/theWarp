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

namespace tatchan\thewarp\Repositories;

use pocketmine\utils\Config;
use pocketmine\world\Position;
use tatchan\thewarp\Utils;
use tatchan\thewarp\WarpPoint;

class YamlUserRepository implements WarpPointRepository {
    private Config $config;

    public function __construct(string $filePath) {
        $this->config = new Config($filePath, Config::YAML);
    }

    public function getAll(): array {
        $points = [];
        foreach ($this->config->getAll() as $name => $value) {
            $world = Utils::getWorldByNameWithLoad($value["world"]);
            if ($world === null) continue;
            $points[$name] = new WarpPoint($name, new Position($value["x"], $value["y"], $value["z"], $world), $value["public"]);
        }
        return $points;
    }

    public function storeAll(array $warpPoints): void {
        foreach ($warpPoints as $point) {
            $this->config->set($point->getName(), [
                "x" => $point->getPosition()->getX(),
                "y" => $point->getPosition()->getY(),
                "z" => $point->getPosition()->getZ(),
                "world" => $point->getPosition()->getWorld()->getFolderName(),
                "public" => $point->isPublic()
            ]);
        }
    }

    public function remove(string $name): void {
        $this->config->remove($name);
    }

    public function save(): void {
        $this->config->save();
    }
}