<?php

namespace Softspring\CustomerBundle\Form\Admin;

use Softspring\CustomerBundle\Model\CustomerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerCreateForm extends AbstractType implements CustomerCreateFormInterface
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CustomerInterface::class,
            'translation_domain' => 'sfs_customer',
            'label_format' => 'admin_customer.create.form.%name%.label',
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('taxIdNumber');
        $builder->add('taxIdCountry');
    }
}