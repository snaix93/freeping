<?php /** @noinspection PhpUnused */

/** @noinspection PhpUndefinedClassInspection */

namespace App\Models\Concerns;

use Cog\Laravel\Optimus\Traits\OptimusEncodedRouteKey;

trait HasOptimusId
{
    use OptimusEncodedRouteKey;

    public static function findByOId($oid)
    {
        $entity = (new static);

        return $entity->findOrFail($entity->decodeId($oid));
    }

    public function decodeId($oId = null): int
    {
        return $this->getOptimus()->decode($oId ?? $this->${parent::getRouteKeyName()});
    }

    public function optimusId()
    {
        return $this->encodeId();
    }

    public function encodeId($id = null)
    {
        return $this->getOptimus()->encode($id ?? parent::getRouteKey());
    }
}
