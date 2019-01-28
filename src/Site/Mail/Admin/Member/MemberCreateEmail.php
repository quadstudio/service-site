<?php

namespace QuadStudio\Service\Site\Mail\Admin\Member;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use QuadStudio\Service\Site\Models\Member;

class MemberCreateEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Member
     */
    public $member;

    /**
     * Create a new message instance.
     * @param Member $member
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Оставлена новая ' . trans('site::member.help.member'))
            ->view('site::email.admin.member.create');
    }
}
