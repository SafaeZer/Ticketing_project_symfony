<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticket_type', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'Demande' => 'demande',
                        'Incident'     => 'incident',
                    ],
                ],
            ])
            ->add('category', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'Licence logiciel' => 'licence logiciel',
                        'Material'     => 'material',
                        'Access'    => 'access',
                    ],
                ],
            ])
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('files', FileType::class)
            ->add('created_date', DateTimeType::class)
            ->add('updated_date', DateTimeType::class)
            ->add('status', CollectionType::class, [
                'entry_type'   => ChoiceType::class,
                'entry_options'  => [
                    'choices'  => [
                        'Moyen' => 'moyen',
                        'Urgent'     => 'urgent',
                        'Very urgent'    => 'very urgent',
                        'Low'    => 'low',
                        'Blocked' => 'blocked'
                    ],
                ],
            ])
            ->add('send', SubmitType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
