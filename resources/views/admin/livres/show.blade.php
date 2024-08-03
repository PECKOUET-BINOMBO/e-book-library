<!-- Large Modal -->
<div id="show-livre-modal-{{$livre->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-4xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 relative">
                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                    <!-- mettre en majuscule -->
                    {{ strtoupper($livre->titre) }}
                    <br> <span class="text-gray-500 text-xs">par
                        @if(!empty($livre->auteur))
                        @php
                        $found = false;
                        @endphp
                        @foreach($auteurs as $auteur)
                        <!-- verifier avec le name si l'auteur du livre existe dans la table auteur -->
                        @if($auteur->name == $livre->auteur)


                        {{$livre->auteur}} {{ $auteur->prenom }}
                        @php
                        $found = true;
                        break;
                        @endphp
                        @endif
                        @endforeach
                        @if(!$found)
                        <span>auteur: inconnu</span>
                        @endif
                        @endif

                        / catégorie:
                        @if(!empty($livre->categorie))
                        @php
                        $found = false;
                        @endphp
                        @foreach($categories as $categorie)
                        <!-- verifier avec le name si la categorie du livre existe dans la table categorie -->
                        @if($categorie->name == $livre->categorie)
                        {{$livre->categorie}}
                        @php
                        $found = true;
                        break;
                        @endphp
                        @endif
                        @endforeach
                        @if(!$found)
                        <span>inconnu</span>
                        @endif
                        @endif

                        / éditeur:
                        @if(!empty($livre->editeur))
                        @php
                        $found = false;
                        @endphp
                        @foreach($editeurs as $editeur)
                        <!-- verifier avec le name de l'editeur du livre existe dans la table editeur -->
                        @if($editeur->name == $livre->editeur)
                        {{$livre->editeur}}
                        @php
                        $found = true;
                        break;
                        @endphp
                        @endif
                        @endforeach
                        @if(!$found)
                        <span> éditeur: inconnu</span>
                        @endif
                        @endif

                    </span>
                    @if($livre->statut != 'disponible')
                    <div class="flex items-center p-4 mt-1 text-xs text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div>
                            <span class="font-medium">Ce livre a été emprunté!</span>
                        </div>
                    </div>
                    @endif


                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white absolute top-4 right-5" data-modal-hide="show-livre-modal-{{$livre->id}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <!-- photo de couverture -->
            <div class="flex items-center justify-center p-4 md:p-5">
                <img class="w-40 h-40 rounded-lg" src="{{asset("couverture/$livre->couverture")}}" alt="photo {{$livre->titre}}">
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    {{$livre->description}}
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">

                <button data-modal-hide="show-livre-modal-{{$livre->id}}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Fermer</button>
            </div>
        </div>
    </div>
</div>
