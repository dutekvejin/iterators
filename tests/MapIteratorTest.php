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
use Dutek\Iterator\MapIterator;
use PHPUnit\Framework\TestCase;
use stdClass;

class MapIteratorTest extends TestCase
{

    /**
     * @dataProvider processCallableDataProvider
     *
     * @param iterable $input
     * @param callable $callable
     * @param array $expected
     */
    public function testProcessCallable(iterable $input, callable $callable, array $expected)
    {
        $mapIterator = new MapIterator($input, $callable);
        $mapIterator->rewind();

        foreach ($expected as $key => $chunk) {
            $this->assertTrue($mapIterator->valid());
            $this->assertSame($key, $mapIterator->key());
            $this->assertSame($mapIterator->current(), $chunk);

            $mapIterator->next();
        }

        $this->assertFalse($mapIterator->valid());
    }

    public function testIsCallableResultCached()
    {
        $callable = $this->createPartialMock(stdClass::class, ['__invoke']);
        $callable->expects($this->once())
            ->method('__invoke')
            ->willReturn(2);

        $mapIterator = new MapIterator([1], $callable);
        $mapIterator->rewind();

        for ($i = 0; $i < 2; $i++) {
            $this->assertSame(2, $mapIterator->current());
        }
    }

    public function processCallableDataProvider()
    {
        $callable = function (int $current) {
            return $current ** 2;
        };

        return [
            [[], $callable, []],
            [[1, 2, 3, 4], $callable, [1, 4, 9, 16]],
            [new ArrayIterator([3, 4]), $callable, [9, 16]],
            [range(1, 5), $callable, [1, 4, 9, 16, 25]],
        ];
    }
}
