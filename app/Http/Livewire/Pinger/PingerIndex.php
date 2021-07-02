<?php

namespace App\Http\Livewire\Pinger;

use App\Enums\TargetStatus;
use App\Http\Livewire\Concerns\HasDeleteableEntities;
use App\Http\Livewire\Concerns\TrimAndNullEmptyStrings;
use App\Models\Node;
use App\Models\Target;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class PingerIndex extends Component
{
    use WithPagination, AuthorizesRequests, TrimAndNullEmptyStrings, HasDeleteableEntities;

    public $perPage = 10;

    public $editTargetId = null;

    public $showSlideOver = false;

    public ?int $selectedTargetId = null;

    public $confirmingTargetEdit = false;

    public $defaultGroup = 'location';

    public $groups = [];

    protected $listeners = [
        'pingerCreated' => 'pingerCreated',
        'pingerUpdated' => 'pingerUpdated',
    ];

    public function mount()
    {
        $this->fill([
            'groups'   => [
                'location' => __('Location'),
                'target'   => __('Target'),
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.pinger.index', [
            'targets' => $this->getTargets(),
            'nodes'   => $this->getNodes(),
        ]);
    }

    private function getTargets(): Paginator
    {
        return auth()->user()->targets()
            ->with([
                'ports',
                'ports.scanResults' => fn($query) => $query->withOrderedNodes(),
                'pingResults'       => fn($query) => $query->withOrderedNodes(),
            ])
            ->latest()
            ->paginate($this->perPage);
    }

    private function getNodes(): Collection
    {
        return Node::orderBy('short_name')->get();
    }

    public function getTargetProperty(): ?Target
    {
        if (is_null($this->selectedTargetId)) {
            return null;
        }

        return auth()->user()->targets()
            ->where('id', (new Target)->decodeId($this->selectedTargetId))
            ->with([
                'ports',
                'ports.scanResults' => fn($query) => $query->withOrderedNodes(),
                'pingResults'       => fn($query) => $query->withOrderedNodes(),
            ])
            ->first();
    }

    public function confirmTargetEdit($targetId)
    {
        $this->editTargetId = $targetId;
        $this->confirmingTargetEdit = true;
    }

    public function deleteEntity(int $entityId)
    {
        $target = Target::findByOId($entityId);

        $this->authorize('delete', $target);
        $target->delete();

        $this->resetDeleteProperties();
        $this->selectedTargetId = null;
        $this->showSlideOver = false;
        $this->resetPage();
    }

    public function pingerCreated(Target $target)
    {
        $this->resetPage();
        $this->showTargetDetails($target->encodeId());
        $this->emitSelf('notify-pinger-created');
    }

    public function pingerUpdated(Target $target)
    {
        $this->resetPage();
        $this->showTargetDetails($target->encodeId());
        $this->emitSelf('notify-pinger-updated');
    }

    public function showTargetDetails($targetId)
    {
        $this->selectedTargetId = $targetId;
        $this->showSlideOver = true;
    }
}
