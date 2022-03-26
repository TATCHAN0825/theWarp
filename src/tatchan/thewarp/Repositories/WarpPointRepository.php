<?php
declare(strict_types=1);

namespace tatchan\thewarp\Repositories;

use tatchan\theWarp\WarpPoint;

interface WarpPointRepository {
    /**
     * @return WarpPoint[]
     */
    public function getAll(): array;

    /**
     * @param WarpPoint[] $warpPoints
     */
    public function storeAll(array $warpPoints): void;


    public function remove(string $name): void;

    public function save(): void;

}
