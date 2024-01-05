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
            return $this->getLessonsAPI();
        } elseif ($request->isMethod('POST')) {
            return $this->postLessonsAPI($request);
        }

        $data = $this->lessonRepository->findAll();
        return $this->json($data);
    }

    public function GetLessonsAPI(): Response
    {
        $data = $this->lessonRepository->findAll();
        return $this->json($data);
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
            'name' => $lesson->getName(),
            'description' => $lesson->getDescription(),
        ], Response::HTTP_CREATED);
    }

}
