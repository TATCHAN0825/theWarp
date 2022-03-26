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
