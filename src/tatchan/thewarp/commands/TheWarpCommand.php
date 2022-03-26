<?php
declare(strict_types=1);

namespace tatchan\thewarp\commands;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;
use tatchan\theWarp\WarpPointPool;

class TheWarpCommand extends BaseCommand {

    public function __construct(Plugin $plugin) {
        parent::__construct($plugin, "thewarp", "ワープをするよ", ["warp", "tw"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if (!($sender instanceof Player)) {
            $sender->sendMessage(TextFormat::RED . "ゲーム内で実行してください");
            return;
        }
        $point = WarpPointPool::get($args["name"]);

        if ($point === null || (!$point->canWarp($sender))) {
            $sender->sendMessage(TextFormat::RED . implode(TextFormat::EOL, ["ポイントが見つかりませんでした", "又は権限がありません", "名前を確認して再度お試しください"]));
            return;
        }

        $sender->teleport($point->getPosition());
        $sender->sendMessage(TextFormat::GREEN . "{$point->getName()}にてテレポートしました");

    }

    protected function prepare(): void {
        $this->setPermission("thewarp.commands.thewarp");
        $this->registerArgument(0, new RawStringArgument("name"));
        $this->registerSubCommand(new TheWarpListCommand());
    }
}
