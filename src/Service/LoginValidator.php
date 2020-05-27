<?php


namespace App\Service;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginValidator
{
    protected $requestStack;
    protected $manager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $manager)
    {
        $this->requestStack = $requestStack;
        $this->manager = $manager;
    }

    public function checkLogin()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $employee_id = $session->get('id');

        if( is_null($employee_id) ){
            $employee = null;
        }else{
            $repository = $this->manager->getRepository(Employee::class);
            $employee = $repository->find($employee_id);
        }

        return $employee;
    }

}