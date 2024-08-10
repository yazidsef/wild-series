<?php

namespace App\Form;

use App\Entity\Episode;
use App\Entity\Season;
use App\Entity\WatchList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EpisodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('number')
            ->add('synonpsis')
            ->add('duration')
            ->add('season', EntityType::class, [
                'class' => Season::class,
                'choice_label' => 'id',
            ])
            ->add('watchList', EntityType::class, [
                'class' => WatchList::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Episode::class,
        ]);
    }
}
