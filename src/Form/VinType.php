<?php

namespace App\Form;

use App\Entity\Vin;
use App\Entity\Domaine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('grapes')
            ->add('description')
            ->add('photo',FileType::class, ['required'=>true])
            ->add('dom', EntityType::class, [
                'class' => Domaine::class,
                'choice_label' => 'name' 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vin::class,
        ]);
    }
}
