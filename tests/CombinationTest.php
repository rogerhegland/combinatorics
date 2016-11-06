<?php

use Combinatorics\Combination;

class CombinationTest extends PHPUnit_Framework_TestCase
{
    /** @var Combination */
    private $combination;

    protected function setUp()
    {
        $this->combination = new Combination();
    }

    /** @test */
    public function combination_of_1_character_with_size_1_returns_array_with_1_entry()
    {
        $this->combination->setCharacters('a');
        $this->combination->setSize(1);

        $result = $this->combination->get();
        $this->assertEquals(1, count($result));
        $this->assertEquals([ 'a' ], $result);
    }

    /** @test */
    public function combination_of_1_character_with_size_4_returns_array_with_1_entry()
    {
        $this->combination->setCharacters('a');
        $this->combination->setSize(4);

        $result = $this->combination->get();
        $this->assertEquals(1, count($result));
        $this->assertEquals([ 'aaaa' ], $result);
    }

    /** @test */
    public function combination_of_2_characters_with_size_1_returns_array_with_2_entries()
    {
        $this->combination->setCharacters('ab');
        $this->combination->setSize(1);

        $result = $this->combination->get();
        $this->assertEquals(2, count($result));
        $this->assertEquals([ 'a', 'b' ], $result);
    }

    /** @test */
    public function combination_of_2_characters_with_size_2_returns_array_with_4_entries()
    {
        $this->combination->setCharacters('ab');
        $this->combination->setSize(2);

        $result = $this->combination->get();
        $this->assertEquals(4, count($result));
        $this->assertEquals([ 'aa', 'ab', 'ba', 'bb' ], $result);
    }

    /** @test */
    public function combination_of_4_characters_with_size_5_returns_array_with_1024_entries()
    {
        $this->combination->setCharacters('at3w');
        $this->combination->setSize(5);

        $result = $this->combination->get();
        $result = array_filter($result);
        $this->assertEquals(1024, count($result));
    }

    /** @test */
    public function combination_of_8_characters_with_size_3_returns_array_with_512_entries()
    {
        $this->combination->setCharacters('1876rodj');
        $this->combination->setSize(3);

        $result = $this->combination->get();
        $result = array_filter($result);
        $this->assertEquals(512, count($result));
    }

    /** @test */
    public function combination_of_36_characters_with_size_3_returns_array_with_46656_entries()
    {
        $this->combination->setCharacters('abcdefghijklmnopqrstuvwxyz0123456789');
        $this->combination->setSize(3);

        $result = $this->combination->get();
        $result = array_filter($result);
        $this->assertEquals(46656, count($result));
        $this->assertTrue(in_array('2mi', $result));
    }

    /** @test */
    public function combination_fetch_of_2_characters_with_size_2_fetch_4_entries()
    {
        $this->combination->setCharacters('th');
        $this->combination->setSize(2);

        $combinations = [];
        while (( $combination = $this->combination->next() ) !== false) {
            $combinations[] = $combination;
        }

        $this->assertEquals(4, count($combinations));
        $this->assertEquals([ 'tt', 'th', 'ht', 'hh' ], $combinations);
    }
}