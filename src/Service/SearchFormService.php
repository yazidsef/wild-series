<?php

namespace App\Service;

use App\Form\SearchProgramType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SearchFormService extends AbstractExtension {
    private $formFactory;
    private $requestStack;
    
    public function __construct(FormFactoryInterface $formFactory , RequestStack $requestStack)
    {
    $this->formFactory = $formFactory;
    $this->requestStack = $requestStack;
    }

    public function getFunctions():array
    {
        return [
            new TwigFunction('search_form',[$this,'createSearchForm'])
        ];
    }

    public function createSearchForm():FormView
    {
        $request = $this->requestStack->getCurrentRequest();
        $form = $this->formFactory->create(SearchProgramType::class, null, [
            'method' => 'GET', // Ensure the form is configured for GET
            'action' => $request->getUri(), // Maintain the current URL
        ]);
        $form->handleRequest($request);

        return $form->createView();

    }
}





?>