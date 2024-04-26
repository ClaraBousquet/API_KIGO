<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Repository\SkillsRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PostCrudController extends AbstractCrudController
{

        private $skillRepository;


   public function __construct( SkillsRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $skills = $this->skillRepository->findAll();


 // Formatte les compétences pour les utiliser dans le menu déroulant
        $skillChoices = [];
        foreach ($skills as $skill) {
            $skillChoices[$skill->getLabel()] = $skill->getLabel();
        }
        return [
            TextField::new('title'),
            TextEditorField::new('content'),
            DateTimeField::new('Created_at'),
            ChoiceField::new('skills')
            ->setChoices($skillChoices) // Définit les compétences comme choix pour le champ
            ->setRequired(true) // Rend le champ obligatoire
            ->onlyOnForms() 

        ];
    }
    
}
