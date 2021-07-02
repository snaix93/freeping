<?php /** @noinspection PhpUnused */

namespace App\Http\Livewire;

use App\Actions\SendMagicLinkAction;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Http\Livewire\Concerns\WithRateLimiting;
use App\Http\Livewire\Concerns\WithSpamChecks;
use App\Models\User;
use App\Rules\EmailRule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;

class LoginForm extends Component
{
    use AuthorizesRequests, WithSpamChecks, TrimAndNullEmptyStrings, WithRateLimiting;

    public $email;

    public function rules()
    {
        return [
            'email' => [
                'required',
                new EmailRule,
                new Exists(User::class),
            ],
        ];
    }

    public function mount()
    {
        $this->fill([
            'email' => old('email', request('email')),
        ]);
    }

    public function render()
    {
        return view('public.livewire.login-form');
    }

    public function sendMagicLink(SendMagicLinkAction $sendMagicLinkAction)
    {
        $this->rateLimit(3);
        $this->authorize('user-country');
        $this->validate();
        $this->spamGuard();

        $sendMagicLinkAction(User::whereEmail($this->email)->first());

        $this->reset('email');

        session()->flash('magic-link-sent', 'Magic link sent. Check your inbox.');
    }
}
