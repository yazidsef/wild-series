<?php

namespace App\Twig\Components;

use App\Repository\CategoryRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Navbar
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }
    public function getCategories():array
    {
        return $this->categoryRepository->findBy([],["name"=> "asc"]);
    }
}
