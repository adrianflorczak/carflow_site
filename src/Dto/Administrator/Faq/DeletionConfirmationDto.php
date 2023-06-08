<?php

namespace App\Dto\Administrator\Faq;

use Symfony\Component\Validator\Constraints as Assert;

class DeletionConfirmationDto
{
    #[Assert\NotBlank]
    public string $confirmationText;

}