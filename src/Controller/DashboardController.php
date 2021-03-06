<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\EmployeeHasOperation;
use App\Entity\Operation;
use App\Repository\EmployeeRepository;
use App\Service\LoginValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Session\Session;

class DashboardController extends AbstractController
{
    //Aquest Controlador s'encarrega d'enrutar els apartats de la web i la seva renderització

    //Aquest objecte és present a tots els controladors
    //S'encarrega de utilitzar el servei LoginValidator per comprobar l'estat del login abans de fer qualsevol operació
    private $loginValidator;

    public function __construct(LoginValidator $validator)
    {
        $this->loginValidator = $validator;
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request)
    {
        //Enruta al panell de control principal
        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
                'login_status' => false,
            ]);
        }else{
            //Preparar dades per la renderització del menú lateral i la pàgina principal

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
        //Enruta al perfil personal de l'usuari/empleat logejat

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
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
        //Enruta a la vista de les operacions en llista

        $employee = $this->loginValidator->checkLogin();

        //Conseguir les operatives per la renderització
        $relationRepository = $this->getDoctrine()->getRepository(EmployeeHasOperation::class);

        $availableOperations = $this->getDoctrine()->getRepository(Operation::class)->findAllAvailableOperations($relationRepository);

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/operationsList.html.twig', ['employee' => $employee, 'availableOperations' => $availableOperations]);
        }
    }

    /**
     * @Route("/calendarOperations", name="calendarOperations")
     */
    public function calendarOperations(Request $request)
    {
        //Enruta a la vista de les operatives assignades/disponibles en forma de calendari

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
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
        //Enruta a la vista de la disponibilitat de l'usuari/empleat logejat en forma de calendari

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
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
        //Enruta a la vista de les notificacions

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
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
        //Enruta a la vista dels missatges

        $employee = $this->loginValidator->checkLogin();

        $allEmployees = $this->getDoctrine()->getRepository(Employee::class)->findAll();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/mail.html.twig', [
                'employee' => $employee,
                'contacts' => $allEmployees
            ]);
        }
    }

    /**
     * @Route("/personalReport", name="personalReport")
     */
    public function personalReport(Request $request)
    {
        //Enruta a la vista de l'informe personal

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
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
        //Enruta a la vista de la configuració de la web

        $employee = $this->loginValidator->checkLogin();

        if( is_null($employee) ){
            return $this->render('main/signError.html.twig', [
                'login_status' => false,
            ]);
        }else {
            return $this->render('dashboard/settings.html.twig', ['employee' => $employee]);
        }
    }

}
