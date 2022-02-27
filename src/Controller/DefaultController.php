<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\CostType;
use App\Form\CostForm;
use App\Service\CalculationCost\CalculationCostService;
use Exception;

class DefaultController extends AbstractController
{
    /**
     * @param Request $request
     * @param CalculationCostService $calculationCostService
     * @return void
     */
    public function index(Request $request, CalculationCostService $calculationCostService) 
    {
        $costForm = new CostForm();
        $form = $this->createForm(CostType::class, $costForm);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $costForm = $form->getData();

            try {
                $cost = $calculationCostService->calculate($costForm);
                return $this->render('default/response.html.twig', [
                    'cost' => $cost
                ]);
            } catch (Exception $exception) {
                file_put_contents(
                    dirname(__DIR__, 2) . '/var/log/app-error.txt',
                    print_r("{$exception->getMessage()}|{$exception->getFile()}::{$exception->getLine()}\n", true),
                    FILE_APPEND
                );
                return $this->render('default/error.html.twig');
            }
        }

        return $this->renderForm('default/index.html.twig', [
            'form' => $form
        ]);
    }
}