<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class WeaponType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'arme",

            ])
            ->add('attack', IntegerType::class, [
                'label' => 'Attaque LVL',
                'attr'  => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('defense', IntegerType::class, [
                'label' => 'Défense LVL',
                'attr'  => [
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('uses', IntegerType::class, [
                'label' => 'Utilisations Max',
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix',
                'attr'  => [
                    'min' => 0,
                    'max' => 99999,
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Weapon',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_weapon';
    }

}
