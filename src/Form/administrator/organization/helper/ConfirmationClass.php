<?php

namespace App\Form\administrator\organization\helper;

class ConfirmationClass
{
    private bool $confirmation;

    public function __construct()
    {
    }

    public function getConfirmation(): bool
    {
        return $this->confirmation;
    }

    public function setConfirmation($confirmation): void
    {
        $this->confirmation = $confirmation;
    }



}