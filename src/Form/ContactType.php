<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Profil;
use App\Entity\TypeContact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value')
            ->add('profil', EntityType::class, [
                'class' => Profil::class,
'choice_label' => 'id',
            ])
            ->add('type', EntityType::class, [
                'class' => TypeContact::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
