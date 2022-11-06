<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Pilih Tanggal',
                'data' => new \DateTime,
                'attr' => array(
                    'class' =>  'form-control',
                ),
            ],)
            ->add('changeDate', SubmitType::class, ['label' => 'Ubah Tanggal', 'attr' => array(
                'class' =>  'btn btn-primary mt-4',

            ),])
            ->add('print', SubmitType::class, ['label' => 'Cetak PDF', 'attr' => array(
                'class' =>  'btn btn-warning mt-4',

            ),]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }


}
