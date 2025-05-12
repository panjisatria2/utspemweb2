<x-layouts.app :title="__('Edit Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Edit Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Update the product details</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input for product name -->
        <flux:input label="Name" name="name" value="{{ old('name', $product->name) }}" required class="mb-3" />
        <!-- Textarea for product description -->
        <flux:textarea label="Description" name="description" required class="mb-3">{{ old('description', $product->description) }}</flux:textarea>
        <!-- Input for product price -->
        <flux:input label="Price" name="price" type="number" value="{{ old('price', $product->price) }}" required class="mb-3" />

        {{-- Image Source Toggle --}}
        <div class="mb-3">
            <label class="block font-semibold mb-1">Image Source</label>
            <label>
                <input type="radio" name="image_source" value="file" {{ old('image_source', 'file') === 'file' ? 'checked' : '' }} onchange="toggleImageInput()"> Upload File
            </label>
            <label class="ml-4">
                <input type="radio" name="image_source" value="url" {{ old('image_source') === 'url' ? 'checked' : '' }} onchange="toggleImageInput()"> Use URL
            </label>
        </div>

        <!-- File input for image upload -->
        <div id="image-file-input" class="mb-3">
            <flux:input label="Image (Upload)" name="image_file" type="file" />
        </div>

        <!-- URL input for image -->
        <div id="image-url-input" class="mb-3 hidden">
            <flux:input label="Image (URL)" name="image_url" type="text" value="{{ old('image_url', $product->image ?? '') }}" />
        </div>

        <div class="mt-4">
            <flux:button type="submit" variant="primary">Update</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Cancel</flux:link>
        </div>
    </form>

    <script>
        // Function to toggle between file input and URL input 
        function toggleImageInput() {
            const source = document.querySelector('input[name="image_source"]:checked').value;
            document.getElementById('image-file-input').classList.toggle('hidden', source !== 'file');
            document.getElementById('image-url-input').classList.toggle('hidden', source !== 'url');
        }

        // Trigger once on page load to reflect selected input
        document.addEventListener('DOMContentLoaded', toggleImageInput);
    </script>
</x-layouts.app>