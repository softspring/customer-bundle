<?php

namespace Softspring\CustomerBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Softspring\CustomerBundle\Model\CustomerSourcesTrait as CustomerSourcesTraitModel;
use Softspring\CustomerBundle\Model\SourceInterface;

trait CustomerSourcesTrait
{
    use CustomerSourcesTraitModel;

    /**
     * @var SourceInterface[]|Collection
     * @ORM\OneToMany(targetEntity="Softspring\CustomerBundle\Model\SourceInterface", mappedBy="customer", cascade={"all"})
     */
    protected $sources;

    /**
     * @var SourceInterface
     * @ORM\ManyToOne(targetEntity="Softspring\CustomerBundle\Model\SourceInterface")
     * @ORM\JoinColumn(name="default_source_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $defaultSource;
}