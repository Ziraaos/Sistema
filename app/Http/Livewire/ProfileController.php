<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class ProfileController extends Component
{
    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile;
    public function render()
    {
        $data = Auth()->user();

        return view('livewire.users.profile', [
            'data' => $data,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $this->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('edit', 'open!');
    }
}
