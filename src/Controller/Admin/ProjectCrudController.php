<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
    
}
