<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Ticket;
use App\Entity\TicketType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;



class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ticket_type', EntityType::class, [
                'class' => TicketType::class,
                'placeholder' => '-- select an option --',
                'choice_label'  => fn (TicketType $ticket_type) => $ticket_type->getName(),

            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'placeholder' => '-- select an option --',
                'choice_label'  => fn (Category $category) => $category->getName(),

            ])
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('files', FileType::class, [
                'label' => 'Upload File (PDF, Word, Image)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/msword',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid document (PDF, word, img',
                    ])
                ],
            ])

            ->add('priority', ChoiceType::class, [
                'placeholder' => '-- select an option --',
                'choices'  => [
                    'Very urgent' => 'very urgent',
                    'Urgent' => 'urgent',
                    'Medium' => 'medium',
                    'Low' => 'low',
                    'Blocking' => 'blocking'
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
