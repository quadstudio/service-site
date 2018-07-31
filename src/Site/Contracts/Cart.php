<?php

namespace QuadStudio\Service\Site\Contracts;

interface Cart
{

    function add(array $item);

    function update(array $item);

    function items();

    function has($id);

    function get($id);

    function total();

    function weight();

    function quantity();

    function count();

    function remove($id);

    function clear();
}