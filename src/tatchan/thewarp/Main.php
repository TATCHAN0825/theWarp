<?php

declare(strict_types=1);

namespace tatchan\thewarp;

use CortexPE\Commando\exception\HookAlreadyRegistered;
use CortexPE\Commando\PacketHooker;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use tatchan\thewarp\commands\TheWarpCommand;
use tatchan\thewarp\commands\TheWarpManagerCommand;
use tatchan\thewarp\Repositories\WarpPointRepository;
use tatchan\thewarp\Repositories\YamlUserRepository;
use Webmozart\PathUtil\Path;

class Main extends PluginBase {
    private static WarpPointRepository $repository;

    public static function getRepository(): WarpPointRepository {
        return self::$repository;
    }

    /**
     * @throws HookAlreadyRegistered
     */
    protected function onEnable(): void {
        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
        Server::getInstance()->getCommandMap()->register($this->getName(), new TheWarpCommand($this));
        Server::getInstance()->getCommandMap()->register($this->getName(), new TheWarpManagerCommand($this));
        self::$repository = new YamlUserRepository(Path::join($this->getDataFolder(), "warps.yml"));
        WarpPointPool::init(self::$repository->getAll());
    }

    protected function onDisable(): void {
        self::$repository->storeAll(WarpPointPool::getAll());
        self::$repository->save();
    }

}
