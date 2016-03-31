<?php

namespace WordSelectorApp\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WordSelector\WordSelector;

/**
 * Class WordController
 *
 * @package WordSelectorApp\Controller
 */
class WordController
{
    /**
     * @var WordSelector
     */
    private $wordSelector;

    public function __construct(WordSelector $wordSelector)
    {
        $this->wordSelector = $wordSelector;
    }

    public function random(Request $request)
    {
        $headers = [ 'Content-Type' => 'application/json' ];

        $length = $request->get('length', 5);
        $lang = $request->get('lang', 'en');
        $complexity = $request->get('complexity');

        $word = null;
        try {
            $word = $this->wordSelector->getRandomWord($length, $lang, $complexity);
        } catch (\InvalidArgumentException $e) {
            return new Response(json_encode([ 'error' => $e->getMessage() ]), Response::HTTP_NOT_FOUND, $headers);
        }

        return new Response(
            json_encode($word),
            Response::HTTP_OK,
            $headers
        );
    }
}
