<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email de l\'utilisateur',
            ])
        ;
        if ($options['mode'] != 'edit') {
            $builder
                ->add('password', RepeatedType::class, [
                    'type'           => PasswordType::class,
                    'first_options'  => [
                        'label' => 'Le mot de passe',
                    ],
                    'second_options' => [
                        'label' => 'Repetez le mot de passe',
                    ],
                ]);
        }
        $builder
            ->add('money', IntegerType::class, [
                'label' => 'Argent',
            ])
            ->add('alive', CheckboxType::class, [
                'label'    => 'Vivant',
                'required' => false,
            ])
            ->add('enabled', CheckboxType::class, [
                'label'    => 'Activé',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\User',
            'mode'       => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }

}