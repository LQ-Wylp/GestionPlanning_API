<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    private LessonRepository $lessonRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(LessonRepository $lessonRepository, EntityManagerInterface $entityManager)
    {
        $this->lessonRepository = $lessonRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/lessons', name: 'api_lesson')]
    public function LessonAPI(Request $request): Response
    {
        $requestMethod = $request->getMethod();

        switch ($requestMethod) {
            case 'GET':
                return $this->getLessonsAPI($request);
                break;

            case 'POST':
                return $this->postLessonsAPI($request);
                break;
            
            case 'PATCH':
                return $this->patchLessonsAPI($request);
                break;

            case 'PUT':
                return $this->putLessonsAPI($request);
                break;

            case 'DELETE':
                return $this->deleteLessonsAPI($request);
                break;

            default:
                throw new \InvalidArgumentException("Méthode HTTP non gérée : $requestMethod");
        }

        $data = $this->lessonRepository->findAll();
        return $this->json($data);
    }

    public function GetLessonsAPI(Request $request): Response
    {
        $id = $request->query->get('id');
        $idTeacher = $request->query->get('idTeacher');
        $name = $request->query->get('name');
        $place = $request->query->get('place');
        $date = $request->query->get('date');

        $criteria = [];

        if ($id !== null) {
            $criteria['id'] = $id;
        }

        if ($idTeacher !== null) {
            $criteria['idTeacher'] = $idTeacher;
        }

        if ($name !== null) {
            $criteria['name'] = $name;
        }

        if ($place !== null) {
            $criteria['place'] = $place;
        }

        $lessons = $this->lessonRepository->findBy($criteria);
        $filteredLessons = [];
        if ($date !== null) {
            foreach($lessons as $lesson)
            {
                if($lesson->getDateBegin()->format("d-m-Y") == $date)
                {
                    $filteredLessons[] = $lesson;
                }
            }
            return $this->json($filteredLessons);
        }

        return $this->json($lessons);
    }

    private function PostLessonsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $lesson = new Lesson();
        $lesson->setIdTeacher($requestData['idTeacher']);
        $lesson->setName($requestData['name']);
        $lesson->setDescription($requestData['description']);

        $dateBegin = new \DateTime($requestData['dateBegin']);
        $dateEnd = new \DateTime($requestData['dateEnd']);

        $lesson->setDateBegin($dateBegin);
        $lesson->setDateEnd($dateEnd);

        $lesson->setPlace($requestData['place']);

        $this->entityManager->persist($lesson);
        $this->entityManager->flush();

        return $this->json([
            'id' => $lesson->getId(),
            'idTeacher' => $lesson->getIdTeacher(),
            'name' => $lesson->getName(),
            'description' => $lesson->getDescription(),
            'dateBegin' => $lesson->getDateBegin(),
            'dateEnd' => $lesson->getDateEnd(),
            'place' => $lesson->getPlace(),
        ], Response::HTTP_CREATED);
    }

    private function PatchLessonsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $lesson = $this->lessonRepository->find($requestData['id']);

        if (!$lesson) {
            return $this->json([
                "message" => "Le cours n'existe pas"
            ], Response::HTTP_NOT_FOUND);
        }

        if (isset($requestData['idTeacher'])) {
            $lesson->setIdTeacher($requestData['idTeacher']);
        }

        if (isset($requestData['name'])) {
            $lesson->setName($requestData['name']);
        }

        if (isset($requestData['description'])) {
            $lesson->setDescription($requestData['description']);
        }

        if (isset($requestData['dateBegin'])) {
            $dateBegin = new \DateTime($requestData['dateBegin']);
            $lesson->setDateBegin($dateBegin);
        }

        if (isset($requestData['dateEnd'])) {
            $dateEnd = new \DateTime($requestData['dateEnd']);
            $lesson->setDateEnd($dateEnd);
        }

        if (isset($requestData['place'])) {
            $lesson->setPlace($requestData['place']);
        }

        $this->entityManager->persist($lesson);
        $this->entityManager->flush();

        return $this->json([
            'id' => $lesson->getId(),
            'idTeacher' => $lesson->getIdTeacher(),
            'name' => $lesson->getName(),
            'description' => $lesson->getDescription(),
            'dateBegin' => $lesson->getDateBegin(),
            'dateEnd' => $lesson->getDateEnd(),
            'place' => $lesson->getPlace(),
        ], Response::HTTP_OK);
    }

    private function PutLessonsAPI(Request $request): Response
    {
        $requestData = json_decode($request->getContent(), true);

        $lesson = $this->lessonRepository->find($requestData['id']);

        if (!$lesson) {
            return $this->json([
                "message" => "Le cours n'existe pas"
            ], Response::HTTP_NOT_FOUND);
        }

        $lesson->setIdTeacher($requestData['idTeacher']);
        $lesson->setName($requestData['name']);
        $lesson->setDescription($requestData['description']);

        $dateBegin = new \DateTime($requestData['dateBegin']);
        $dateEnd = new \DateTime($requestData['dateEnd']);

        $lesson->setDateBegin($dateBegin);
        $lesson->setDateEnd($dateEnd);

        $lesson->setPlace($requestData['place']);

        $this->entityManager->persist($lesson);
        $this->entityManager->flush();

        return $this->json([
            'id' => $lesson->getId(),
            'idTeacher' => $lesson->getIdTeacher(),
            'name' => $lesson->getName(),
            'description' => $lesson->getDescription(),
            'dateBegin' => $lesson->getDateBegin(),
            'dateEnd' => $lesson->getDateEnd(),
            'place' => $lesson->getPlace(),
        ], Response::HTTP_OK);
    }

    private function DeleteLessonsAPI(Request $request): Response
    {
        $id = $request->query->get('id');

        $lesson = $this->lessonRepository->find($id);

        if (!$lesson) {
            return $this->json([
                "message" => "Le cours n'existe pas"
            ], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($lesson);
        $this->entityManager->flush();

        return $this->json([
            "message" => "Le cours a bien été supprimée"
        ], Response::HTTP_OK);
    }
}
