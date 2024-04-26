<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\SkillRepository;
use App\Repository\SkillsRepository;
use App\Repository\FiliereRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{

    private $filiereRepository;
    private $skillRepository;

    public function __construct(FiliereRepository $filiereRepository, SkillsRepository $skillRepository)
    {
        $this->filiereRepository = $filiereRepository;
        $this->skillRepository = $skillRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $filieres = $this->filiereRepository->findAll();
        $skills = $this->skillRepository->findAll();

        // Formatte les filières pour les utiliser dans le menu déroulant
        $filiereChoices = [];
        foreach ($filieres as $filiere) {
            $filiereChoices[$filiere->getLabel()] = $filiere->getLabel();
        }

        // Formatte les compétences pour les utiliser dans le menu déroulant
        $skillChoices = [];
        foreach ($skills as $skill) {
            $skillChoices[$skill->getLabel()] = $skill->getLabel();
        }

        return [
            IdField::new('email'),
            TextField::new('password'),
            TextField::new('nickname'),
            TextField::new('biography'),
            ChoiceField::new('filiere')->setChoices($filiereChoices),
            ChoiceField::new('skills')->setChoices($skillChoices),
        ];
    }
}
