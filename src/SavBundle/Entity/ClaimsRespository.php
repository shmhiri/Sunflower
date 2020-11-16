<?php
/**
 * Created by PhpStorm.
 * User: Marouan
 * Date: 4/16/2019
 * Time: 1:35 AM
 */

namespace SavBundle\Entity;

use SavBundle\Entity\Claims;



class ClaimsRespository
{

    public function findnewclaims()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM SavBundle:Claims c where
              c.Claim_Date > = CURRENT_DATE()");
        return $query->getResult();
    }
}