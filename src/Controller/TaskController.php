<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TaskController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="task_index")
     * @Route("/page/{page<[1-9]\d*>}", methods={"GET"}, name="task_index_paginated")
     *
     */
    public function index(Request $request, TaskRepository $tasks): Response
    {

        $page = $request->query->getInt('page', 1);
        $sort = $request->query->get('sort', 'status');

        $latestTasks = $tasks->findLatest($page, $sort);
        $form = $this->createForm(TaskType::class);
        $form->remove('status');

        return $this->render('index.html.twig', [
            'tasks' => $latestTasks,
            'form'  => $form->createView()
        ]);
    }


   /**
     * @Route("/task/new", methods={"POST"}, name="task_new")
     *
     */
    public function taskNew(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $task->setStatus(0);

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_index');
        }

        return $this->render('_form_error.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }








}