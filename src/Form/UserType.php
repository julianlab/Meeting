<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label' => 'Nombre de usuario',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('name', TextType::class, array(
                'label' => 'Nombre',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Apellido',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('Guardar', SubmitType::class, [
                'label' => 'Guardar datos',
                'attr' => array('class'=>'btn')
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
