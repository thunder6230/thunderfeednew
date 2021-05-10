@extends('layout.app')

@section('content')
        <div class="w-8/12 bg-white p-6 rounded-md m-auto">
            <form action="{{route('register.store')}}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" value="{{old('name')}}" class="p-4 shadow-md border border-gray-200 rounded-md w-full @error('name')
                        border-red-500
                    @enderror">
                </div>
                @error('name')
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                @enderror
                <div class="mb-4">
                    <label for="username" class="sr-only">Username</label>
                    <input type="text" id="username" name="username" placeholder="Your Username" value="{{old('username')}}" class="p-4 shadow-md border border-gray-200 rounded-md w-full @error('name')
                        border-red-500
                    @enderror">
                </div>
                @error('username')
                    <div class="text-red-500">
                        {{ $message }}
                    </div>
                @enderror
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
                <div class="mb-4">
                    <label for="password_confirmation" class="sr-only">Repeat Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat password" class="p-4 shadow-md border border-gray-200 rounded-md w-full @error('name')
                        border-red-500
                    @enderror">
                </div>
                <div class="mb-4 flex justify-center items-center">
                    <div class="mr-5 flex justify-center items-center">

                        <label for="male" class=""><i class="fas fa-mars text-4xl text-blue-600"></i>
                            <input type="radio" id="male" name="gender" value="male"class="">
                        </label>
                    </div>
                    <div>

                        <label for="female" class=""><i class="fas fa-venus text-4xl text-pink-500"></i>
                            <input type="radio" id="female" name="gender" value="female" class="">
                        </label>
                    </div>
                </div>
                <div>
                    <button type="submit" class="w-full p-2 bg-green-400 shadow-md rounded-md text-white text-2xl font-semibold tracking-widest">Register</button>
                </div>
            </form>
        </div>
@endsection