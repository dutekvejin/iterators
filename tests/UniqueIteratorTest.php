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

namespace Dutek\Iterator\Tests;

use ArrayIterator;
use Dutek\Iterator\ChunkIterator;
use Dutek\Iterator\UniqueIterator;
use PHPUnit\Framework\TestCase;

class UniqueIteratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param iterable $input
     * @param array $expected
     */
    public function test(iterable $input, array $expected)
    {
        $this->assertEqualsCanonicalizing($expected, iterator_to_array(new UniqueIterator($input)));
    }

    public function dataProvider()
    {
        return [
            [[1, 2, 3, 3, 4], [1, 2, 3, 4]],
            [[1, 2, 3, "3", 4, 4], [1, 2, 3, "3", 4]],
        ];
    }
}
