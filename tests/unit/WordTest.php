<?php
namespace WordSelectorApp\Test;

use WordSelector\Entity\DoctrineWord;

class WordTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testWordSelector()
    {

        $text = 'TEST';
        $lang = 'en';
        $word = new DoctrineWord(3, $text, $lang);

        $this->assertEquals(3, $word->getId());
        $this->assertEquals($text, $word->getWord());
        $this->assertEquals($lang, $word->getLang());
        $this->assertEquals(4, $word->getLength());
        $this->assertEquals(3, $word->getNbLetters());
        $this->assertEquals(27/16, $word->getComplexity());
    }

    /**
     * @test
     */
    public function testSerialize()
    {
        $text = 'TEST';
        $lang = 'en';

        $word = new DoctrineWord(3, $text, $lang);

        $ref = json_encode([
            'word' => $text,
            'lang' => $lang,
            'length' => 4,
            'complexity' => 27/16
        ]);

        $this->assertEquals($ref, json_encode($word));
    }
}
