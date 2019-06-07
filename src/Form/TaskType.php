<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'Исполнитель',
                'choice_label' => 'username',
                'attr'  => [
                    'style' => 'width:400px',
                ],
                'help' => 'Выберите исполнителя',
                'translation_domain' => false,
            ])
            ->add('content', TextareaType::class, [
                'attr'  => [
                    'style' => 'width:400px',
                    'rows'  => 5,
                ],
                'label' => 'Текст',
                'help'  => 'Добавьте сюда текст задания',
                'translation_domain' => false,
            ])
            ->add('status', CheckboxType::class, [
                'label'    => 'Статус выполнения',
                'required' => false,
                'translation_domain' => false,
            ])
        ;
    }


    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
