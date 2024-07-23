<?php

namespace App\Livewire\User;

use App\Http\Requests\AccountRequest;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AccountPage extends Component
{
    use LivewireAlert;
    public $name;
    public $email;
    public $password;

    public function mount()
    {
        $user = auth()->user();

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateInfomation()
    {
        $request = new AccountRequest();
        $validationData = $request->livewireRules();
    
        $this->validate([
            'name' => $validationData['rules']['name'],
            'email' => $validationData['rules']['email'],
            'password' => $validationData['rules']['password']
        ], $validationData['messages']);
    
        $user = auth()->user();
        // dd($user);
    
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
    
        $this->alert('success', 'Cập nhật tài khoản thành công!', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    
        return redirect()->intended();
    }
    

    public function render()
    {
        return view('livewire.user.account-page');
    }
}
