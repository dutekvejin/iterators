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

/**
 * @author Dusan Vejin <dutekvejin@gmail.com>
 */
final class ChunkIterator implements \Iterator
{
    protected $iterator;
    protected $size;
    protected $chunk;

    public function __construct(\Iterator $iterator, int $size = null)
    {
        $this->iterator = $iterator;
        $this->size = $size ?? 1;
        $this->chunk = [];
    }

    public function current()
    {
        return $this->chunk;
    }

    public function next()
    {
        $this->chunk = [];

        for ($i = 0; $i < $this->size && $this->iterator->valid(); $i++) {
            $this->chunk[] = $this->iterator->current();
            $this->iterator->next();
        }
    }

    public function key()
    {
        return -1;
    }

    public function valid()
    {
        return (bool)$this->chunk;
    }

    public function rewind()
    {
        $this->iterator->rewind();
        $this->next();
    }
}
