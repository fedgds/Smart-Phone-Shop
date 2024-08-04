<?php

namespace App\Livewire\User\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
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
        $val = $request->livewireRules();

        $this->validate([
            'email' => $val['rules']['email'],
            'password' => $val['rules']['password']
        ], $val['messages']);

        if(!auth()->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->alert('error', 'Sai thông tin đăng nhập!', [
                'position' => 'top',
                'timer' => 3000,
                'toast' => true,
               ]);
            return;
        }

        return redirect()->to('/');
    }
    public function render()
    {
        return view('livewire.user.auth.login-page');
    }
}
