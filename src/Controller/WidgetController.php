<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class WidgetController extends AbstractController
{

    //CONSEGUIR NOMBRE DE OPERATIVES ASSIGNADES
    /**
     * @Route("/widget", name="widget")
     */
    public function getOperationsCountByEmployee(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);
        var_dump( sizeof( $employee->getEmployeeHasOperations() ) );
    }

    //TODO
    //CONSEGUIR TEMPS RESTANT PER LA PROXIMA OPERATIVA


}
