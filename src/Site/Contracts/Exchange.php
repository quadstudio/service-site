<?php

namespace QuadStudio\Service\Site\Contracts;

interface Exchange
{
    function get($id): array;

    function all(): array;
}