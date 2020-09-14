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
use FilterIterator;


final class UniqueIterator extends FilterIterator
{
    protected $seen = [];

    public function __construct(iterable $iterable)
    {
        if (is_array($iterable)) {
            $iterable = new ArrayIterator($iterable);
        }

        parent::__construct($iterable);
    }

    public function accept(): bool
    {
        $item = $this->getInnerIterator()->current();

        if (!in_array($item, $this->seen, true)) {
            $this->seen[] = $item;
            return true;
        }

        return false;
    }
}
