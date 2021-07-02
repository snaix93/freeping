<?php

namespace Tests\Unit\Actions;

use App\Actions\BuildReportDataAction;
use App\Actions\SendDailyReportAction;
use App\Collections\ReportDataCollection;
use App\Models\PingStats;
use App\Models\Target;
use App\Models\User;
use App\Notifications\DailyReportNotification;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendDailyReportActionTest extends TestCase
{
    use WithoutEvents;

    /** @test */
    public function will_notify_user_ping_stats_from_yesterday()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);

        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) use ($user) {
            $mock->shouldReceive('__invoke', $user)
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function wont_notify_unverified_users()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->unverified()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);

        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) use ($user) {
            $mock->shouldReceive('__invoke', $user)
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertNotSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function when_passing_user_will_scope_to_that_user_only()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);
        Target::factory()->for($user)->has(PingStats::factory())->create();

        $user2 = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);
        Target::factory()->for($user2)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)($user);

        Notification::assertSentTo($user, DailyReportNotification::class);
        Notification::assertNotSentTo($user2, DailyReportNotification::class);
    }

    /** @test */
    public function when_passing_user_will_ignore_signup_date()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => today(),
        ]);
        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)($user);

        Notification::assertSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function if_no_user_passed_then_will_exclude_users_who_signed_up_today()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => today(),
        ]);
        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertNotSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function wont_send_if_time_does_not_match_users_selected_report_time()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->subHour()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);
        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertNotSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function can_pass_send_now_flag_to_force_send_now_regardless_of_user_time()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->subHour()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);
        Target::factory()->for($user)->has(PingStats::factory())->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)(null, true);

        Notification::assertSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function wont_send_if_user_has_no_targets()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertNotSentTo($user, DailyReportNotification::class);
    }

    /** @test */
    public function wont_send_if_target_has_no_ping_results()
    {
        Notification::fake();
        Carbon::setTestNow($now = now());

        $user = User::factory()->create([
            'report_time_utc' => now()->floorHour()->format('H:i'),
            'created_at' => now()->subDay(),
        ]);
        Target::factory()->for($user)->create();

        $this->mock(BuildReportDataAction::class, function ($mock) {
            $mock->shouldReceive('__invoke')
                ->andReturn(ReportDataCollection::make());
        });

        resolve(SendDailyReportAction::class)();

        Notification::assertNotSentTo($user, DailyReportNotification::class);
    }
}
