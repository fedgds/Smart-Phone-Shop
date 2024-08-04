<?php

namespace App\Livewire\User\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RegisterPage extends Component
{
    use LivewireAlert;
    public $name;
    public $email;
    public $password;

    public function save()
    {
        $request = new RegisterRequest();
        $val = $request->livewireRules();

        $this->validate([
            'name' => $val['rules']['name'],
            'email' => $val['rules']['email'],
            'password' => $val['rules']['password']
        ], $val['messages']);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            // 'password' => Hash::make($this->password)
            'password' => bcrypt($this->password)
        ]);

        $this->alert('success', 'Đăng ký tài khoản thành công!', [
            'position' => 'top',
            'timer' => 3000,
            'toast' => true,
        ]);
        auth()->login($user);

        return redirect()->to('/login');
    }
    public function render()
    {
        return view('livewire.user.auth.register-page');
    }
}
