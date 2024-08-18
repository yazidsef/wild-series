<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Program;
use App\Entity\Actor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\HttpFoundation\File\File; 

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('synopsis')
            ->add('country')
            ->add('posterFile', VichFileType::class, [
                     'required' => false,
                     'allow_delete' => true, // not mandatory, default is true
                     'download_uri' => true, // not mandatory, default is true
                   ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
            ])
            ->add('actors', EntityType::class, [
                'class' => Actor::class,
                'choice_label' => 'firstname',
                'multiple' => true,
                'expanded'=>true
            ])
            ->add('poster', FileType::class, [
                'label' => 'Product Image',
                'mapped' => true,
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
