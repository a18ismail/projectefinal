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


    /**
     * @Route("/getRemainingTimeOperation", name="getRemainingTimeOperation")
     */
    public function getRemainingTimeOperation()
    {
        //CONSEGUIR TEMPS RESTANT PER LA PROXIMA OPERATIVA

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {
            $relations = $employee->getEmployeeHasOperations();

            //Recorrer l'aray de relacions entre Empleat i Operativa per aconseguir el temps restant
            $operationsArray = array();
            foreach ($relations as $relation){
                $operation = $relation->getOperation();

                $dateStart = $operation->getDateStart();
                $dateToday = new \DateTime('@'.strtotime('now'));

                //Afegir a un array les operatives més properes
                if( $dateStart > $dateToday ){
                    $operationsArray[] = array('dateStart' => $dateStart);
                }
            }

            //Ordenar operatives per la data
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

    /**
     * @Route("/getCompletedHours", name="getCompletedHours")
     */
    public function getCompletedHours()
    {
        //CONSEGUIR HORES TREBALLADES

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {

            //Conseguir les operatives de l'empleat
            $relations = $employee->getEmployeeHasOperations();

            //Acomular les hores segons la duració de les operatives
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

    /**
     * @Route("/getSalaryData", name="getSalaryData")
     */
    public function getSalaryData()
    {
        //Conseguir dades sobre les oepratives realitzades
        //Es mostra al informe personal
        //INGRESOS -> TOTAL, NET, MES PASSAT, TOTAL ANUAL

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return new Response('false');
        }else {
            //Conseguir totes les operatives
            $relations = $employee->getEmployeeHasOperations();

            $totalIncomeMonth = 0;
            $totalIncomeYear = 0;
            foreach ($relations as $relation){
                //A partir de les relacions recorrem les operatives
                $operation = $relation->getOperation();

                //Filtrem l'any actual
                if( $operation->getDateStart()->format('Y') == date('Y') && $relation->getStatus() == 'completed' ){

                    //Conseguim la duració real i la paga per hora
                    $relationDuration = $relation->getRealDuration();
                    $operationHourlyPay = $operation->getHourlyPay();

                    //Sumem al resultat i filtrem per any i per mes per aconseguir els dos totals
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
