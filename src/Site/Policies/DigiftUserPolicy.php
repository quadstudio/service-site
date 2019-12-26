<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\DigiftUser;
use QuadStudio\Service\Site\Models\User;

class DigiftUserPolicy
{

	public function fullUrlToRedirect(User $user, DigiftUser $digiftUser)
	{
		return $user->getAttribute('active') == 1 && $digiftUser->balance > 0;
	}

	public function rollbackBalanceChange(User $user, DigiftUser $digiftUser)
	{
		return $user->getAttribute('active') == 1 && $digiftUser->exists() && $digiftUser->accruedDigiftBonuses()->exists();
	}

	public function refreshToken(User $user, DigiftUser $digiftUser)
	{
		return $user->getAttribute('active') == 1 && $digiftUser->exists();
	}

}
