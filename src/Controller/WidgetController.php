<?php

namespace App\Controller;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class WidgetController extends AbstractController
{
    /**
     * @Route("/widget", name="widget")
     */
    public function index()
    {
        return $this->render('base.html.twig');
    }

    //TODO
    //CONSEGUIR NOMBRE DE OPERATIVES RESERVADES
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
    //CONSEGUIR NOMBRE DE OPERATIVES DISPONIBLES AL SISTEMA

    //TODO
    //CONSEGUIR INFORMACIÓ DE PROXIMA OPERATIVA

    //TODO
    //CONSEGUIR TEMPS RESTANT PER LA PROXIMA OPERATIVA


}
