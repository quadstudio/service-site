<dt class="col-sm-6 text-left text-sm-right">@lang('site::mounting.bonus')</dt>
<dd class="col-sm-6">{{ Site::format($act->contents->sum('bonus')) }}</dd>

<dt class="col-sm-6 text-left text-sm-right">@lang('site::mounting.social_bonus')</dt>
<dd class="col-sm-6">{{ Site::format($act->contents->sum('enabled_social_bonus')) }}</dd>
