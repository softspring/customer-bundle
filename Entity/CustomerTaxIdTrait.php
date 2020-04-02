<?php

namespace Softspring\CustomerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Softspring\CustomerBundle\Model\CustomerTaxIdTrait as CustomerTaxIdTraitModel;

trait CustomerTaxIdTrait
{
    use CustomerTaxIdTraitModel;

    /**
     * @var string|null
     * @ORM\Column(name="tax_id_number", type="string", nullable=true)
     */
    protected $taxIdNumber;

    /**
     * @var string|null
     * @ORM\Column(name="tax_id_country", type="string", length=2, nullable=true, options={"fixed":true})
     */
    protected $taxIdCountry;
}