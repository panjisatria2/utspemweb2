<x-layouts.app :title="__('Products')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Products</flux:heading>
        <flux:subheading size="lg" class="mb-6">Manage your products</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <!-- Display success or error messages -->
    @if(session()->has('success'))
        <flux:badge color="lime">{{ session('success') }}</flux:badge>
    @endif
    @if($errors->any())
        <flux:badge color="red">{{ $errors->first() }}</flux:badge>
    @endif

    <!-- Search and Add New Product Button -->
    <div class="flex justify-between items-center mb-4">
        <div>
            <flux:input icon="magnifying-glass" placeholder="Search Products" />
        </div>
        <div>
            <flux:link href="{{ route('products.create') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </flux:link>
        </div>
    </div>

    <!-- Product Table -->
    <div class="overflow-x-auto rounded-lg shadow bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                                @php
                                    $isUrl = filter_var($product->image, FILTER_VALIDATE_URL);
                                @endphp

                                <img src="{{ $isUrl ? $product->image : Storage::url($product->image) }}"
                                    alt="{{ $product->name }}" class="h-10 w-10 object-cover rounded">
                            @else
                                <div class="h-10 w-10 bg-gray-200 flex items-center justify-center rounded">
                                    <span class="text-gray-500 text-sm">N/A</span>
                                </div>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->description }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <flux:dropdown>
                                <flux:button icon:trailing="chevron-down">Actions</flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" href="{{ route('products.edit', $product->id) }}">Edit
                                    </flux:menu.item>
                                    <flux:menu.item icon="trash" variant="danger"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this category?')) document.getElementById('delete-form-{{ $product->id }}').submit();">
                                        Delete
                                    </flux:menu.item>
                                    <form id="delete-form-{{ $product->id }}"
                                        action="{{ route('products.destroy', $product->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>