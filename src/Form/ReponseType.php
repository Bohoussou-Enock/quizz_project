<?php

namespace App\Form;

use App\Entity\Proposition;
use App\Entity\Question;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('note')
            ->add('question', EntityType::class, [
                "class" => Question::class,
                "choice_label" => 'label'
            ])
            ->add('proposition', EntityType::class, [
                "class" => Proposition::class,
                "choice_label" => 'label'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
