<?php
declare(strict_types=1);

namespace tatchan\thewarp\commands;

use CortexPE\Commando\args\BooleanArgument;
use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\args\Vector3Argument;
use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\Position;
use tatchan\thewarp\Utils;
use tatchan\theWarp\WarpPoint;
use tatchan\theWarp\WarpPointPool;

class TheWarpAddCommand extends BaseSubCommand {
    public function __construct() {
        parent::__construct("add", "ワープを追加する", ["a"]);
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        if ($sender->hasPermission("thewarp.add")) {
            if (array_key_exists("position", $args) && array_key_exists("world", $args)) {
                if (($world = Utils::getWorldByNameWithLoad($args["world"])) === null) {
                    $sender->sendMessage(TextFormat::RED . "{$args["world"]}は存在しませんでした");
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
            $sender->sendMessage(TextFormat::GREEN . "{$args["name"]}を作成しました");
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
