@extends('../layouts.app')

@section('title', 'Accueil')
@section('content')

<section class=" py-8 antialiased  md:py-12 mt-10">
    @if(session('success'))

    <div x-data="{show:true}" x-init="setTimeout(() => {show = false}, 5000)" x-show.transition.duration.1000ms="show" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div class="ms-3 text-sm font-medium">
            {{session('success')}}
        </div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    </div>
    @endif
    @if(session('error'))
    <div x-data="{show:true}" x-init="setTimeout(() => {open = false}, 5000)" x-show.transition.duration.1000ms="show" id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>
        <span class="sr-only">Info</span>
        <div class="ms-3 text-sm font-medium">
            {{session('error')}}
        </div>

    </div>
    @endif
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
        <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
            <div>
                <h2 class="mt-3 text-xl font-semibold text-gray-900">DÉCOUVREZ TOUS NOS NOS E-BOOK <span class="font-medium text-gray-500 text-base">({{$livres->count() }})</span></h2>
                <p class="text-gray-500 text-sm">Parcourez notre bibliothèque de livres électroniques</p>
            </div>
        </div>
        <!-- trier par catégorie -->
        <div class="flex flex-col justify-between mb-4 space-x-4">

            <div class="relative flex items-center w-full max-w-md mb-5">
                <form method="GET" action="{{ route('accueil') }}">
                    <select class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" name="categorie" id="categorie" onchange="this.form.submit()">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $categorie)
                        <option value="{{ $categorie->name }}" {{ request('categorie') == $categorie->name ? 'selected' : '' }}>{{ $categorie->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>


            @if ($livres->isEmpty())
            <div class="text-center text-green-800 bg-green-50 font-medium border rounded p-4 mb-4">
                <p>Aucun livre disponible pour le moment</p>
            </div>
            @else
            <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-4 xl:grid-cols-4">
                <!-- Card e-book-->
                @foreach ($livres as $livre)
                <div class="flex flex-col overflow-hidden bg-white border rounded-lg shadow-sm relative" data-modal-target="large-modal-{{$livre->id}}" data-modal-toggle="large-modal-{{$livre->id}}">
                    <div class="">
                        <img src="{{asset("couverture/$livre->couverture")}}" alt="book" class="w-full  object-fit-cover">
                        <!-- <span class="absolute top-2 right-2 px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded">New</span> -->
                    </div>
                </div>

                @include('livres.show')
                @endforeach
            </div>
            @endif
        </div>
    </div>
    {{$livres->links()}}
</section>
@endsection
