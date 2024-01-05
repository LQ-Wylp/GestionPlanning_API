<?php

namespace App\Controller;

use App\Repository\ClassStudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassStudentController extends AbstractController
{
    private ClassStudentRepository $classStudentRepository;

    public function __construct(ClassStudentRepository $classStudentRepository)
    {
        $this->classStudentRepository = $classStudentRepository;
    }

    #[Route('/students', name: 'api_class_student')]
    public function ClassStudentAPI(): Response
    {
        $data = $this->classStudentRepository->findAll();
        return $this->json($data);
    }
}
