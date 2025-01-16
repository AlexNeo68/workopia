<x-layout>
    <div class="bg-white shadow-md p-8 rounded w-full">
        <h2 class="text-2xl text-center mb-4">Login</h2>
        <form :action="route('login.authenticate')" method="POST" class="w-1/2 mx-auto">
            @csrf

            <x-inputs.text name="email" type="email" placeholder="Email address"></x-inputs.text>
            <x-inputs.text name="password" type="password" placeholder="Password"></x-inputs.text>

            <button type="submit"
                class=" bg-blue-500 hover:bg-blue-600 rounded py-2 px-4 text-white w-full">Login</button>

            <p class="text-gray-500 text-sm mt-4">
                Haven`t an account? <a class="text-blue-700" href="{{ route('register') }}">Register</a>
            </p>
        </form>
    </div>
</x-layout>
