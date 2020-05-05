<?php

namespace Softspring\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\CustomerBundle\Model\SourceAliasedTrait as SourceAliasedTraitModel;

trait SourceAliasedTrait
{
    use SourceAliasedTraitModel;

    /**
     * @var string|null
     * @ORM\Column(name="alias", type="string", nullable=true)
     */
    protected $alias;
}