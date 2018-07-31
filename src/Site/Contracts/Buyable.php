<?php

namespace QuadStudio\Service\Site\Contracts;

interface Buyable
{
    function quantity();
    function weight();
    function subtotal();
}