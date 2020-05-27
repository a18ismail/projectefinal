<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\LoginValidator;
use App\Controller\DashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CalendarController extends AbstractController
{
    private $loginValidator;

    public function __construct(LoginValidator $validator)
    {
        $this->loginValidator = $validator;
    }

    /**
     * @Route("/calendar", name="calendar")
     */
    public function index()
    {
        $employee = $this->loginValidator->checkLogin();
        return $this->render('calendar/index.html.twig', [
            'controller_name' => 'CalendarController',
        ]);
    }

    /**
     * @Route("/getEvents", name="getEvents")
     */
    public function getCalendarOperationsEvents(Request $request)
    {
        //Conseguir dades de l'empleat registrat
        $employee = $this->loginValidator->checkLogin();
        $assignedOperations = $employee->getEmployeeHasOperations();

        $calendarEvents = array();

        foreach($assignedOperations as $assignedOperation) {
            $operation = $assignedOperation->getOperation();

            $calendarEvents[] = array(
                'code' => $operation->getCode(),
                'title' => $operation->getTitle(),
                'type' => $operation->getType(),
                'dateStart' => $operation->getDateStart(),
                'dateEnd' => $operation->getDateEnd(),
                'description' => $operation->getDescription()
            );
        }

        //Crear la resposta
        $response = new JsonResponse($calendarEvents);

        //Enviar la resposta
        //$response->send();

        return $response;
    }


}
