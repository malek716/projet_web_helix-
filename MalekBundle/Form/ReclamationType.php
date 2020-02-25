<?php

namespace MalekBundle\Form;

use MalekBundle\Entity\Categorie;
use ReclamationBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('designation', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin:15px')))
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'type',])
            ->add('save', SubmitType::class, array('label' => 'Ajouter Reclamation', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin:15px')));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MalekBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'malekbundle_reclamation';
    }


}
