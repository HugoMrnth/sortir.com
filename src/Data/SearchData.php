<?php

namespace App\Data;

use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SearchData
{
    public $site;
    public $nomSortie = '';
    public $betweenDate;
    public $andDate;
    public $isOrganisateur = false;
    public $isInscrit = false;
    public $isNotInscrit = false;
    public $isPast = false;

    // Ajout d'une validation de surface
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Callback([
            'callback' => 'validateDates',
        ]));
    }

    public function validateDates(ExecutionContextInterface $context)
    {
        if (!empty($this->betweenDate) && empty($this->andDate)) {
            $context->buildViolation('La date de fin doit être renseignée si la date de début est remplie.')
                ->atPath('andDate')
                ->addViolation();
        }

        if (!empty($this->andDate) && empty($this->betweenDate)) {
            $context->buildViolation('La date de début doit être renseignée si la date de fin est remplie.')
                ->atPath('betweenDate')
                ->addViolation();
        }
    }

}