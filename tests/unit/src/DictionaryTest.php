<?php

use G4\ValueObject\Dictionary;
use G4\ValueObject\Exception\InvalidDictionaryException;

class DictionaryTest extends \PHPUnit_Framework_TestCase
{


    public function testWithEmptyArray()
    {
        $this->expectException(InvalidDictionaryException::class);
        new Dictionary([]);
    }

    public function testHas()
    {
        $aDictianary = new Dictionary(['a' => 'a path']);
        $this->assertFalse($aDictianary->has('b'));
        $this->assertTrue($aDictianary->has('a'));
    }

    public function testHasInDeeperLevels()
    {
        $data = [
            'a' => [
                'b' => [
                    'c' => 'path'
                ]
            ]
        ];
        $aDictionary = new Dictionary($data);

        $this->assertTrue($aDictionary->hasInDeeperLevels('a'));
        $this->assertTrue($aDictionary->hasInDeeperLevels('a', 'b'));
        $this->assertTrue($aDictionary->hasInDeeperLevels('a', 'b', 'c'));

        $this->assertFalse($aDictionary->hasInDeeperLevels('f', 'b', 'c'));
        $this->assertFalse($aDictionary->hasInDeeperLevels('a', 'f', 'c'));
        $this->assertFalse($aDictionary->hasInDeeperLevels('a', 'b', 'f'));
        $this->assertFalse($aDictionary->hasInDeeperLevels('a', 'b', 'c', 'f'));
    }

    public function testGet()
    {
        $aDictionary = new Dictionary(['a' => 'a path']);
        $this->assertEquals('a path', $aDictionary->get('a'));
        $this->assertNull($aDictionary->get('b'));
    }

    public function testGetFromDeeperLevels()
    {
        $data = [
            'a' => [
                'b' => [
                    'c' => 'path'
                ]
            ]
        ];
        $aDictionary = new Dictionary($data);

        $this->assertEquals($data['a'], $aDictionary->getFromDeeperLevels('a'));
        $this->assertEquals($data['a']['b'], $aDictionary->getFromDeeperLevels('a', 'b'));
        $this->assertEquals($data['a']['b']['c'], $aDictionary->getFromDeeperLevels('a', 'b', 'c'));

        $this->assertNull($aDictionary->getFromDeeperLevels('f', 'b'));
        $this->assertNull($aDictionary->getFromDeeperLevels('a', 'f', 'c'));
        $this->assertNull($aDictionary->getFromDeeperLevels('a', 'b', 'f'));
        $this->assertNull($aDictionary->getFromDeeperLevels('a', 'b', 'c', 'f'));
    }

    public function testGetAll()
    {
        $this->assertEquals(['key' => 'value'], (new Dictionary(['key' => 'value']))->getAll());
    }

    public function testHasKeys()
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2',
            'key3' => 'value3',
        ];
        $aDictionary = new Dictionary($data);
        $this->assertTrue($aDictionary->hasKeys(['key1','key2','key3']));
        $this->assertFalse($aDictionary->hasKeys(['key432','key342','key5487']));
    }
}