<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers;
use Core\Controller;
use Core\View;
use Exception;

class UserController extends Controller
{
    /** @var User */
    protected $userModel;

    /**
     * Create new UserController instance.
     */
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    /**
     * @return void
     */
    public function indexAction()
    {
        try {
            $this->loginAction();
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function loginAction()
    {
        if (Helpers::isAuth()) {
            Helpers::redirectTo('');
        }
        $checkedData = $this->userModel->validateLoginForm($_POST);
        $parsedQueryString = Helpers::clean(Helpers::parseQueryString());

        if ($checkedData['isSubmitForm'] && $checkedData['isValidForm']) {
            $authUser = $this->userModel->getByCredentials($checkedData['formData']);
            if ($authUser->getId()) {
                Helpers::auth($authUser->getId());
                Helpers::redirectTo($checkedData['formData']['redirectTo'] ?? '');
            } else {
                $checkedData['isValidForm'] = false;
                $checkedData['errorMessage'][] = 'Wrong data. Try again';
            }
        }

        try {
            View::render('partials/_header.php');
            View::render('auth/login.php', [
                'isValidForm' => $checkedData['isValidForm'],
                'isSubmitForm' => $checkedData['isSubmitForm'],
                'errorMessage' => implode(' ', $checkedData['errorMessage']),
                'formData' => $checkedData['formData'],
                'formErrors' => $checkedData['formErrors'],
                'formAction' => Helpers::path('login'),
                'submitAction' => 'login',
                'submitLabel' => 'Login',
                'redirectTo' => $parsedQueryString['redirect_to'] ?? '',
            ]);
            View::render('partials/_footer.php');
        } catch (Exception $e) {
        }
    }

    /**
     * @return void
     */
    public function logoutAction()
    {
        Helpers::logout();
        Helpers::redirectTo('login');
    }
}
