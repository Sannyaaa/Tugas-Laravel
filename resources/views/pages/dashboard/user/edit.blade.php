<x-app-layout>
          <x-slot name="header">
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  {{ $user->name }} Edit
              </h2>
          </x-slot>
      
          <div class="py-12">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">

                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            there's something wrong
                        </div>
                        @foreach ($errors->all() as $error)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            {{ $error }}
                        </div>
                        @endforeach
                    @endif

                    <form action="{{ route('user.update', $user->id) }}" class="w-full" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-8">
                                <label for="name" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">name</label>
                                <input type="text" value="{{ old('name') ?? $user->name }}" placeholder="User name" name="name" id="name" 
                                class="block w-full bg-gray-200 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </div>
                            <div class="w-full px-3 mb-8">
                                <label for="roles" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">Roles</label>
                                <select value="" name="roles" id="roles" 
                                class="block w-full bg-gray-200 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">                      
                                    {{-- @foreach ($products as $product) --}}
                                        <option value="{{ $user->roles }}">{{ $user->roles }}</option>
                                        <option disabled>--------------</option>
                                        <option value="ADMIN">ADMIN</option>
                                        <option value="USER">USER</option>
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                            <div class="w-full px-3 mb-8">
                                <label for="email" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">Email</label>
                                <input type="email" value="{{ old('email') ?? $user->email }}" placeholder="User email" name="email" id="email" 
                                class="block w-full bg-gray-200 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </div>
                            <div class="w-full flex justify-between px-5">
                                <button type="reset" class="bg-blue-600 hover:bg-blue-700 text-slate-200 font-medium rounded-lg px-5 py-3">
                                    {{ __('Reset') }}
                                </button>
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-slate-200 font-medium rounded-lg px-5 py-3">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </form>

                  </div>
              </div>
          </div>

          <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
          <script>
            ClassicEditor
            .create( document.querySelector( '#description' ) )
            .catch( error => {
                console.error( error );
            } );
          </script>
      </x-app-layout>
            