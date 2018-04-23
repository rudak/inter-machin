<?php

namespace AppBundle\Form\Bank;

use AppBundle\Entity\Action\Saving;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SavingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $builder->getData()->getUser();
        $builder
            ->add('amount', IntegerType::class, [
                'data'  => 1,
                'label' => 'Placement',
                'attr'  => [
                    'min' => 1,
                    'max' => $user->getMoney(),
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Saving::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_bank_saving';
    }

}
