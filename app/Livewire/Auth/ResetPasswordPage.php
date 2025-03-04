<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

#[Title('Reset Password')]
class ResetPasswordPage extends Component
{
    public $token;
    public $password;
    public $password_confirmation;
    #[Url()]
    public $email;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function resetPassword()
    {
        $this->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $status = Password::reset([
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
            'token' => $this->token
        ], function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('success', 'Password has been reset successfully.');
            $this->email = '';
            $this->password = '';
            $this->password_confirmation = '';
        } else {
            $this->addError('issue', 'Failed to reset password.');
        }
        return redirect(route('login'));
    }
    public function render()
    {
        return view('livewire.auth.reset-password-page');
    }
}
