<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    function find3RecipeByCategory($category){
        return $this->createQueryBuilder('recipe')
            ->select('recipe')
            ->innerJoin('recipe.category','category')
            ->where('category.name=:category')
            ->orderBy('recipe.name','ASC')
            ->setMaxResults(3)
            ->setParameter('category',$category)
            ->getQuery()
            ->getResult();
    }

    function findRecipeByCategory($category){
        return $this->createQueryBuilder('recipe')
            ->select('recipe')
            ->innerJoin('recipe.category','category')
            ->where('category.name=:category')
            ->orderBy('recipe.name','ASC')
            ->setParameter('category',$category)
            ->getQuery()
            ->getResult();
    }
}
