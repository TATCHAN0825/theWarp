<?php
declare(strict_types=1);

namespace tatchan\thewarp\commands;

use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\plugin\Plugin;

class TheWarpManagerCommand extends BaseCommand {
    public function __construct(Plugin $plugin) {
        parent::__construct($plugin, "thewarpmanager", "thewarpmanager", ["twg"]);
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
