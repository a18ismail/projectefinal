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

    //TODO
    //FALTA CONTROL DE PERMISOS/SESSIÓ

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else{
            $assignedOperations = sizeof( $employee->getEmployeeHasOperations() );
            $availableOperations = sizeof( $this->getDoctrine()->getRepository(Operation::class)->findAll() );

            return $this->render('main/templateLayout.html.twig', [
                'employee' => $employee,
                'assignedOperations' => $assignedOperations,
                'availableOperations' => $availableOperations
            ]);
        }
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/profile.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/operations", name="operations")
     */
    public function operations(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/operationsList.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/calendarOperations", name="calendarOperations")
     */
    public function calendarOperations(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/calendarOperations.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/calendarAvailability", name="calendarAvailability")
     */
    public function calendarAvailability(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/calendarAvailability.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/notifications", name="notifications")
     */
    public function notifications(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/notifications.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/mail.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/personalReport", name="personalReport")
     */
    public function personalReport(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/personalReport.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/settings", name="settings")
     */
    public function settings(Request $request)
    {
        $employee = self::checkLogin($request);

        if( is_null($employee) ){
            return $this->render('main/errorLogin.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/settings.html.twig', ['employee' => $employee]);
        }
    }

    /**
     * @Route("/checkLogin", name="checkLogin")
     */
    public function checkLogin(Request $request)
    {
        $session = $request->getSession();
        $employee_id = $session->get('id');

        if( is_null($employee_id) ){
            $employee = null;
        }else{
            $repository = $this->getDoctrine()->getRepository(Employee::class);
            $employee = $repository->find($employee_id);
        }

        return $employee;
    }
}
