<?php
declare(strict_types=1);

namespace Brille24\CustomerOptionsPlugin\Form\Validator;


use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Constraint;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\CustomerOptionGroupInterface;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\Validator;
use Brille24\CustomerOptionsPlugin\Entity\CustomerOptions\ValidatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conditions', CollectionType::class, [
                'entry_type' => ConditionType::class,
                'entry_options' => [
                    'customerOptionGroup' => $options['customerOptionGroup'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => ['onChange' => '$(event.target).parentsUntil("form").parent().submit();'],
            ])
            ->add('constraints', CollectionType::class, [
                'entry_type' => ConditionType::class,
                'entry_options' => [
                    'data_class' => Constraint::class,
                    'customerOptionGroup' => $options['customerOptionGroup'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('errorMessage', TextType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Validator::class,
        ]);

        $resolver->setDefined('customerOptionGroup');
        $resolver->setAllowedTypes('customerOptionGroup', CustomerOptionGroupInterface::class);
    }

    public function getBlockPrefix()
    {
        return 'brille24_customer_options_plugin_validator';
    }
}