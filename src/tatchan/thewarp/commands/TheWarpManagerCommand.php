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

use CortexPE\Commando\BaseCommand;
use pjz9n\libi18n\LangHolder;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;

class TheWarpManagerCommand extends BaseCommand {
    public function __construct(Plugin $plugin) {
        parent::__construct($plugin, "thewarpmanager", LangHolder::t(".description"), ["twg"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $this->sendUsage();
    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarpmanager");
        $this->registerSubCommand(new TheWarpAddCommand());
        $this->registerSubCommand(new TheWarpRemoveCommand());
    }

}
