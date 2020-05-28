<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends AbstractController
{
    /**
     * @Route("/indexProfile", name="indexProfile")
     */
    public function index()
    {
        //AQUEST METODE NO L'UTILITZEM ARA
        //POTSER PASSEM EL profile() de DashboardController aqui mes en davant
        //

        /*return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);*/
    }

    /**
     * @Route("/editProfile", name="editProfile")
     */
    public function editProfile(Request $request)
    {
        //Aqui actualitzem les dades del empleat registrat

        //rebre dades del formulari
        $email = $request->get('inputEmail');
        $phone = $request->get('inputPhone');
        $address = $request->get('inputAddress');
        $postcode = $request->get('inputPostcode');
        $notes = $request->get('inputNotes');

        $phone = (int)$phone;
        $postcode = (int)$postcode;
        
        //Conseguim ID per poder editar l'objecte
        $session = $request->getSession();
        $employee_id = $session->get('id');

        $entityManager = $this->getDoctrine()->getManager();
        $employee = $entityManager->getRepository(Employee::class)->find($employee_id);

        //Fem un update de l'empleat per actualitzar les seves dades
        
        $employee->setEmail($email);

        $employee->setPhoneNumber($phone);

        $employee->setAddress($address);

        $employee->setPostcode($postcode);

        $employee->setNotes($notes);

        $entityManager->flush();
        //Finalment enviem una resposta
        return new RedirectResponse($this->generateUrl('profile'));
        //Ja que aquest metode nomes ha de rebre una petició POST i fer un update, no fem cap render de templates
        //Simplement respondem amb una resposta HTTP.
        //Aquesta resposta podra ser rebuda pel JS del perfil
        // i mostrar una alerta/notificacio avisant del resultat per exemple

    }
}
