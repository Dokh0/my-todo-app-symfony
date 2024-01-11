<?php

// src/Controller/TaskController.php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/task')]
class TaskController extends AbstractController
{
    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): JsonResponse
    {
        $tasks = $taskRepository->findAll();
        $tasksArray = array_map(function (Task $task) {
            return $task->toArray();
        }, $tasks);

        return new JsonResponse($tasksArray);
    }

    #[Route('/new', name: 'app_task_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $task = new Task();
        // Set the task properties using $data here
        // $task->setTitle($data['title']);
        // $task->setDescription($data['description']);
        // ... other setters as needed
        $entityManager->persist($task);
        $entityManager->flush();

        return new JsonResponse($task->toArray(), JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): JsonResponse
    {
        return new JsonResponse($task->toArray());
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        // Set the task properties using $data here
        // $task->setTitle($data['title']);
        // $task->setDescription($data['description']);
        // ... other setters as needed
        $entityManager->flush();

        return new JsonResponse($task->toArray());
    }

    #[Route('/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(Task $task, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($task);
        $entityManager->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}