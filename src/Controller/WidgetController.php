<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Service\LoginValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class WidgetController extends AbstractController
{

    private $loginValidator;

    public function __construct(LoginValidator $validator)
    {
        $this->loginValidator = $validator;
    }

    //CONSEGUIR NOMBRE DE OPERATIVES ASSIGNADES
    /**
     * @Route("/widget", name="widget")
     */
    public function getOperationsCountByEmployee(Request $request)
    {
/*        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);
        var_dump( sizeof( $employee->getEmployeeHasOperations() ) );*/
    }


    //CONSEGUIR TEMPS RESTANT PER LA PROXIMA OPERATIVA
    /**
     * @Route("/getRemainingTimeOperation", name="getRemainingTimeOperation")
     */
    public function getRemainingTimeOperation()
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {
            $relations = $employee->getEmployeeHasOperations();

            $operationsArray = array();
            foreach ($relations as $relation){
                $operation = $relation->getOperation();

                $dateStart = $operation->getDateStart();
                $dateToday = new \DateTime('@'.strtotime('now'));

                if( $dateStart > $dateToday ){
                    $operationsArray[] = array('dateStart' => $dateStart);
                }
            }

            usort($operationsArray, function($a, $b) {
                return ($a['dateStart'] < $b['dateStart']) ? -1 : 1;
            });

            //Data d'ultima operativa en string
            $responseDate = date_format($operationsArray[0]['dateStart'], 'm/d/Y H:i:s');

            //Crear la resposta
            $response = new JsonResponse($responseDate);

            //Enviar la resposta
            return $response;
        }
    }


    //CONSEGUIR HORES TREBALLADES
    /**
     * @Route("/getCompletedHours", name="getCompletedHours")
     */
    public function getCompletedHours()
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {
            $relations = $employee->getEmployeeHasOperations();

            $totalHours = 0;
            foreach ($relations as $relation){
                $relationDuration = $relation->getRealDuration();

                if( !is_null($relationDuration) ){
                    $totalHours += $relationDuration;
                }
            }

            //Crear la resposta
            $response = new JsonResponse($totalHours);

            //Enviar la resposta
            return $response;
        }
    }


    //INGRESOS -> TOTAL, NET, MES PASSAT, TOTAL ANUAL
    /**
     * @Route("/getSalaryData", name="getSalaryData")
     */
    public function getSalaryData()
    {
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {
            $relations = $employee->getEmployeeHasOperations();

            $totalIncomeMonth = 0;
            $totalIncomeYear = 0;
            foreach ($relations as $relation){
                $operation = $relation->getOperation();

                //Filtrem l'any actual
                if( $operation->getDateStart()->format('Y') == date('Y') ){

                    $relationDuration = $relation->getRealDuration();
                    $operationHourlyPay = $operation->getHourlyPay();

                    if( !is_null($operationHourlyPay) && !is_null($relationDuration) ){

                        $totalIncomeYear += ($operationHourlyPay * $relationDuration);
                        if( $operation->getDateStart()->format('m') == date('m') ){
                            $totalIncomeMonth += ($operationHourlyPay * $relationDuration);
                        }
                    }
                }
            }

            //Crear la resposta
            $salaryData = array(
                'totalIncomeMonth' => $totalIncomeMonth,
                'totalIncomeYear' => $totalIncomeYear,
                'totalIncomeLastMonth' => 0
            );

            $response = new JsonResponse($salaryData);

            //Enviar la resposta
            return $response;
        }
    }

}
