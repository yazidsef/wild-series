<?php

namespace App\Twig\Components;

use App\Repository\ProgramRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class SearchProgram
{
    use DefaultActionTrait;
    public function __construct(private ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }
}
