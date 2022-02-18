<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Ticket;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('responsible')
            ->add('responsible', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (UserRepository $er) use ($options) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles = :val')
                        ->setParameter('val', $options['responsible'])
                        ->orderBy('u.email', 'ASC');
                },

            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'responsible' => "[\"ROLE_SUPPORT\"]"
        ]);
    }
}
