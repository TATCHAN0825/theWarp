<?php
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