<?php

namespace App\Repository;

use App\Entity\Personne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    /**
     * @return Personne[] Returns an array of Personne objects
     */
    public function search($codeRegion,$codePrefecture,$codeCommune,$codeVille,$codeCamp)
    {
        $params = [];
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.position', 'ASC')
        ;
        if(isset($codeCamp) && !empty($codeCamp)){
            $qb->join("p.campAffectation", "camp")
                ->andWhere("camp.code = :codeCamp")
            ;
            $params["codeCamp"] = $codeCamp;
        }else if(isset($codeVille) && !empty($codeVille)){
            $qb->join("p.campAffectation", "camp")
                ->join("camp.ville", "v")
                ->andWhere("v.code = :codeVille")
            ;
            $params["codeVille"] = $codeVille;
        } else if(isset($codeCommune) && !empty($codeCommune)){
            $qb->join("p.campAffectation", "camp")
                ->join("camp.ville", "v")
                ->join("v.commune", "c")
                ->andWhere("c.code = :codeCommune")
            ;
            $params["codeCommune"] = $codeCommune;
        }else if(isset($codePrefecture) && !empty($codePrefecture)){
            $qb->join("p.campAffectation", "camp")
                ->join("camp.ville", "v")
                ->join("v.commune", "c")
                ->join("c.prefecture", "pr")
                ->andWhere("pr.code = :codePrefecture")
            ;
            $params["codePrefecture"] = $codePrefecture;
        }else if(isset($codeRegion) && !empty($codeRegion)){
            $qb->join("p.campAffectation", "camp")
                ->join("camp.ville", "v")
                ->join("v.commune", "c")
                ->join("c.prefecture", "pr")
                ->join("pr.region", "r")
                ->andWhere("r.code = :codeRegion")
            ;
            $params["codeRegion"] = $codeRegion;
        }

        $qb->setParameters($params);

        return $qb->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Personne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
