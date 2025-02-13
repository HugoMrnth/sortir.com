<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Sortie>
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * Retrieves sorties linked to a search
     * @return Sortie[]
     */
    public function findSearch(SearchData $data, UserInterface $user): array
    {
        $query = $this
            ->createQueryBuilder('s')
            ->select('s');

        if(!empty($data->site)){
            $query = $query
                ->andWhere('s.site = :site')
                ->setParameter('site', $data->site);
        }

        if(!empty($data->nomSortie)){
            $query = $query
                ->andWhere('s.nom LIKE :nom')
                ->setParameter('nom', '%'.$data->nomSortie.'%');
        }

        if(!empty($data->betweenDate) && !empty($data->andDate)){
            $query = $query
                ->andWhere('s.dateDebut BETWEEN :betweenDate AND :andDate')
                ->setParameter('betweenDate', $data->betweenDate)
                ->setParameter('andDate', $data->andDate);
        }

        if($data->isOrganisateur){
            $query = $query
                ->andWhere('s.organisateur = :user')
                ->setParameter('user', $user);
        }

        if($data->isInscrit){
            $query = $query
                ->join('s.participants', 'p')
                ->andWhere('p = :user')
                ->setParameter('user', $user);
        }

        if($data->isNotInscrit){
            $subQuery = $this->createQueryBuilder('sub')
                ->select('sub.id')
                ->join('sub.participants', 'p')
                ->where('p = :user');

            $query = $query
                ->andWhere($query->expr()->notIn('s.id', $subQuery->getDQL()))
                ->setParameter('user', $user);
        }

        if($data->isPast){
            $query = $query
                ->join('s.etat', 'e')
                ->andWhere('e.libelle = :etatTerminee')
                ->setParameter('etatTerminee', 'Terminée');
        }


        return $query->getQuery()->getResult();
    }


}
