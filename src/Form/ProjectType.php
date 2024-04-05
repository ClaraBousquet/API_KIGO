<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Project;
use App\Entity\Skills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('filliaire')
            ->add('created_at')
            ->add('is_active')
            ->add('is_over')
            ->add('post', EntityType::class, [
                'class' => Post::class,
'choice_label' => 'id',
            ])
            ->add('skill', EntityType::class, [
                'class' => Skills::class,
'choice_label' => 'id',
'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
