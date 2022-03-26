<?php
declare(strict_types=1);

namespace tatchan\thewarp\commands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use tatchan\thewarp\WarpPointPool;

class TheWarpRemoveCommand extends BaseSubCommand {
    public function __construct() {
        parent::__construct("remove", "ワープを削除するする", ["r"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if ((!$sender->hasPermission("thewarp.remove")) || ($point = WarpPointPool::get($args["name"])) === null) {
            $sender->sendMessage(TextFormat::RED . implode(TextFormat::EOL, ["ポイントが見つかりませんでした", "又は権限がありません", "名前を確認して再度お試しください"]));;
        } else {
            WarpPointPool::remove($point);
            $sender->sendMessage(TextFormat::YELLOW . "{$point->getName()}を削除しました");
        }
    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp.remove");
        $this->registerArgument(0, new RawStringArgument("name"));
    }
}