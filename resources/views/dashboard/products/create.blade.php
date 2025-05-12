<x-layouts.app :title="__('Add New Product')">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl">Add New Product</flux:heading>
        <flux:subheading size="lg" class="mb-6">Create a new product</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Input for product name -->
        <flux:input label="Name" name="name" required class="mb-3" />
        <!-- Textarea for product description -->
        <flux:textarea label="Description" name="description" required class="mb-3" /> 
        <!-- Input for product price -->
        <flux:input label="Price" name="price" type="number" required class="mb-3" /> 

        {{-- Toggle Input Type: File or URL --}}
        <div class="mb-3">
            <label class="block font-semibold mb-1">Image Source</label>
            <label><input type="radio" name="image_source" value="file" checked onchange="toggleImageInput()"> Upload
                File</label>
            <label class="ml-4"><input type="radio" name="image_source" value="url" onchange="toggleImageInput()"> Use
                URL</label>
        </div>

        <!-- File input for image upload -->
        <div id="image-file-input" class="mb-3">
            <flux:input label="Image (Upload)" name="image_file" type="file" />
        </div>

        <!-- URL input for image -->
        <div id="image-url-input" class="mb-3 hidden">
            <flux:input label="Image (URL)" name="image_url" type="text" value="{{ old('image_url') }}" />
        </div>

        
        <div class="mt-4">
            <flux:button type="submit" variant="primary">Save</flux:button>
            <flux:link href="{{ route('products.index') }}" variant="ghost" class="ml-3">Cancel</flux:link>
        </div>
    </form>

    <script>
        // Function to toggle between file input and URL input
        function toggleImageInput() {
            const selected = document.querySelector('input[name="image_source"]:checked').value;
            document.getElementById('image-file-input').classList.toggle('hidden', selected !== 'file');
            document.getElementById('image-url-input').classList.toggle('hidden', selected !== 'url');
        }
    </script>
</x-layouts.app>