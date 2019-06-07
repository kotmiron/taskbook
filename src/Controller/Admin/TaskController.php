<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/admin/task")
 * @IsGranted("ROLE_ADMIN")
 *
 */
class TaskController extends AbstractController
{
    /**
     * Список задач
     *
     * @Route("/", methods={"GET"}, name="admin_index")
     * @Route("/", methods={"GET"}, name="admin_task_index")
     */
    public function index(TaskRepository $tasks): Response
    {
        $tasks = $tasks->findBy(array(), ['id' => 'ASC']);

        return $this->render('admin/task/index.html.twig', ['tasks' => $tasks]);
    }

    /**
     * Форма для редактирования задачи
     *
     * @Route("/{id<\d+>}/edit",methods={"GET", "POST"}, name="admin_task_edit")
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_task_index');
        }

        return $this->render('admin/task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

}
