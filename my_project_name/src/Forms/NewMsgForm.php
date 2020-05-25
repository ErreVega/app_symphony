<?php


namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class NewMsgForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('to', TextType::class, ['attr'=> ['class'=> 'form-control', 'placeholder'=> 'Para', 'required'=> 'true', 'autocomplete' => 'off']])
            ->add('subject', TextType::class, ['attr'=> ['class'=> 'form-control', 'placeholder'=> 'Asunto', 'required'=> 'true', 'autocomplete' => 'off']])
            ->add('msgbody', TextareaType::class, ['attr'=> ['class'=> 'md-textarea form-control', 'placeholder'=> 'Escriba su mensaje', 'autocomplete' => 'off']])
            ->add('attach', FileType::class, ['attr'=> ['class'=> 'btn btn-primary btn-sm m-2 p-2', 'multiple'=> 'multiple'],           'required' => false, 'multiple' => true,])
            ->add('Enviar', SubmitType::class, ['attr' => ['class'=> 'btn btn-primary btn-sm m-2 p-2']]);

    }

}