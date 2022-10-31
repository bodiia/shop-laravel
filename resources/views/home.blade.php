@extends('layouts.auth')

@section('content')
    @auth
        <form action="{{ route('signin.logout') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Выйти</button>
        </form>
    @endauth
@endsection
