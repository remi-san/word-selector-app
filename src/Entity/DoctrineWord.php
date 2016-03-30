<?php

namespace WordSelector\Entity;

class DoctrineWord extends Word implements \JsonSerializable
{
    /**
     * @var int
     **/
    protected $id;

    /**
     * @var int
     */
    protected $nbLetters;

    /**
     * Constructor
     *
     * @param int    $id
     * @param string $word
     * @param string $lang
     */
    public function __construct($id, $word, $lang)
    {
        parent::__construct($word, $lang, null);
        $this->id = $id;
        $this->nbLetters = $this->nbLetters();
        $this->complexity = $this->complexity();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNbLetters()
    {
        return $this->nbLetters;
    }

    /**
     * Calculate the number of different letters in the word
     *
     * @return int
     */
    protected function nbLetters()
    {
        return count(array_unique(str_split($this->word)));
    }

    /**
     * Calculate the complexity of the word
     *
     * @return float
     */
    protected function complexity()
    {
        return (float) ($this->nbLetters*$this->nbLetters*$this->nbLetters)/($this->length*$this->length);
    }

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     *       which is a value of any type other than a resource.
     */
    public function jsonSerialize()
    {
        return [
            'word' => $this->word,
            'lang' => $this->lang,
            'length' => $this->length,
            'complexity' => $this->complexity
        ];
    }
}
