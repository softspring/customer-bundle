<?php

namespace Softspring\CustomerBundle\Model;

abstract class Customer implements CustomerInterface
{
    use CustomerTaxIdTrait;
}