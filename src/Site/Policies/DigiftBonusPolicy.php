<?php

namespace QuadStudio\Service\Site\Policies;

use QuadStudio\Service\Site\Models\DigiftBonus;
use QuadStudio\Service\Site\Models\User;

class DigiftBonusPolicy
{

	public function send(User $user, DigiftBonus $digiftBonus)
	{
		return $digiftBonus->getAttribute('sended') == 0 && $digiftBonus->getAttribute('blocked') == 0;
	}

	public function block(User $user, DigiftBonus $digiftBonus)
	{
		return $digiftBonus->getAttribute('blocked') == 0;
	}

}
