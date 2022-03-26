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

use InvalidArgumentException;
use pocketmine\permission\Permissible;

final class WarpPointPool {
    /** @var WarpPoint[] */
    private static array $warpPoints = [];

    /**
     * @param WarpPoint[] $warpPoints
     */
    public static function init(array $warpPoints): void {
        foreach ($warpPoints as $point) {
            self::add($point);
        }
    }

    public static function add(WarpPoint $point): void {
        if (array_key_exists($point->getName(), self::$warpPoints)) {
            throw new InvalidArgumentException("Warp name {$point->getName()} already exists");
        }

        self::$warpPoints[$point->getName()] = $point;
    }

    public static function remove(WarpPoint $point): void {
        if (!array_key_exists($point->getName(), self::$warpPoints)) {
            throw new InvalidArgumentException("Warp name {$point->getName()} not found");
        }

        unset(self::$warpPoints[$point->getName()]);
        Main::getRepository()->remove($point->getName());
    }

    /**
     * @return WarpPoint[]
     */
    public static function getAll(): array {
        return self::$warpPoints;
    }

    public static function get(string $name): ?WarpPoint {
        return self::getAll()[$name] ?? null;
    }

    /**
     * @return WarpPoint[]
     */
    public static function getAllForPlayer(Permissible $target): array {
        return array_filter(self::getAll(), fn(WarpPoint $point): bool => $point->canWarp($target));
    }

    private function __construct() {
        //NOOP
    }


}
