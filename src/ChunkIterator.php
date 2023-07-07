<?php
/**
 * This file is part of the iterators package.
 *
 * Copyright (c) Dusan Vejin
 *
 * For full copyright and license information, please refer to the LICENSE file,
 * located at the package root folder.
 */

declare(strict_types=1);

namespace Dutek\Iterator;

use ArrayIterator;
use Iterator;

final class ChunkIterator implements Iterator
{
    protected $iterator;
    protected $size;
    protected $chunk;
    protected $position;

    public function __construct(iterable $iterable, int $size = null)
    {
        if (is_array($iterable)) {
            $iterable = new ArrayIterator($iterable);
        }

        $this->iterator = $iterable;
        $this->size = $size ?? 1;
    }

    public function current()
    {
        return $this->chunk;
    }

    public function next(): void
    {
        $this->chunk = [];
        $this->position++;

        for ($i = 0; $i < $this->size && $this->iterator->valid(); $i++) {
            $this->chunk[] = $this->iterator->current();
            $this->iterator->next();
        }
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return (bool)$this->chunk;
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
        $this->position = -1;
        $this->next();
    }
}
