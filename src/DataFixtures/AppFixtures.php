<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\EmployeeHasOperation;
use App\Entity\Operation;
use App\Entity\Port;
use App\Entity\Supervisor;
use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        //Creació de Port
        $portBCN = new Port();
        $portBCN->setCode('BCNESP')
            ->setCity('Barcelona')
            ->setCountry('Espanya')
            ->setName('Port de Barcelona');
        $manager->persist($portBCN);

        //Creació de Operations
        $numOperations = 5;
        for($i=1; $i<=$numOperations; $i++){
            $title = "Operativa " . $i;
            $type = "Desk Assistant";
            $code = "GYR00".$i;
            $portCode = "BCNESP";
            $dateStart = new \DateTime('@'.strtotime('now'));
            $dateEnd = new \DateTime('@'.strtotime('now'));
            $hourlyPay = 10.5;

            $operativa = new Operation();
            $operativa->setTitle($title)
                ->setType($type)
                ->setCode($code)
                ->setDateStart($dateStart)
                ->setDateEnd($dateEnd)
                ->setHourlyPay($hourlyPay)
                ->setPort($portBCN)
                ->setDescription('Aquesta es una descripció de prova! Aqui hi anirá una descripció
                                                detallada de la operativa.');
            $manager->persist($operativa);
        }

        $operativa01 = new Operation();
        $operativa01->setTitle('Encarregat de Check-out de passatgers')
            ->setType('Personal portuari')
            ->setCode('PRC01')
            ->setDateStart(new \DateTime('@'.strtotime('now')))
            ->setDateEnd(new \DateTime('@'.strtotime('+2 hours')))
            ->setHourlyPay(15.9)
            ->setPort($portBCN)
            ->setDescription('Aquesta es una descripció de prova! Aqui hi anirá una descripció
                                                detallada de la operativa.');

        $operativa02 = new Operation();
        $operativa02->setTitle('Rebuda de passatgers')
            ->setType('Personal portuari')
            ->setCode('PRC02')
            ->setDateStart(new \DateTime('@'.strtotime('+2 days')))
            ->setDateEnd(new \DateTime('@'.strtotime('+2 hours')))
            ->setHourlyPay(15.9)
            ->setPort($portBCN)
            ->setDescription('Aquesta es una descripció de prova! Aqui hi anirá una descripció
                                                detallada de la operativa.');

        $operativa03 = new Operation();
        $operativa03->setTitle('Desk Assistant')
            ->setType('Personal portuari')
            ->setCode('PRC03')
            ->setDateStart(new \DateTime('@'.strtotime('+10 days')))
            ->setDateEnd(new \DateTime('@'.strtotime('+2 hours')))
            ->setHourlyPay(10)
            ->setPort($portBCN)
            ->setDescription('Aquesta es una descripció de prova! Aqui hi anirá una descripció
                                                detallada de la operativa.');

        $operativa04 = new Operation();
        $operativa04->setTitle('Ajudant de guardamolls')
            ->setType('Personal portuari')
            ->setCode('PRC04')
            ->setDateStart(new \DateTime('@'.strtotime('+1 day')))
            ->setDateEnd(new \DateTime('@'.strtotime('+2 hours')))
            ->setHourlyPay(10)
            ->setPort($portBCN)
            ->setDescription('Aquesta es una descripció de prova! Aqui hi anirá una descripció
                                                detallada de la operativa.');

        $manager->persist($operativa01);
        $manager->persist($operativa02);
        $manager->persist($operativa03);
        $manager->persist($operativa04);

        //Creació de Employees
        $numEmployees = 5;
        for ($i=1; $i<=$numEmployees; $i++){
            //Load Simple employees
            $name = 'Usuari '.$i;
            $surnames = 'Smith';
            $email = 'user_'.$i.'_mail@gmail.com';
            $password = password_hash('password', PASSWORD_DEFAULT);
            $nif = "8754965".$i;
            $phoneNumber = $i.$i.$i.$i.$i.$i.$i.$i.$i;
            $birthday = new \DateTime('@'.strtotime('now'));
            $address = "C/ Rambla Gran 14 Barcelona, Espanya";
            $postcode = 8447;
            $nss = "4477885521";
            $notes = "Afegeix més informació sobre tu!";
            $sns_twitter = "https://www.twitter.com";
            $sns_linkedin = "https://www.linkedin.com";

            $employee = new Employee();
            $employee->setEmail($email)
                ->setName($name)
                ->setSurnames($surnames)
                ->setPassword($password)
                ->setNif($nif)
                ->setPhoneNumber($phoneNumber)
                ->setBirthday($birthday)
                ->setAddress($address)
                ->setPostcode($postcode)
                ->setNss($nss)
                ->setNotes($notes)
                ->setSnsTwitter($sns_twitter)
                ->setSnsLinkedin($sns_linkedin);
            $manager->persist($employee);

            $addOperationToEmployee01 = new EmployeeHasOperation();
            $addOperationToEmployee01->setEmployee($employee);
            $addOperationToEmployee01->setOperation($operativa01);
            $addOperationToEmployee01->setStatus('confirmed');
            $addOperationToEmployee01->setRealDuration('5');

            $addOperationToEmployee02 = new EmployeeHasOperation();
            $addOperationToEmployee02->setEmployee($employee);
            $addOperationToEmployee02->setOperation($operativa02);
            $addOperationToEmployee02->setStatus('reserved');
            $addOperationToEmployee02->setRealDuration('5');

            $addOperationToEmployee03 = new EmployeeHasOperation();
            $addOperationToEmployee03->setEmployee($employee);
            $addOperationToEmployee03->setOperation($operativa03);
            $addOperationToEmployee03->setStatus('confirmed');
            $addOperationToEmployee03->setRealDuration('5');

            $addOperationToEmployee04 = new EmployeeHasOperation();
            $addOperationToEmployee04->setEmployee($employee);
            $addOperationToEmployee04->setOperation($operativa04);
            $addOperationToEmployee04->setStatus('completed');
            $addOperationToEmployee04->setRealDuration('5');

            $manager->persist($addOperationToEmployee01);
            $manager->persist($addOperationToEmployee02);
            $manager->persist($addOperationToEmployee03);
            $manager->persist($addOperationToEmployee04);

        }

        $operativa = new Operation();
        $operativa->setTitle('Ajudant de guardamolls')
            ->setType('Personal portuari')
            ->setCode('PRC04')
            ->setDateStart(new \DateTime('@'.strtotime('+20 days')))
            ->setDateEnd(new \DateTime('@'.strtotime('+10 hours')))
            ->setHourlyPay(10)
            ->setPort($portBCN)
            ->setDescription('Operativa disponibleee');
        $manager->persist($operativa);

        $operativa = new Operation();
        $operativa->setTitle('Passager helper')
            ->setType('Personal portuari')
            ->setCode('PRC05')
            ->setDateStart(new \DateTime('@'.strtotime('+1 day')))
            ->setDateEnd(new \DateTime('@'.strtotime('+2 hours')))
            ->setHourlyPay(14)
            ->setPort($portBCN)
            ->setDescription('Operativa disponibleee');
        $manager->persist($operativa);

        $manager->flush();
    }
}
