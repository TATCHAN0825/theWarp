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

use CortexPE\Commando\BaseSubCommand;
use pjz9n\libi18n\LangHolder;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use tatchan\thewarp\WarpPoint;
use tatchan\thewarp\WarpPointPool;

class TheWarpListCommand extends BaseSubCommand {
    public function __construct() {
        parent::__construct("list", LangHolder::t(".description"), ["l"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $sender->sendMessage(LangHolder::t(TextFormat::GREEN . "%.description"));
        $sender->sendMessage(implode(TextFormat::EOL, array_map(fn(WarpPoint $point): string => $point->getName() . " " . $point->getPosition(), WarpPointPool::getAllForPlayer($sender))));
    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp.list");
    }
}
