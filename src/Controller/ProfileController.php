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

        /*return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);*/
    }

    /**
     * @Route("/editProfile", name="editProfile")
     */
    public function editProfile(Request $request)
    {
        //Actualitzem les dades del empleat registrat

        //Rebre dades del formulari
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

        //Simplement respondem amb una resposta HTTP.
        //Aquesta resposta podra ser rebuda pel JS del perfil
        // i mostrar una alerta/notificacio avisant del resultat per exemple
    }
}
