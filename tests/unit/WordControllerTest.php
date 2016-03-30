<?php

namespace WordSelectorApp\Test;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WordSelector\WordSelector;
use WordSelectorApp\Controller\WordController;

class WordControllerTest extends \PHPUnit_Framework_TestCase
{
    /** @var WordSelector */
    private $wordSelector;

    /** @var Request */
    private $request;

    public function setUp()
    {
        $this->wordSelector = \Mockery::mock(WordSelector::class);
        $this->request = \Mockery::mock(Request::class);
    }

    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * @test
     */
    public function testWordSelectorWithParameters()
    {
        $this->request->shouldReceive('get')->with('length')->andReturn(1);
        $this->request->shouldReceive('get')->with('lang')->andReturn('fr');
        $this->request->shouldReceive('get')->with('complexity')->andReturn(5);

        $this->wordSelector
            ->shouldReceive('getRandomWord')
            ->with(1, 'fr', 5)
            ->andReturn('randomWord');

        $controller = new WordController($this->wordSelector);

        $response = $controller->random($this->request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(json_encode('randomWord'), $response->getContent());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function testWordSelectorNoParameters()
    {
        $this->request->shouldReceive('get')->andReturn(null);

        $this->wordSelector
            ->shouldReceive('getRandomWord')
            ->with(5, 'en', null)
            ->andReturn('randomWord');

        $controller = new WordController($this->wordSelector);

        $response = $controller->random($this->request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(json_encode('randomWord'), $response->getContent());
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }

    /**
     * @test
     */
    public function testWordSelectorWithError()
    {
        $this->request->shouldReceive('get')->andReturn(null);

        $this->wordSelector
            ->shouldReceive('getRandomWord')
            ->andThrow(new \InvalidArgumentException('ex-text'));

        $controller = new WordController($this->wordSelector);

        $response = $controller->random($this->request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(json_encode([ 'error' => 'ex-text' ]), $response->getContent());
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
    }
}
