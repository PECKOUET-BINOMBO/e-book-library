<!-- Main modal edit -->

<div id="edit-livre-modal-{{$livre->id}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl   font-semibold lien-titre-logo">
                    Modifier informations
                </h3>

                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-livre-modal-{{$livre->id}}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
               
                <form class="space-y-4" action="{{route('admin.livres.update', $livre->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-2">
                        <label for="titre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Titre</label>
                        <input type="text" name="titre" id="titre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" value="{{$livre->titre}}" />
                        @error('titre')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Photo de couverture</label>
                        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="couverture">
                        @error('couverture')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description du livre</label>
                        <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="description">{{$livre->description}}</textarea>
                        @error('description')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="auteur" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Auteur</label>
                        <select id="auteur" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="auteur">
                            @foreach($auteurs as $auteur)
                            <option value="{{$auteur->name}}" {{$auteur->name == $livre->name && $auteur->prenom == $livre->auteur->prenom ? 'selected' : ''}}>{{$auteur->prenom . ' ' . $auteur->name}}</option>
                            @endforeach
                        </select>
                        @error('auteur')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="categorie" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Catégorie</label>
                        <select id="categorie" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="categorie">
                            <option selected>Choisissez une catégorie</option>
                            @foreach($categories as $categorie)
                            <option value="{{$categorie->name}}" {{$categorie->name == $livre->categorie ? 'selected' : ''}}>{{$categorie->name}}</option>
                            @endforeach
                        </select>
                        @error('categorie')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="editeur" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Editeur</label>
                        <select id="editeur" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="editeur">
                            <option selected>Choisissez un éditeur</option>
                            @foreach($editeurs as $editeur)
                            <option value="{{$editeur->name}}" {{$editeur->name == $livre->editeur ? 'selected' : ''}}>{{$editeur->name}}</option>
                            @endforeach
                        </select>
                        @error('editeur')
                        <span class="text-red-500 text-xs mt-1">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="mt-5 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>
