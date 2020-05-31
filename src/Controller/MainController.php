<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Employee;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MainController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
/*        return $this->render('main/landingLayout.html.twig', [
            'login_status' => false,
        ]);*/
        return $this->render('baseStart.html.twig');
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function signin()
    {
        return $this->render('main/signin.html.twig');
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup()
    {
        return $this->render('main/signup.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        //Tanquem la session cada vegada que s'intenta fer login
        $session = new Session();
        $session->clear();

        //Rebre dades formulari Login
        $email = $request->get('inputEmail');
        $password = $request->get('inputPassword');

        //Comprobar dades de Empleat
        $employees = $this->getDoctrine()->getRepository(Employee::class)->checkEmployeeLogin($email);

        if ( sizeof($employees) == 0 ){
            //Email incorrecte o error en emmagatzemar empleat
            return $this->render('main/signError.html.twig', [
                'login_status' => false,
            ]);
        } else{
            //Verificar contrasenya encriptada
            $storedHash = $employees[0]->getPassword();

            if ( password_verify($password, $storedHash ) ) {
                //Contrasenya correcte
                //Conseguir ID
                $employee_id = $employees[0]->getId();

                //Com encara no tenim control de usuaris implementat, utilitzem sessions de PHP senzilles
                //La sessió només emmagatzema l'Id

                //Iniciem la sessió de l'empleat
                $session = $request->getSession();
                $session->set('id', $employee_id);

                //Redirigir a Dashboard
                return new RedirectResponse($this->generateUrl('dashboard'));
            }else{
                return $this->render('main/signError.html.twig', [
                    'login_status' => false,
                ]);
            }

        }

    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        //Rebre dades formulari de registre i netejar-les
        $data = $request->getContent();

        $JSONData = json_decode($data);
        $formData = json_decode($JSONData->data);

        $email = $formData->registerEmail;
        $password = $formData->registerPassword;
        $name = $formData->registerName;
        $surnames = $formData->registerSurnames;

        $entityManager = $this->getDoctrine()->getManager();

        $newEmployee = new Employee();
        $newEmployee->setName($name);
        $newEmployee->setSurnames($surnames);
        $newEmployee->setNif('XXXXXXXXX');
        $newEmployee->setPhoneNumber(1111111111);
        $newEmployee->setEmail($email);
        $newEmployee->setPassword( password_hash($password, PASSWORD_DEFAULT) );

        //TODO
        //CHECK IF EMAIL EXISTS ALREADY

        $entityManager->persist($newEmployee);
        $entityManager->flush();

        $employees = $this->getDoctrine()->getRepository(Employee::class)->checkEmployeeLogin($email);

        if ( sizeof($employees) == 0 ){
            //Email incorrecte/error en emmagatzemar empleat
            return new Response('false');
        } else{
            return new Response('true');
        }
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        //Netejar valors de la sessió activa
        $session = new Session();
        $session->clear();

        return $this->render('main/logout.html.twig', [
            'login_status' => false,
        ]);
    }

    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePassword(Request $request)
    {
        //Rebre contrasenyes del formulari i netejar-les
        $data = $request->getContent();

        $JSONData = json_decode($data);
        $formData = json_decode($JSONData->data);

        $currentPassword = $formData->currentPassword;
        $newPassword = $formData->newPassword;
        $newPasswordConfirm = $formData->newPasswordConfirm;
        $email = $formData->email;

        //Conseguir empleat
        $employees = $this->getDoctrine()->getRepository(Employee::class)->checkEmployeeLogin($email);

        if ( sizeof($employees) == 0 ){
            //Email incorrecte/error en empleat
            return new Response('false');
        } else{
            $storedHash = $employees[0]->getPassword();
            //Comprovar contrasenya
            if ( password_verify($currentPassword, $storedHash ) ) {
                //Contrasenya actual correcte

                //Comparar contrasenyes
                if( strcmp($newPassword, $newPasswordConfirm) == 0 ){
                    //Contrasenyes introduides correctes

                    //Codificar contrasenya
                    $passwordToStore = password_hash($newPassword, PASSWORD_DEFAULT);

                    //Afegir contrasenya
                    $employee = $employees[0];
                    $entityManager = $this->getDoctrine()->getManager();
                    $employee->setPassword($passwordToStore);

                    $entityManager->flush();

                    return new Response('true');
                }else{
                    return new Response('errorConfirmPassword');
                }
            }else{
                //La contrasenya actual introduida és incorrecte
                return new Response('errorCurrentPassword');
            }

        }
    }

    /**
     * @Route("/downloadEmployeeData", name="downloadEmployeeData")
     */
    public function downloadEmployeeData(Request $request)
    {
        $data = $request->getContent();

        $JSONData = json_decode($data);
        $formData = json_decode($JSONData->data);

        $email = $formData->email;

        $employees = $this->getDoctrine()->getRepository(Employee::class)->checkEmployeeLogin($email);

        if ( sizeof($employees) == 0 ){
            //Email incorrecte/error en empleat
            return new Response('false');
        } else{

            //Instanciar serialitzador d'objectes
            $encoders = [new XmlEncoder(), new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers, $encoders);

            //Convertir objecte Employee a JSON string
            $JSONEmployee = $serializer->serialize($employees[0], 'json');

            //Enviar objecte convertit
            return new Response($JSONEmployee);
        }
    }

}
