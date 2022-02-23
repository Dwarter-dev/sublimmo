<?php

namespace App\Repository;

use App\Entity\Maison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Maison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maison[]    findAll()
 * @method Maison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maison::class);
    }

    // /**
    //  * @return Maison[] Returns an array of Maison objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Maison
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

  /**
   * @return Maison[] Return an array of X Maison objects ordered by somes parameters insted id
   */
   public function search(int $rooms = 0, int $bedrooms = 0, int $surface = 0, int $budjet = 0)
   {
     return $this->createQueryBuilder('fls') // fls est un alias
      // on cherche un id supérieur à une certaine valeur
      ->andwhere('fls.rooms >= :rooms') // 1. si les rooms recherchés sont = ou supérieur à X
      ->andwhere('fls.bedrooms >= :bedrooms') // 2. si les bedrooms recherchés sont = ou supérieur  à X
      ->andwhere('fls.surface >= :surface') // 3. si les surfaces recherchés sont = ou supérieur à X
      ->andwhere('fls.price <= :budget') // 4. si le prix est = ou inférieur à X
      ->setParameter('rooms', $rooms)
      ->setParameter('bedrooms', $bedrooms) // On défini la valeur
      ->setParameter('surface', $surface)
      ->setParameter('budget', $price)
      ->orderBy('fls.id', 'ASC') // tri en ordre croissant
      ->getQuery() // requête
      ->getResult(); // résultats(s)
   }

   /**
    * @return Maison[] Returns an array of 6 Maison objects ordered by latest insted id
    */
    public function findLastSix()
    {
      return $this->createQueryBuilder('fls') // fls est un alias
      // ->andWhere('fls.surface->:val') // on cherche un id supérieur à une certaine valeur
      // ->setParameter('val',0) // on défini la valeur
      ->orderBy('fls.id', 'DESC') // tri en ordre décroissant
      ->setMaxResults(6) // sélectionne 6 résultats maximum
      ->getQuery() // requête
      ->getResult(); // résultats(s)
    }
   //  public function trouverDernierSix()
   //  {
   //    $bdd = $this->getEntityManager()->getConnexion();
   //    $req = $bdd->('SELECT * FROM maison ORDER BY id DESC LIMIT 6');
   //    $req->executeQuery();
   //    return $req->fetchAll(); // [Marche pas]
   //  }
}
