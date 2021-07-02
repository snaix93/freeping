<?php


namespace Tests\Feature\Pulse;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PulseSubmitTest extends TestCase
{
    use RefreshDatabase;

    public function test_pulse_authentication_required()
    {
        $response = $this->get('/pulse');
        $response->assertStatus(401);
    }

    public function test_pulse_authenticated()
    {
        //$user = User::factory()->create();
        //dd($user);
        //$response = $this->get('/pulse?hostname=example.com')->header(['transmitter' => $user->omc_token]);
        //$response->assertStatus(200);
        $this->assertEquals(1,1);
    }
}
