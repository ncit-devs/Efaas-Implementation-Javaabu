<x-guest-layout>

    <section class="relative flex flex-col items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <div class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <img src="{{ asset('/img/eflogo.png') }}" class="w-1/2 max-w-full mb-12" alt="EFaas">
                <h1 class="block">eFaas Demo Implementation</h1>
                <span class="block font-normal text-2xl text-gray-400">View the code <a class="text-blue-800 hover:underline" href="https://github.com/ncit-devs/Efaas-Implementation-Javaabu" target="_blank">here</a></span>
            </div>
            <div class="mt-8 lex lg:ml-6 lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    <a href="{{ route('efaas.redirect') }}" class="inline-flex font-bold items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-800 hover:bg-blue-900">
                        Login with eFaas
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-guest-layout>
