@extends('layouts.auth')

@section('title', 'Сброс пароля')

@section('content')
    <x-forms.auth-forms title="Сброс пароля" action="" method="POST">
        @csrf

        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            :invalid="$errors->has('email')"></x-forms.text-input>
        @error('email')
            <x-forms.error>
                {{ $message }}
            </x-forms.error>
        @enderror

        <x-forms.primary-button type="submit">Отправить</x-forms.primary-button>

        <x-slot:social></x-slot:social>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs">
                    <a href="{{ route('login.form') }}" class="text-white hover:text-white/70 font-bold">Войти в аккаунт</a>
                </div>
            </div>
        </x-slot:buttons>
    </x-forms.auth-forms>
@endsection
