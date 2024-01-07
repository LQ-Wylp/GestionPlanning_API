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
        $requestMethod = $request->getMethod();

        switch ($requestMethod) {
            case 'GET':
                return $this->GetClassStudentsAPI($request);
                break;

            case 'POST':
                return $this->PostClassStudentsAPI($request);
                break;
            
            case 'PATCH':
                return $this->PatchClassStudentsAPI($request);
                break;

            case 'PUT':
                return $this->PutClassStudentsAPI($request);
                break;

            case 'DELETE':
                return $this->DeleteClassStudentsAPI($request);
                break;

            default:
                throw new \InvalidArgumentException("Méthode HTTP non gérée : $requestMethod");
        }


        $data = $this->classStudentRepository->findAll();
        return $this->json($data);
    }

    public function GetClassStudentsAPI(Request $request): Response
    {
        $id = $request->query->get('id');
        $idLesson = $request->query->get('idLesson');
        $idUser = $request->query->get('idUser');

        $criteria = [];

        if ($id !== null) {
            $criteria['id'] = $id;
        }

        if ($idLesson !== null) {
            $criteria['idLesson'] = $idLesson;
        }

        $filteredClassStudent = $this->classStudentRepository->findBy($criteria);
        $filteredClassStudentCopie = $filteredClassStudent;


        if ($idUser !== null) {


            foreach ($filteredClassStudentCopie as $key => $class)
            {
                $success = false;

                foreach ($class->getIdUsers() as $student => $idStudent) {
                    if ($idUser === (string) $idStudent) {
                        $success = true;
                    }
                }
                if (!$success) {
                    unset($filteredClassStudent[$key]);
                }
            }
        }

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

    private function PatchClassStudentsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $classStudent = $this->classStudentRepository->find($requestData['id']);

        if (!$classStudent) {
            return $this->json([
                'error' => 'La classe n\'existe pas'
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($requestData['idLesson'])) {
            $classStudent->setIdLesson($requestData['idLesson']);
        }

        if (isset($requestData['idUsers'])) {
            $classStudent->setIdUsers($requestData['idUsers']);
        }

        $this->entityManager->persist($classStudent);
        $this->entityManager->flush();

        return $this->json([
            'id' => $classStudent->getId(),
            'idLesson' => $classStudent->getIdLesson(),
            'idUsers' => $classStudent->getIdUsers(),
        ], Response::HTTP_OK);
    }

    private function PutClassStudentsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $classStudent = $this->classStudentRepository->find($requestData['id']);

        if (!$classStudent) {
            return $this->json([
                'error' => 'La classe n\'existe pas'
            ], Response::HTTP_NOT_FOUND);
        }

        $classStudent->setIdLesson($requestData['idLesson']);
        $classStudent->setIdUsers($requestData['idUsers']);

        $this->entityManager->persist($classStudent);
        $this->entityManager->flush();

        return $this->json([
            'id' => $classStudent->getId(),
            'idLesson' => $classStudent->getIdLesson(),
            'idUsers' => $classStudent->getIdUsers(),
        ], Response::HTTP_OK);
    }

    private function DeleteClassStudentsAPI(Request $request): Response
    {
        $id = $request->query->get('id');

        $classStudent = $this->classStudentRepository->find($id);

        if (!$classStudent) {
            return $this->json([
                'error' => 'La classe n\'existe pas'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($classStudent);
        $this->entityManager->flush();

        return $this->json([
            "message" => "La classe a bien été supprimée"
        ], Response::HTTP_OK);
    }
}
