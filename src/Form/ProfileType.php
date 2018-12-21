<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType

{
    public function buildForm(FormBuilderInterface $builder, array $options)

    {
        $builder
            ->add('email',null, array('attr'=> array('class'=>'form-control')))
            ->add('name',null, array('attr'=> array('class'=>'form-control')))
            ->add('surname',null, array('attr'=> array('class'=>'form-control')))
            ->add('username',null, array('attr'=> array('class'=>'form-control')))
            ->add('phone',null, array('attr'=> array('class'=>'form-control')))
            ->add('disable',null,array('attr'=> array('class'=>'form-control')));
    }

}