<?php

namespace App\Controller;

use App\Entity\ClassStudent;
use App\Repository\ClassStudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassStudentController extends AbstractController
{
    private ClassStudentRepository $classStudentRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(ClassStudentRepository $classStudentRepository, EntityManagerInterface $entityManager)
    {
        $this->classStudentRepository = $classStudentRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/classStudents', name: 'api_students')]
    public function ClassStudentAPI(Request $request): Response
    {
        if ($request->isMethod('GET')) {
            return $this->GetClassStudentsAPI($request);
        } elseif ($request->isMethod('POST')) {
            return $this->PostClassStudentsAPI($request);
        }

        $data = $this->classStudentRepository->findAll();
        return $this->json($data);
    }

    public function GetClassStudentsAPI(Request $request): Response
    {
        $id = $request->query->get('id');
        $idLesson = $request->query->get('idLesson');

        $criteria = [];

        if ($id !== null) {
            $criteria['id'] = $id;
        }

        if ($idLesson !== null) {
            $criteria['idLesson'] = $idLesson;
        }

        $filteredClassStudent = $this->classStudentRepository->findBy($criteria);

        return $this->json($filteredClassStudent);
    }

    private function PostClassStudentsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $classStudent = new ClassStudent();

        $classStudent->setIdLesson($requestData['idLesson']);
        $classStudent->setIdUsers($requestData['idUsers']);

        $this->entityManager->persist($classStudent);
        $this->entityManager->flush();

        return $this->json([
            'id' => $classStudent->getId(),
            'idLesson' => $classStudent->getIdLesson(),
            'idUsers' => $classStudent->getIdUsers(),
        ], Response::HTTP_CREATED);
    }
}
