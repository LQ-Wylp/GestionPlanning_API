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
        if ($request->isMethod('GET')) {
            return $this->getLessonsAPI($request);
        } elseif ($request->isMethod('POST')) {
            return $this->postLessonsAPI($request);
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

        $filteredLessons = $this->lessonRepository->findBy($criteria);
        return $this->json($filteredLessons);
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

}
