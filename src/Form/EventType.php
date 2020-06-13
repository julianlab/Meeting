<?php

namespace App\Form;

use App\Entity\Evento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titulo',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('municipioId', TextType::class, array(
                'label' => 'Municipio',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('fecha', DateType::class, array(
                'label' => 'Fecha',
                //'attr'=> array('class'=>'form-control')
            ))
            ->add('subscribers', IntegerType::class, array(
                'label' => 'Aforo máximo',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'attr'=> array('class'=>'form-control')
            ))
            ->add('tags', CollectionType::class, array(
                'label' => 'Tags',
                'attr'=> array('class'=>'form-control')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
