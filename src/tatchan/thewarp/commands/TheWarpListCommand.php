<?php
declare(strict_types=1);

namespace tatchan\thewarp\commands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use tatchan\thewarp\WarpPoint;
use tatchan\thewarp\WarpPointPool;

class TheWarpListCommand extends BaseSubCommand {
    public function __construct() {
        parent::__construct("list", "ワープ一覧を表示する", ["l"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $sender->sendMessage(TextFormat::YELLOW . "ワープ一覧を表示する");
        $sender->sendMessage(implode(TextFormat::EOL, array_map(fn(WarpPoint $point): string => $point->getName() . " " . $point->getPosition(), WarpPointPool::getAllForPlayer($sender))));
    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp.list");
    }
}
