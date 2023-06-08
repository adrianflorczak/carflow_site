<?php

namespace App\Dto\Administrator\Faq;

use Symfony\Component\Validator\Constraints as Assert;

class FaqItemDto
{
    #[Assert\NotBlank]
    public int $priority;

    #[Assert\NotBlank]
    public string $question;

    #[Assert\NotBlank]
    public string $answer;
}