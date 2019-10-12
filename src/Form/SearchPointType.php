<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchPointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class)
            ->add('dateEnd', DateType::class)
            ->add('user', EntityType::class, ['class' => User::class, 'choice_label' => 'name'])
            ->add('save', SubmitType::class, ['label' => 'Fetch !!'])
            ->getForm();
    }
}
