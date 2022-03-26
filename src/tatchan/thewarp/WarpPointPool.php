<?php
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
