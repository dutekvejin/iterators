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
use PHPUnit\Framework\TestCase;

class ChunkIteratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param iterable $input
     * @param int $size
     * @param array $expected
     */
    public function test(iterable $input, int $size, array $expected)
    {
        $chunkIterator = new ChunkIterator($input, $size);
        $chunkIterator->rewind();

        foreach ($expected as $key => $chunk) {
            $this->assertTrue($chunkIterator->valid());
            $this->assertSame($key, $chunkIterator->key());
            $this->assertSame($chunkIterator->current(), $chunk);

            $chunkIterator->next();
        }

        $this->assertFalse($chunkIterator->valid());
    }

    public function dataProvider()
    {
        return [
            [[], 1, []],
            [[1, 2, 3], -1, []],
            [[1, 2, 3, 4, 5], 1, [[1], [2], [3], [4], [5]]],
            [[1, 2, 3, 4, 5, 6, 7, 8, 9, 10], 3, [[1, 2, 3], [4, 5, 6], [7, 8, 9], [10]]],
            [new ArrayIterator([1, 2, 3, 4, 5]), 4, [[1, 2, 3, 4], [5]]],
            [range(1, 5), 2, [[1, 2], [3, 4], [5]]],
        ];
    }
}
