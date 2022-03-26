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
