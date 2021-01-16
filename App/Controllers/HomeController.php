<?php

namespace App\Controllers;

use App\Models\Task;
use Core\Helpers;
use Core\Controller;
use Core\View;
use Exception;

/**
 * Home controller
 */
class HomeController extends Controller
{
    /** @var Task */
    protected $task;

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];


    /**
     * HomeController constructor.
     * @param $route_params
     */
    public function __construct($route_params)
    {
        $this->task = $this->model('Task');
        $this->route_params = $route_params;
    }

    /**
     * @throws Exception
     */
    public function indexAction()
    {
        $data = $this->task->getTasks(Helpers::parseQueryString());
        View::render('partials/_header.php');
        View::render('task/index.php', [
            'tasks' => $data['tasks'],
            'paginationMeta' => $data['paginationMeta'],
            'paginationLinks' => $data['paginationLinks'],
            'columnsMeta' => $this->task->getColumnsMeta(),
        ]);
        View::render('partials/_footer.php');
    }


    /**
     * @throws Exception
     */
    public function createAction()
    {
        $checkedData = $this->task->validateTaskForm($_POST);
        $newTaskId = Helpers::getFlash('newTaskID');
        Helpers::deleteFlash('newTaskID');

        if ($checkedData['isSubmitForm'] && $checkedData['isValidForm']) {
            $newTask = $this->task->save($checkedData['formData']);
            $newTaskId = $newTask->getId();
            if ($newTaskId) {
                Helpers::setFlash('newTaskID', $newTaskId);
                Helpers::redirectTo('create');
            } else {
                $checkedData['isValidForm'] = false;
                $checkedData['errorMessage'][] = 'Something went wrong! Can\'t edit Task.. Please try again.';
            }
        }
        View::render('partials/_header.php');
        View::render('task/create.php', [
            'newTaskID' => $newTaskId,
            'isAdminAuth' => Helpers::isAdminAuth(),
            'isValidForm' => $checkedData['isValidForm'],
            'isSubmitForm' => $checkedData['isSubmitForm'],
            'errorMessage' => implode(' ', $checkedData['errorMessage']),
            'formData' => $checkedData['formData'],
            'formErrors' => $checkedData['formErrors'],
            'formAction' => Helpers::path('create'),
            'submitAction' => 'createTask',
            'submitLabel' => 'Create Task',
        ]);
        View::render('partials/_footer.php');
    }


    /**
     * @throws Exception
     */
    public function editAction()
    {
        $taskId = $this->route_params['id'];
        if (!Helpers::isAuth()) {
            Helpers::redirectTo('login', ['redirect_to' => 'edit/' . (int)$taskId]);
        }

        $task = $this->task->getById((int)$taskId);
        if (!$task->getId()) {
            Helpers::redirectTo('');
        }

        $checkedData = $this->task->validateTaskForm($_POST);
        $updated = Helpers::getFlash('updated');
        Helpers::deleteFlash('updated');

        if ($checkedData['isSubmitForm']) {
            if ($checkedData['isValidForm']) {
                $updated = $this->task->update($checkedData['formData'], $task);
                if ($updated) {
                    Helpers::setFlash('updated', (bool)$updated);
                    Helpers::redirectTo('edit/' . $task->getId());
                } else {
                    $checkedData['isValidForm'] = false;
                    $checkedData['errorMessage'][] = 'Something went wrong! Can\'t update Task. Please try again.';
                }
            }
        } else {
            $checkedData['formData'] = $task->toArray();
        }
        View::render('partials/_header.php');
        View::render('task/edit.php', [
            'updated' => $updated,
            'isAdminAuth' => Helpers::isAdminAuth(),
            'isValidForm' => $checkedData['isValidForm'],
            'isSubmitForm' => $checkedData['isSubmitForm'],
            'errorMessage' => implode(' ', $checkedData['errorMessage']),
            'formData' => $checkedData['formData'],
            'formErrors' => $checkedData['formErrors'],
            'formAction' => Helpers::path('edit/' . $taskId),
            'submitAction' => 'editTask',
            'submitLabel' => 'Update Task',
        ]);
        View::render('partials/_footer.php');
    }
}
