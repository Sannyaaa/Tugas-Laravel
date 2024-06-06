<x-app-layout>
          <x-slot name="header">
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  {{ __('Transaction') }} &raquo; #{{ $transaction->id }} {{ $transaction->name }}
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
                          { data: 'products.name', name: 'products.name' },
                          { data: 'product.price', name: 'product.price' },
                      ]
                      
                  })
      
              </script>
          </x-slot>
      
          <div class="py-12">
              <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
                  <h2 class="font-semibold text-slate-800 text-lg leading-thigh mb-5">
                      {{ __('Trancation Items') }}
                  </h2>
      
                  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                      <div class="p-6 bg-white border-b border-gray-200">
                          <table class="table-auto w-full">
                              <tbody>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Name</th>
                                      <td class="border px-6 py-4">{{ $transaction->name }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">email</th>
                                      <td class="border px-6 py-4">{{ $transaction->email }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">address</th>
                                      <td class="border px-6 py-4">{{ $transaction->address }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Phone</th>
                                      <td class="border px-6 py-4">{{ $transaction->phone }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Courier</th>
                                      <td class="border px-6 py-4">{{ $transaction->courier }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Payment</th>
                                      <td class="border px-6 py-4">{{ $transaction->payment }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Payment Url</th>
                                      <td class="border px-6 py-4">{{ $transaction->payment_url }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Total Price</th>
                                      <td class="border px-6 py-4">{{ number_format($transaction->total_price) }}</td>
                                  </tr>
                                  <tr>
                                      <th class="border px-6 py-4 text-right">Status</th>
                                      <td class="border px-6 py-4">{{ $transaction->status }}</td>
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
      
      
                  <h2 class="font-semibold text-slate-800 text-lg leading-thigh mb-5">
                      {{ __('Trancation Items') }}
                  </h2>
                  <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                      <div class="mb-10">
                          <table id="crudTable" class="min-w-full divide-y divide-gray-200">
                              <thead class="bg-gray-50">
                                  <tr>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          Id
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          Product
                                      </th>
                                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                          Price
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
            