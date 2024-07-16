<?php

namespace App\Livewire\User\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class LoginPage extends Component
{
    use LivewireAlert;
    public $email;
    public $password;

    public function save()
    {
        $request = new LoginRequest();
        $validationData = $request->livewireRules();

        $this->validate([
            'email' => $validationData['rules']['email'],
            'password' => $validationData['rules']['password']
        ], $validationData['messages']);

        if(!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->alert('error', 'Sai thông tin đăng nhập!', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
               ]);
            return;
        }

        return redirect()->intended();
    }
    public function render()
    {
        return view('livewire.user.auth.login-page');
    }
}
