<?php

namespace App\Http\Livewire\Concerns;

trait WithLiveWireTraitValidation
{
    protected function getRules()
    {
        $rules = parent::getRules();

        $class = static::class;

        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'rules'.class_basename($trait))) {
                $rules = array_merge($rules, $this->{$method}());
            }
        }

        return $rules;
    }

    protected function getMessages()
    {
        $messages = parent::getMessages();

        $class = static::class;

        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'messages'.class_basename($trait))) {
                $messages = array_merge($messages, $this->{$method}());
            }
        }

        return $messages;
    }

    protected function getValidationAttributes()
    {
        $attributes = parent::getValidationAttributes();

        $class = static::class;

        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'validationAttributes'.class_basename($trait))) {
                $attributes = array_merge($attributes, $this->{$method}());
            }
        }

        return $attributes;
    }
}
