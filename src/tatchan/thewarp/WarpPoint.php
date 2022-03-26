<?php
declare(strict_types=1);

namespace tatchan\thewarp;

use pocketmine\permission\Permissible;
use pocketmine\world\Position;

class WarpPoint {

    public function __construct(private string $name, private Position $position, private bool $public) {
        $this->position = clone $this->position;
    }

    public function canWarp(Permissible $target): bool {
        return ($this->isPublic() && $target->hasPermission("thewarp.warp.public")) || (!$this->isPublic() && $target->hasPermission("thewarp.warp.private"));
    }

    public function getName(): string {
        return $this->name;
    }

    public function getPosition(): Position {
        return clone $this->position;
    }

    public function isPublic(): bool {
        return $this->public;
    }

    public function setPublic(bool $public): void {
        $this->public = $public;
    }

}
