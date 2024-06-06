<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }} Gallery
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>

            var datatable = $('#crudTable').DataTable({
                ajax : {
                    url: '{!!  url()->current() !!}',
                },
                columns: [
                    { data: 'id', name: 'id', width: '5%' },
                    { data: 'url', name: 'url' },
                    { data: 'is_featured', name: 'is_featured' },
                    { data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%',   
                    }
                ]
                
            })

        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                <div class="mb-10">
                    <a href="{{ route('product.gallery.create', $product->id) }}" class="bg-green-600 hover:bg-green-700 text-slate-200 font-medium rounded-lg px-5 py-3">
                        Upload Photos
                    </a>
                </div>
                <div class="mb-10">
                    <table id="crudTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Id
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Photo
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Featured
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- @foreach ($products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $product->name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $product->price }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
      