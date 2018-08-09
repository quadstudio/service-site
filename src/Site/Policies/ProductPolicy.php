<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\Product;
use QuadStudio\Service\Site\Models\User;

class ProductPolicy
{

    /**
     * Determine whether the user can view the post.
     *
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function view(User $user, Product $product)
    {
        return $user->getAttribute('admin') == 1;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->getAttribute('admin') == 1;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  User $user
     * @param  Product $product
     * @return bool
     */
    public function update(User $user, Product $product)
    {
        return $user->getAttribute('admin') == 1;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  User $user
     * @param  Product $product
     * @return bool
     */
    public function delete(User $user, Product $product)
    {
        return false;
    }


}
