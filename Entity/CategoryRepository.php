<?php

namespace Xaben\ForumBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{

    public function findAllWithForums()
    {
        return $this->getEntityManager()
                    ->createQuery('SELECT c,f,p,du,bu
                        FROM XabenForumBundle:Category c
                        JOIN c.forums f
                        LEFT JOIN f.last_post p
                        LEFT JOIN p.poster du
                        LEFT JOIN du.baseuser bu
                        ORDER BY c.position ASC')
                    ->getArrayResult();
    }
}
