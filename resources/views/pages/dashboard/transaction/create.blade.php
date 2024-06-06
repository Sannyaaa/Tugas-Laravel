<x-app-layout>
          <x-slot name="header">
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  {{ __('Product &raquo;') }}
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

                    <form action="{{ route('product.store') }}" class="w-full" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("POST")

                        <div class="flex flex-wrap -mx-3 mb-6">
                            <div class="w-full px-3 mb-8">
                                <label for="name" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">name</label>
                                <input type="text" value="{{ old('name') }}" placeholder="Product name" name="name" id="name" 
                                class="block w-full bg-gray-200 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </div>
                            <div class="w-full px-3 mb-8">
                                <label for="description" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">Description</label>
                                <textarea placeholder="Product desc" name="description" id="description" 
                                class="block w-full bg-gray-200 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                {{ old('description') }}
                                </textarea>
                            </div>
                            <div class="w-full px-3 mb-8">
                                <label for="price" class="block uppercase tracking-wide text-grey-700 text-xs font-bold mb-2">name</label>
                                <input type="number" value="{{ old('price') }}" placeholder="Product price" name="price" id="price" 
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
            