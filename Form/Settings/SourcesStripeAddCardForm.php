<?php

namespace Softspring\CustomerBundle\Form\Settings;

use Softspring\CustomerBundle\Manager\SourceManagerInterface;
use Softspring\CustomerBundle\Model\SourceAliasedInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class SourcesStripeAddCardForm extends AbstractType
{
    /**
     * @var SourceManagerInterface
     */
    protected $sourceManager;

    /**
     * SourcesStripeAddCardForm constructor.
     *
     * @param SourceManagerInterface $sourceManager
     */
    public function __construct(SourceManagerInterface $sourceManager)
    {
        $this->sourceManager = $sourceManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->sourceManager->getEntityClassReflection()->implementsInterface(SourceAliasedInterface::class)) {
            $builder->add('alias');
        }

        $builder->add('stripeToken', HiddenType::class);
        $builder->add('setDefault', CheckboxType::class, [
            'required' => false,
        ]);
    }
}