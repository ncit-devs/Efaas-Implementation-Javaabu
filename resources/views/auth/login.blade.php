<x-guest-layout>
    <section class="relative flex flex-col items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">

        <img src="{{ asset('/img/eflogo.png') }}" class="w-25 mb-12" alt="EFaas">

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <button href="#" class="hover:bg-gray-500 uppercase bg-transparent hover:bg-blue text-blue-dark font-semibold hover:text-white py-2 px-4 border border-blue hover:border-transparent rounded">
                Click to login wih EFaas
            </button>
        </form>
    </section>
</x-guest-layout>
