<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\User;
use App\Entity\Vente;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VenteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_creation', DateType::class)
            ->add('user', EntityType::class, ['class' => User::class, 'choice_label' => 'name'])
            ->add('produit', EntityType::class, ['class' => Produit::class, 'choice_label' => 'titre'])
            ->add('quantity', IntegerType::class, array("mapped" => false))
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vente::class,
        ]);
    }
}
