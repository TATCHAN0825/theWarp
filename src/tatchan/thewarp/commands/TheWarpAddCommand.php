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

namespace tatchan\thewarp\commands;

use CortexPE\Commando\args\BooleanArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\args\Vector3Argument;
use CortexPE\Commando\BaseSubCommand;
use pjz9n\libi18n\LangHolder;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;
use tatchan\thewarp\Utils;
use tatchan\thewarp\WarpPoint;
use tatchan\thewarp\WarpPointPool;

class TheWarpAddCommand extends BaseSubCommand {
    public function __construct() {
        parent::__construct("add", LangHolder::t(".description"), ["a"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if ($sender->hasPermission("thewarp.add")) {
            if (array_key_exists("position", $args) && array_key_exists("world", $args)) {
                if (($world = Utils::getWorldByNameWithLoad($args["world"])) === null) {
                    $sender->sendMessage(LangHolder::t(TextFormat::RED . "%.world_notfound", ["world" => $args["world"]]));
                    return;
                }
                $position = Position::fromObject($args["position"], $world);
            } else if ($sender instanceof Player) {
                $position = $sender->getPosition();
            } else {
                $this->sendUsage();
                return;
            }

            WarpPointPool::add(new WarpPoint($args["name"], $position, $args["public"] ?? true));
            $sender->sendMessage(LangHolder::t(TextFormat::GREEN . "%.added", ["name" => $args["name"]]));
        }


    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp.add");
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerArgument(1, new BooleanArgument("public", true));
        $this->registerArgument(2, new Vector3Argument("position", true));
        $this->registerArgument(3, new RawStringArgument("world", true));
    }
}
