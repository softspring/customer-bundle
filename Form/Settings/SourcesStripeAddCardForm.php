<?php

namespace Softspring\CustomerBundle\Form\Settings;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class SourcesStripeAddCardForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('stripeToken', HiddenType::class);
        $builder->add('setDefault', CheckboxType::class, [
            'required' => false,
        ]);
    }
}