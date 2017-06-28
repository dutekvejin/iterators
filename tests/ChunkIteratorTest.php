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

use Dutek\Iterator\ChunkIterator;
use PHPUnit\Framework\TestCase;

/**
 * @author Dusan Vejin <dutekvejin@gmail.com>
 */
class ChunkIteratorTest extends TestCase
{

    /**
     * @dataProvider dataProvider
     */
    public function test(array $input, int $size, array $expected)
    {
        $chunkIterator = new ChunkIterator(new \ArrayIterator($input), $size);
        $chunkIterator->rewind();

        foreach ($expected as $chunk) {
            $this->assertTrue($chunkIterator->valid());
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
        ];
    }
}
