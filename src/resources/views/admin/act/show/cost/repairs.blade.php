<dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_distance')</dt>
<dd class="col-sm-6">{{ Site::format($act->contents->sum('total_distance_cost')) }}</dd>

<dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_difficulty')</dt>
<dd class="col-sm-6">{{ Site::format($act->contents->sum('total_difficulty_cost')) }}</dd>

<dt class="col-sm-6 text-left text-sm-right">@lang('site::repair.cost_parts')</dt>
<dd class="col-sm-6">{{ Site::format($act->contents->sum('total_cost_parts')) }}</dd>