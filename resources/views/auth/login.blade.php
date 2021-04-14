@extends('layout.app')

@section('content')
        <div class="w-8/12 bg-white p-6 rounded-md m-auto">
            @if (session('status'))
                <div class="w-full p-2 mb-4 text-center shadow-md rounded-md text-white text-2xl text-white bg-red-500">
                    {{session('status')}}
                </div>
            @endif
            <form action="{{route('login.store')}}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" value="{{old('email')}}" class="p-4 shadow-md border border-gray-200 rounded-md w-full @error('name')
                        border-red-500
                    @enderror">
                </div>
                @error('email')
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mb-4">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password" placeholder="Your password" class="p-4 shadow-md border border-gray-200 rounded-md w-full @error('name')
                        border-red-500
                    @enderror">
                </div>
                @error('password')
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="p-4 mr-4">
                    <label for="remeber">Remember me</label>
                </div>
                <div>
                    <button type="submit" class="w-full p-2 bg-green-400 shadow-md rounded-md text-white text-2xl font-semibold tracking-widest">Login</button>
                </div>
            </form>
        </div>
@endsection