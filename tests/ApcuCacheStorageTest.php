<?php

declare(strict_types = 1);

namespace SR\ApcuSimpleCacheTest;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Exception as RunnerException;
use Psr\SimpleCache\InvalidArgumentException;
use SR\ApcuSimpleCache\ApcuCacheStorage;

/**
 * Class ApcuCacheStorageTest
 *
 * @package SR\ApcuSimpleCacheTest
 */
class ApcuCacheStorageTest extends TestCase
{
    private $cacheStorage;

    /**
     * ApcuCacheStorageTest constructor.
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        if (ini_get('apc.enable_cli') == 0) {
            throw new RunnerException('apc.enable_cli must be enabled for test');
        };

        if (ini_get('apc.use_request_time') == 1) {
            throw new RunnerException('apc.use_request_time must be disabled for test');
        };

        $this->cacheStorage = new ApcuCacheStorage();
        $this->cacheStorage->clear();

        parent::__construct($name, $data, $dataName);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testSetAndGet()
    {
        $mockString = 'String';
        $mockArray = [
            'a' => 1,
            'b' => 12312,
            'c' => 'Viva la revolution!'
        ];
        $mockObject = (object)$mockArray;

        $this->cacheStorage->set('object', $mockObject);
        $this->cacheStorage->set('array', $mockArray);
        $this->cacheStorage->set('string', $mockString);

        self::assertEquals($mockObject, $this->cacheStorage->get('object'), 'Object save error.');
        self::assertEquals($mockArray, $this->cacheStorage->get('array'), 'Array save error.');
        self::assertEquals($mockString, $this->cacheStorage->get('string'), 'String save error.');
    }

    /**
     * @throws InvalidArgumentException
     */
    public function testSetMultiple()
    {
        $multipleMock = [
            'a' => 1,
            'b' => [12312],
            'c' => (object)['Viva la revolution!']
        ];

        $this->cacheStorage->setMultiple($multipleMock);

        foreach ($multipleMock as $key => $value) {
            self::assertEquals($value, $this->cacheStorage->get($key));
        }
    }

    /**
     * @depends testSetMultiple
     *
     * @throws InvalidArgumentException
     */
    public function testHas()
    {
        $set = ['a' => 'b'];

        $this->cacheStorage->setMultiple($set);

        self::assertTrue($this->cacheStorage->has('a'));
        self::assertFalse($this->cacheStorage->has('b'));
    }

    /**
     * @depends testSetMultiple
     * @depends testSetAndGet
     * @depends testHas
     *
     * @throws InvalidArgumentException
     */
    public function testDeleteMultiple()
    {
        $multipleMock = [
            'a' => 1,
            'b' => [12312],
            'c' => (object)['Viva la revolution!']
        ];

        $this->cacheStorage->setMultiple($multipleMock);

        foreach ($multipleMock as $key => $value) {
            self::assertEquals($value, $this->cacheStorage->get($key));
        }

        $this->cacheStorage->deleteMultiple([
            'a',
            'c'
        ]);

        self::assertFalse($this->cacheStorage->has('a'));
        self::assertTrue($this->cacheStorage->has('b'));
        self::assertFalse($this->cacheStorage->has('c'));
    }

    /**
     * @depends testSetMultiple
     * @depends testHas
     *
     * @throws InvalidArgumentException
     */
    public function testDelete()
    {
        $multipleMock = [
            'a' => 1,
            'b' => [12312],
            'c' => (object)['Viva la revolution!']
        ];

        $this->cacheStorage->setMultiple($multipleMock);

        foreach ($multipleMock as $key => $value) {
            self::assertEquals($value, $this->cacheStorage->get($key));
        }

        $this->cacheStorage->delete('a');
        $this->cacheStorage->delete('b');


        self::assertFalse($this->cacheStorage->has('a'));
        self::assertFalse($this->cacheStorage->has('b'));
        self::assertTrue($this->cacheStorage->has('c'));
    }

    /**
     * @depends testSetMultiple
     * @depends testHas
     *
     * @throws InvalidArgumentException
     */
    public function testClear()
    {
        $multipleMock = [
            'a' => 'aaaaaaaa',
            'b' => [12312]
        ];

        $this->cacheStorage->setMultiple($multipleMock);

        $this->cacheStorage->clear();

        self::assertFalse($this->cacheStorage->has('a'));
        self::assertFalse($this->cacheStorage->has('b'));
    }

    /**
     * @depends testSetAndGet
     * @depends testHas
     *
     * @throws InvalidArgumentException
     */
    public function testTtl()
    {
        $this->cacheStorage->set('a', 123, 3);

        sleep(1);

        self::assertTrue($this->cacheStorage->has('a'));

        sleep(3);

        self::assertFalse($this->cacheStorage->has('a'));
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     *
     * Clear the storage.
     */
    protected function tearDown()
    {
        $this->cacheStorage->clear();
    }
}
