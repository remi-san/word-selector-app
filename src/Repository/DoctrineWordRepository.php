<?php
namespace WordSelector\Repository;

use Doctrine\ORM\EntityRepository;
use WordSelector\Entity\DoctrineWord;

/**
 * @codeCoverageIgnore
 */
class DoctrineWordRepository extends EntityRepository implements WordRepository
{
    /**
     * Gets a random word of <length> characters for the <lang> language
     * <lang> must be an iso2 code in lower case
     *
     * @param  int    $length
     * @param  string $lang
     * @param  float  $complexity
     *
*@return DoctrineWord
     */
    public function getRandomWord($length, $lang, $complexity = null)
    {
        $dql  = 'SELECT w, RANDOM() as HIDDEN random ';
        $dql .= 'FROM '.$this->getClassName().' w ';
        $dql .= 'WHERE w.length = ?1 ';
        $dql .= 'AND w.lang = ?2 ';
        $dql .= 'ORDER BY random';

        return $this->getEntityManager()->createQuery($dql)
            ->setParameter(1, $length)
            ->setParameter(2, $lang)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }
}
