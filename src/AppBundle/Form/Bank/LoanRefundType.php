<?php

namespace AppBundle\Form\Bank;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class LoanRefundType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // ($builder->getData() = Loan)
        $availableMoney = $builder->getData()->getUser()->getMoney();
        $restToPay      = $builder->getData()->getRestToPay();
        $max            = $restToPay > $availableMoney ? $availableMoney : $restToPay;
        $builder
            ->add('money', IntegerType::class, [
                'label'       => 'Montant',
                'mapped'      => false,
                'data'        => 1,
                'constraints' => [new Range([
                    'min'        => 1,
                    'minMessage' => "Vous devez rembourser au moins {{ limit }}$ !",
                    'max'        => $max,
                    'maxMessage' => "Vous êtes limité à {{ limit }}$ !",
                ])],
                'attr'        => [
                    'min' => 1,
                    'max' => $max,
                ],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Bank\Loan',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_bank_loan';
    }

}
