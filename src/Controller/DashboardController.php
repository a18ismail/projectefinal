<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends AbstractController
{

    //Controlador principal pel "Panell de Control"
    //Els noms dels metodes son provisionals
    //Probablament cada "apartat de la pagina" tingui el seu propi controlador més endavant

    //TODO
    //UTILITZAR METODE INDEPENDENT PER COMPROBAR LOGIN
    //CHECK IF LOGGED IN -> GET EMPLOYEE DATA OR ID
    //FALTA CONTROL DE PERMISOS/SESSIÓ

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {

        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);
        $assignedOperations = sizeof( $employee->getEmployeeHasOperations() );
        $availableOperations = sizeof( $this->getDoctrine()->getRepository(Operation::class)->findAll() );

        return $this->render('main/templateLayout.html.twig', [
            'employee' => $employee,
            'assignedOperations' => $assignedOperations,
            'availableOperations' => $availableOperations
        ]);
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request)
    {

        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/profile.html.twig', ['employee' => $employee]);
        //return $this->render('dashboard/profile.html.twig');
    }

    /**
     * @Route("/operations", name="operations")
     */
    public function operations(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/operationsList.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/calendarOperations", name="calendarOperations")
     */
    public function calendarOperations(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/calendarOperations.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/calendarAvailability", name="calendarAvailability")
     */
    public function calendarAvailability(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/calendarAvailability.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/notifications", name="notifications")
     */
    public function notifications(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/notifications.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/mail.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/personalReport", name="personalReport")
     */
    public function personalReport(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/personalReport.html.twig', ['employee' => $employee]);
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function settings(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $employee = $this->getDoctrine()->getRepository(Employee::class)->find($employee_id);

        return $this->render('dashboard/settings.html.twig', ['employee' => $employee]);
    }
}
