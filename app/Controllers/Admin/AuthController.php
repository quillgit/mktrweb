<?php

namespace Mktr\Controllers\Admin;

use Mktr\Core\Auth;
use Mktr\Core\Controller;
use Mktr\Core\Response;
use Mktr\Core\Session;
use Mktr\Core\Validator;
use Mktr\Core\View;

class AuthController extends Controller
{
    public function showLogin(array $params): Response
    {
        if (Auth::check($this->request)) {
            return $this->redirect($this->route('admin.dashboard'));
        }

        $response = Response::html(View::render('admin.auth.login', [
            'flashError' => Session::pull('error', ''),
            'formErrors' => Session::pull('errors', []),
        ]));

        Session::clearOldInput();

        return $response->withHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function login(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        $username = $this->request->text('username');
        $password = (string) $this->request->input('password', '');

        $validator = new Validator(
            ['username' => $username, 'password' => $password],
            ['username' => 'Nama pengguna', 'password' => 'Kata sandi']
        );

        if (!$validator->validate(['username' => 'required|max:64', 'password' => 'required'])) {
            $this->withErrors($validator->firstErrors(), ['username' => $username]);

            return $this->redirect($this->route('admin.login'));
        }

        if (Auth::isLockedOut($username)) {
            Session::flash('error', 'Terlalu banyak percobaan masuk. Coba lagi dalam 15 menit.');

            return $this->redirect($this->route('admin.login'));
        }

        if (!Auth::attempt($username, $password, $this->request)) {
            // Deliberately does not say which of the two was wrong.
            Session::flash('error', 'Nama pengguna atau kata sandi salah.');
            Session::flashInput(['username' => $username]);

            return $this->redirect($this->route('admin.login'));
        }

        return $this->redirect($this->route('admin.dashboard'));
    }

    public function logout(array $params): Response
    {
        $invalid = $this->verifyCsrf();
        if ($invalid !== null) {
            return $invalid;
        }

        Auth::logout();

        return $this->redirect($this->route('admin.login'));
    }
}
