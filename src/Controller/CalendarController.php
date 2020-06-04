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
     * @Route("/getEvents", name="getEvents")
     */
    public function getCalendarOperationsEvents(Request $request)
    {
        //Operatives actuals i disponibles en forma d'events formatejats pel frontend/calendari interactiu

        //Conseguir dades de l'empleat registrat
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('Hi ha hagut un error amb la teva petició.');
        }else {
            //Conseguir operatives
            $assignedOperations = $employee->getEmployeeHasOperations();
            $calendarEvents = array();

            //Afegir operatives a l'array de resposta
            foreach ($assignedOperations as $assignedOperation) {
                $operation = $assignedOperation->getOperation();

                $calendarEvents[] = array(
                    'code' => $operation->getCode(),
                    'title' => $operation->getTitle(),
                    'type' => $operation->getType(),
                    'dateStart' => $operation->getDateStart(),
                    'dateEnd' => $operation->getDateEnd(),
                    'description' => $operation->getDescription(),
                    'status' => $assignedOperation->getStatus()
                );
            }

            //Crear la resposta
            $response = new JsonResponse($calendarEvents);

            //Enviar la resposta
            return $response;
        }
    }

    /**
     * @Route("/saveAvailability", name="saveAvailability")
     */
    public function saveAvailability(Request $request)
    {
        //Disponibilitat de l'empleat rebuda del frontend i formatejada per emmagatzemar a la BD

        //Conseguir empleat registrat
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('Hi ha hagut un error amb la teva petició.');
        }else {
            //Conseguir dades i convertir en array d'objectes
            $data = $request->getContent();
            $JSONData = json_decode($data);
            $eventsObjects = json_decode($JSONData->events );

            $arrayAvailability = array();

            //Formatejar la disponibilitat en un array per la BD/objecte
            foreach ($eventsObjects as $eventObject) {
                $event = array(
                    'dateStart' => $eventObject->dateStart,
                    'dateEnd' => $eventObject->dateEnd
                );
                array_push($arrayAvailability, $event);
            }

            //Emmagatzemar la disponibilitat de l'empleat
            $entityManager = $this->getDoctrine()->getManager();
            $employee->setAvailability($arrayAvailability);
            $entityManager->flush();

            //Enviar resposta
            return new Response('Guardada correctament.');
        }

    }

    /**
     * @Route("/getAvailability", name="getAvailability")
     */
    public function getAvailability()
    {
        //Enviar la disponibilitat de l'empleat emmagatzemada a la BD cap al frontend

        //Conseguir empleat registrat
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('Hi ha hagut un error amb la teva petició.');
        }else {

            //Emmagatzemar events de disponibilitat en un array
            $savedArray = $employee->getAvailability();
            $arrayAvailability = array();

            //Formatejar disponibilitat en events
            foreach ($savedArray as $item){
                $event = array(
                    'dateStart' => $item['dateStart'],
                    'dateEnd' => $item['dateEnd']
                );
                array_push($arrayAvailability, $event);
            }

            //Crear la resposta
            $response = new JsonResponse($arrayAvailability);

            //Enviar la resposta
            return $response;
        }
    }




}
