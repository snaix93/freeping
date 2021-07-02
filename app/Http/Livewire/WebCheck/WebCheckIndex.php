<?php

namespace App\Http\Livewire\WebCheck;

use App\Http\Livewire\Concerns\HasDeleteableEntities;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Models\Node;
use App\Models\WebCheck;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class WebCheckIndex extends Component
{
    use WithPagination, AuthorizesRequests, TrimAndNullEmptyStrings, HasDeleteableEntities;

    public $perPage = 5;

    public $editWebCheckId = null;

    public $showSlideOver = false;

    public ?int $selectedWebCheckId = null;

    public $confirmingWebCheckEdit = false;

    protected $listeners = [
        'webCheckCreated' => 'webCheckCreated',
        'webCheckUpdated' => 'webCheckUpdated',
    ];

    public function render()
    {
        return view('livewire.web-check.index', [
            'webChecks' => $this->getWebChecks(),
            'nodes'     => $this->getNodes(),
        ]);
    }

    private function getWebChecks()
    {
        return auth()->user()->webChecks()
            ->with([
                'webCheckResults' => fn($query) => $query->withOrderedNodes(),
            ])
            ->latest()
            ->paginate($this->perPage);
    }

    private function getNodes(): Collection
    {
        return Node::orderBy('short_name')->get();
    }

    public function getWebCheckProperty(): ?WebCheck
    {
        if (is_null($this->selectedWebCheckId)) {
            return null;
        }

        return auth()->user()->webChecks()
            ->where('id', (new WebCheck)->decodeId($this->selectedWebCheckId))
            ->with([
                'webCheckResults' => fn($query) => $query->withOrderedNodes(),
            ])
            ->first();
    }

    public function confirmWebCheckEdit($webCheckId)
    {
        $this->editWebCheckId = $webCheckId;
        $this->confirmingWebCheckEdit = true;
    }

    public function deleteEntity(int $entityId)
    {
        $webCheck = WebCheck::findByOId($entityId);

        $this->authorize('delete', $webCheck);
        $webCheck->delete();

        $this->resetDeleteProperties();
        $this->selectedWebCheckId = null;
        $this->showSlideOver = false;
        $this->resetPage();
    }

    public function webCheckCreated()
    {
        $this->resetPage();
        // $this->showWebCheckDetails($webCheck->encodeId());
        $this->emitSelf('notify-web-check-created');
    }

    public function showWebCheckDetails($webCheckId)
    {
        $this->selectedWebCheckId = $webCheckId;
        $this->showSlideOver = true;
    }

    public function webCheckUpdated(WebCheck $webCheck)
    {
        $this->resetPage();
        $this->showWebCheckDetails($webCheck->encodeId());
        $this->emitSelf('notify-web-check-updated');
    }
}
