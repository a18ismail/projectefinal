<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\LoginValidator;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MailController extends AbstractController
{
    private $loginValidator;

    public function __construct(LoginValidator $validator)
    {
        $this->loginValidator = $validator;
    }

    //TODO
    //SISTEMA DE MISSATGERIA
    /**
     * @Route("/getMessages", name="getMessages")
     */
    public function getMessages(Request $request)
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else{
            $data = $request->getContent();
            $JSONData = json_decode($data);
            $requestedEmployeeId = $JSONData->contactId;

            $requestedContact = $this->getDoctrine()->getRepository(Employee::class)->find($requestedEmployeeId);

            //Missatges enviats per l'empleat registrat
            $messagesSent = $employee->getMessages();

            //Return: missatges enviats per l'empleat
            $responseMessagesSent = array();

            foreach ( $messagesSent as $messageSent ){
                //Comprovar quins son els enviats al contacte demanat
                $contactFound = $messageSent->getReceiver();

                //Si son els missatges enviats al contacte enviat, afegir al return
                if( $contactFound->getId() == $requestedContact->getId() ){
                    foreach ( $contactFound->getMessages() as $message ){
                        $responseMessagesSent[] = array(
                            'content' => $message->getContent(),
                            'date' => $message->getDate()
                        );
                    }
                }
            }

            //Missatges enviats pel contacte demanat
            $messagesReceived = $requestedContact->getMessages();

            //Return: missatges enviats pel contacte demanat
            $responseMessagesReceived = array();

            foreach ( $messagesReceived as $messageReceived ) {
                //Comprovar quins son els enviats al empleat registrat
                $contactFound = $messageReceived->getReceiver();

                //Si son els missatges enviats al contacte enviat, afegir al return
                if( $contactFound->getId() == $employee->getId() ){

                }
            }


        }
        return new Response('true');
    }
}
