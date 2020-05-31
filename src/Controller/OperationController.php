<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\EmployeeHasOperation;
use App\Entity\Operation;
use App\Service\LoginValidator;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends AbstractController
{
    private $loginValidator;

    public function __construct(LoginValidator $validator)
    {
        $this->loginValidator = $validator;
    }

    /**
     * @Route("/assignOperation", name="assignOperation")
     */
    public function assignOperation(Request $request)
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else{
            $data = $request->getContent();
            $JSONData = json_decode($data);

            //Recuperar la operativa a partir de la informació rebuda
            $operation_code = $JSONData->operationCode;
            $operation = $this->getDoctrine()->getRepository(Operation::class)->findByCode($operation_code);

            //Emmagatzemar la nova relació Empleat-Operativa
            $addOperationToEmployee = new EmployeeHasOperation();
            $addOperationToEmployee->setEmployee($employee);
            $addOperationToEmployee->setOperation($operation[0]);
            $addOperationToEmployee->setStatus('reserved');
            $addOperationToEmployee->setRealDuration('8');

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($addOperationToEmployee);
            $manager->flush();

            //Resposta a la petició demanada
            return new Response('true');
        }
    }

    /**
     * @Route("/deleteOperation", name="deleteOperation")
     */
    public function deleteOperation(Request $request)
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else{
            $data = $request->getContent();
            $JSONData = json_decode($data);

            //Recuperar la operativa a partir de la informació rebuda
            $operation_code = $JSONData->operationCode;
            $operation = $this->getDoctrine()->getRepository(Operation::class)->findByCode($operation_code);

            //Recuperar la relació d'aquesta operativa amb l'empleat registrat
            $relationOperation = $this->getDoctrine()->getRepository(EmployeeHasOperation::class)
                ->findOneBy(array(
                    'operation' => $operation[0]->getId(),
                    'employee' => $employee->getId()
                ));

            //Eliminar la relació Empleat-Operativa per "eliminar" l'operativa demanada
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($relationOperation);
            $manager->flush();

            //Resposta de confirmació a la petició feta
            return new Response('true');
        }
    }

    /**
     * @Route("/confirmOperation", name="confirmOperation")
     */
    public function confirmOperation(Request $request)
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else{
            $data = $request->getContent();
            $JSONData = json_decode($data);

            //Recuperar la operativa a partir de la informació rebuda
            $operation_code = $JSONData->operationCode;
            $operation = $this->getDoctrine()->getRepository(Operation::class)->findByCode($operation_code);

            //Recuperar la relació d'aquesta operativa amb l'empleat registrat
            $relationOperation = $this->getDoctrine()->getRepository(EmployeeHasOperation::class)
                ->findOneBy(array(
                    'operation' => $operation[0]->getId(),
                    'employee' => $employee->getId()
                ));

            //Modificar la relació Empleat-Operativa per canviar l'estat de l'operativa demanada
            $manager = $this->getDoctrine()->getManager();
            $relationOperation->setStatus('confirmed');
            $manager->flush();

            //Resposta de confirmació a la petició feta
            return new Response('true');
        }
    }

}
