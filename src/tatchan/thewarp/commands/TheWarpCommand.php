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

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use pjz9n\libi18n\LangHolder;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use tatchan\thewarp\WarpPointPool;

class TheWarpCommand extends BaseCommand {

    public function __construct(Plugin $plugin) {
        parent::__construct($plugin, "thewarp", LangHolder::t(".description"), ["warp", "tw"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(LangHolder::t(TextFormat::RED . "%error.player_only"));
            return;
        }
        $point = WarpPointPool::get($args["name"]);

        if ($point === null || (!$point->canWarp($sender))) {
            $sender->sendMessage(LangHolder::t(TextFormat::RED . "%.error1"));
            return;
        }

        $sender->teleport($point->getPosition());
        $sender->sendMessage(LangHolder::t(TextFormat::GREEN . "%.teleport", ["name" => $point->getName()]));

    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp");
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerSubCommand(new TheWarpListCommand());
    }
}
