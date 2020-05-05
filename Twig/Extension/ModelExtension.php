<?php

namespace Softspring\CustomerBundle\Twig\Extension;

use Softspring\CustomerBundle\Manager\CustomerManagerInterface;
use Softspring\CustomerBundle\Manager\SourceManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ModelExtension extends AbstractExtension
{
    /**
     * @var CustomerManagerInterface|null
     */
    protected $customerManager;

    /**
     * @var SourceManagerInterface|null
     */
    protected $sourceManager;

    /**
     * ModelExtension constructor.
     *
     * @param CustomerManagerInterface|null $customerManager
     * @param SourceManagerInterface|null   $sourceManager
     */
    public function __construct(?CustomerManagerInterface $customerManager, ?SourceManagerInterface $sourceManager)
    {
        $this->customerManager = $customerManager;
        $this->sourceManager = $sourceManager;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('sfs_customer_is', [$this, 'customerCheckInterface']),
            new TwigFunction('sfs_source_is', [$this, 'sourceCheckInterface']),
        ];
    }

    public function customerCheckInterface(string $interface): bool
    {
        if (!$this->customerManager instanceof CustomerManagerInterface) {
            return false;
        }

        return $this->checkImplements($this->customerManager->getEntityClassReflection(), $interface);
    }

    public function sourceCheckInterface(string $interface): bool
    {
        if (!$this->sourceManager instanceof SourceManagerInterface) {
            return false;
        }

        return $this->checkImplements($this->sourceManager->getEntityClassReflection(), $interface);
    }

    protected function checkImplements(\ReflectionClass $reflectionClass, string $interface): bool
    {
        $interface = ucfirst($interface);

        $options = [
            "Softspring\\CustomerBundle\\Model\\{$interface}Interface", // if string is "NameSurname" (partial model name)
            "Softspring\\CustomerBundle\\Model\\Customer{$interface}Interface",
            "Softspring\\CustomerBundle\\Model\\Source{$interface}Interface",
            "Softspring\\CustomerBundle\\Model\\{$interface}", // if string is "NameSurnameInterface" (model name)
            $interface, // if string is "Softspring\\CustomerBundle\\Model\\NameSurnameInterface" (fully qualified name)
        ];

        foreach ($options as $option) {
            if (interface_exists($option) && $reflectionClass->implementsInterface($option)) {
                return true;
            }
        }

        return false;
    }
}