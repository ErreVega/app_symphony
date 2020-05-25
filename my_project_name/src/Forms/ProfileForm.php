<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;



class ProfileForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, ['attr'=> ['class'=> 'form-control', 'required'=> 'true', 'autocomplete' => 'off']])
            ->add('address', TextType::class, ['attr'=> ['class'=> 'form-control', 'required'=> 'true', 'autocomplete' => 'off']])
            ->add('age', NumberType::class, ['attr'=> ['class'=> 'md-textarea form-control', 'autocomplete' => 'off']])
            ->add('avatar', FileType::class, ['attr'=> ['class'=> 'btn btn-primary btn-sm m-2 p-2'],  'required' => false])
            ->add('submit', SubmitType::class, ['attr' => ['class'=> 'btn btn-primary btn-sm m-2 p-2']]);

    }

}