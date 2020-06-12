<?php

namespace App\Form;

use App\Entity\History;
use App\Entity\Participant;
use App\Entity\Proposition;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('participant', EntityType::class, [
                'class' => Participant::class,
                'choice_label' => 'nom'
            ])
            ->add('question', EntityType::class, [
                'class' => Question::class,
                'choice_label' => 'label'
            ])
            ->add('proposition', EntityType::class, [
                'class' => Proposition::class,
                'choice_label' => 'label'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => History::class,
        ]);
    }
}
