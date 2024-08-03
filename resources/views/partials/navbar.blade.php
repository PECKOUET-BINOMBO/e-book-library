<nav class="bg-white border-gray-200 dark:border-gray-600 dark:bg-gray-900 shadow fixed  w-full z-20 top-0 start-0">
    <div class="flex flex-wrap justify-between items-center p-4">
        <a href="{{route('accueil')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <h1 class="lien-titre-logo">E-book library</h1>
        </a>
        <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu-full" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <!-- Mega menu -->
        <div id="mega-menu-full" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                <li>
                    <a href="{{route('accueil')}}" class="lien {{request()->routeIs('accueil') ? 'active' : ' '}} block py-2 px-3 border-b border-gray-100 md:hover:bg-transparent md:border-0  md:p-0 " aria-current="page">Accueil</a>
                </li>
               
                @if(auth()->check())
                <li>
                    <div class="flex items-center" id="dropdownDefaultButton" data-dropdown-toggle="dropdown">
                        <div class="flex items-center ms-3">
                            <div>
                                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false">
                                    <span class="sr-only">Open user menu</span>

                                    <img class="w-8 h-8 rounded-full" src="{{ asset('profil/'.auth()->user()->photo) }}" alt="utilisateur photo">
                                </button>
                            </div>

                        </div>
                    </div>
                </li>
                @else
                <li>
                    <a href="#" class="lien" id="dropdownDefaultButton" data-dropdown-toggle="dropdown">Compte <i class="fa-regular fa-user"></i></a>
                </li>
                @endif
            </ul>
        </div>
    </div>



    <!-- Dropdown menu compte-->
    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            @if(auth()->check())
            <li>
                <a href="{{route('profil.index', auth()->user()->id)}}" class="block px-4 py-2 hover:bg-gray-100 text-gray-500 lien">Profil</a>
            </li>
            <li>
                <a href="{{route('auth.logout')}}" class="block px-4 py-2 hover:bg-gray-100 text-gray-500 lien">Déconnexion</a>
            </li>
            @else

            <li>
                <a href="{{route('auth.register.form')}}" class="block px-4 py-2 hover:bg-gray-100 text-gray-500 lien">Inscription</a>
            </li>
            <li>
                <a href="{{route('auth.login.form')}}" class="block px-4 py-2 hover:bg-gray-100 text-gray-500 lien">Connexion</a>
            </li>
            @endif

        </ul>
    </div>


</nav>
