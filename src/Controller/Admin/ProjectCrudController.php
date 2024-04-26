<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProjectCrudController extends AbstractCrudController
{

    // Création des constantes
public const PROJECT_BASE_PATH = 'public/images';
public const PROJECT_UPLOAD_DIR = 'public/images';


    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
            TextField::new('filliaire'),
            TextField::new('statut'),
            ImageField::new('image_path', 'Image du projet')
                ->setBasePath(self::PROJECT_BASE_PATH)
                ->setUploadDir(self::PROJECT_UPLOAD_DIR)
                ->setUploadedFileNamePattern(
                    //on donne un nom de fichier unique à l'image
                    fn (UploadedFile $file): string => sprintf(
                        'upload_%d_%s.%s',
                        random_int(1, 999),
                        $file->getFilename(),
                        $file->guessExtension()
                    )
                ),
        ];
    }

public function configureActions(Actions $actions): Actions
{
    // Permet de configurer les différentes actions
    return $actions
        // Permet de customiser les champs de la page index
        ->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action) {
            return $action->setIcon('fa fa-add')->setLabel('Ajouter')->setCssClass('btn btn-success');
        })
        ->update(Crud::PAGE_INDEX, Action::EDIT, function(Action $action) {
            return $action->setIcon('fa fa-pen')->setLabel('Modifier');
        })
        ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action) {
            return $action->setIcon('fa fa-trash')->setLabel('Supprimer');
        })
        // Page édition
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function(Action $action) {
            return $action->setLabel('Enregistrer et quitter');
        })
        ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function(Action $action) {
            return $action->setLabel('Enregistrer et continuer');
        })
        // Page création
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function(Action $action) {
            return $action->setLabel('Enregistrer');
        })
        ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function(Action $action) {
            return $action->setLabel('Enregistrer et ajouter un nouveau');
        });
}
    
}
