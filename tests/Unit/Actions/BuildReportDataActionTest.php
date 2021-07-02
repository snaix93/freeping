<?php

namespace Tests\Unit\Actions;

use App\Actions\BuildReportDataAction;
use App\Collections\ReportDataCollection;
use App\Data\Target\TargetReportStats;
use App\Models\Node;
use App\Models\PingStats;
use App\Models\Target;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\WithoutEvents;
use Tests\TestCase;

class BuildReportDataActionTest extends TestCase
{
    use WithoutEvents;

    /** @test */
    public function will_build_report_data_for_targets_with_ping_stats_dated_yesterday()
    {
        $user = $this->getUser();

        $collection = resolve(BuildReportDataAction::class)($user);

        $this->assertInstanceOf(ReportDataCollection::class, $collection);
        $this->assertCount(2, $collection);
    }

    /** @test */
    public function will_correctly_calculate_success_rate_for_all_target_results()
    {
        $user = $this->getUser();

        $collection = resolve(BuildReportDataAction::class)($user);

        $firstResult = $collection[0];
        $secondResult = $collection[1];

        foreach ($firstResult->stats as $stat) {
            $this->assertInstanceOf(TargetReportStats::class, $stat);
            $this->assertEquals('50%', $stat->successRate);
        }

        foreach ($secondResult->stats as $stat) {
            $this->assertInstanceOf(TargetReportStats::class, $stat);
            $this->assertEquals('50%', $stat->successRate);
        }
    }

    private function getUser(): User
    {
        return User::factory()
            ->has(Target::factory()->has(
                PingStats::factory()
                    ->state(fn(array $attributes, Target $target) => [
                        'connect'   => $target->connect,
                        'datestamp' => now()->subDay(),
                        'successes' => 50,
                        'failures'  => 25,
                        'errors'    => 25,
                    ])
                    ->state(new Sequence(
                        ...Node::pluck('id')->map(fn($id) => ['node_id' => $id])
                    ))
                    ->count(Node::count())
            )->count(2))
            ->create();
    }
}
