<?php

namespace Ddd\Domain\Model;

interface ProductRepository
{
    public function find($aProductId);
    public function add(Product $aProduct);
}
