<?php

namespace QuadStudio\Service\Site\Contracts;

interface Addressable
{
    function path();

    function lang();

    function getKey();
}