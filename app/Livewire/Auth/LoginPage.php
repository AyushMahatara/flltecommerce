<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\Session\Session;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Login')]
class LoginPage extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
        ]);

        if (!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->addError('email', 'Invalid email or password.');
            return;
        }
        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.auth.login-page');
    }
}
