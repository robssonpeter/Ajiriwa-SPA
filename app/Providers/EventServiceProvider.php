<?php

namespace App\Providers;

use App\Events\ApplicationStatusUpdated;
use App\Events\JobViewed;
use App\Events\ProfileUpdated;
use App\Listeners\RecordApplicationLog;
use App\Listeners\UpdateProfileCompletion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProfileUpdated::class => [
            UpdateProfileCompletion::class
        ],
        JobViewed::class => [
            RegisterView::class
        ],
        ApplicationStatusUpdated::class => [
            RecordApplicationLog::class
        ],
        \App\Events\ApplicationRejected::class => [
            \App\Listeners\SendRejectionEmail::class
        ],
        \App\Events\InterviewScheduled::class => [
            \App\Listeners\SendInterviewInvitationEmail::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
