<?php

namespace App\Http\Livewire\Concerns;

trait HasDeleteableEntities
{
    public $deleteEntityId = null;

    public $confirmingEntityDeletion = false;

    public function confirmEntityDeletion($entityId)
    {
        $this->deleteEntityId = $entityId;
        $this->confirmingEntityDeletion = true;
    }

    protected function resetDeleteProperties()
    {
        $this->deleteEntityId = null;
        $this->confirmingEntityDeletion = false;
    }

    abstract public function deleteEntity(int $entityId);
}
