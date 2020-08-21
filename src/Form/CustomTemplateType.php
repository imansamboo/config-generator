<?php

namespace App\Form;

use App\Entity\CustomTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('file_path')
            ->add('content')
            ->add('created_at')
            ->add('updated_at')
            ->add('need_restart')
            ->add('service_name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomTemplate::class,
        ]);
    }
}
