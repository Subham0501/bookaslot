@extends('layouts.dashboard', ['title' => 'Products'])

@section('content')
<div class="space-y-12">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-black text-gray-900 dark:text-white mb-2">My Showcase 🛍️</h1>
            <p class="text-gray-500 dark:text-[#94a3b8]">Manage your items, prices, and availability.</p>
        </div>
        <div class="flex gap-4">
            <button onclick="document.getElementById('addCategoryModal').classList.remove('hidden')" class="bg-gray-100 dark:bg-[#1e293b] text-gray-900 dark:text-white px-8 py-3 rounded-2xl font-black flex items-center gap-2 hover:shadow-xl transition-all active:scale-95">
                <span>📂</span> Categories
            </button>
            <button onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="bg-[#ff6b6b] text-white px-8 py-3 rounded-2xl font-black flex items-center gap-2 hover:shadow-xl transition-all active:scale-95">
                <span>➕</span> Add Product
            </button>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="bg-white dark:bg-[#1e293b] rounded-[2.5rem] p-6 shadow-xl border border-gray-100 dark:border-[#334155] relative group">
            <div class="aspect-square rounded-[2rem] bg-gray-100 dark:bg-[#0f172a] mb-6 overflow-hidden relative">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-5xl">📦</div>
                @endif
                
                @if($product->is_featured)
                <div class="absolute top-4 left-4 bg-amber-400 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full shadow-lg">Featured</div>
                @endif
            </div>

            <h3 class="text-xl font-black text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-4">{{ $product->category->name }}</p>
            
            <div class="flex items-center justify-between mb-6">
                <div class="flex flex-col">
                    <span class="text-2xl font-black text-[#ff6b6b]">Rs {{ number_format($product->price) }}</span>
                    @if($product->discount_price)
                    <span class="text-sm text-gray-400 line-through">Rs {{ number_format($product->discount_price) }}</span>
                    @endif
                </div>
                <div class="px-3 py-1 {{ $product->is_in_stock ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }} rounded-xl text-xs font-black uppercase tracking-tight">
                    {{ $product->is_in_stock ? 'In Stock' : 'Out Stock' }}
                </div>
            </div>

            <div class="flex gap-2">
                <button onclick="editProduct({{ json_encode($product) }})" class="flex-grow py-3 bg-gray-50 dark:bg-[#0f172a] text-gray-900 dark:text-white rounded-xl font-black text-sm hover:bg-gray-100 transition-all">Edit</button>
                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-12 h-12 flex items-center justify-center bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition-all">🗑️</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="text-6xl mb-6">🏜️</div>
            <h2 class="text-2xl font-black text-gray-300">No products yet.</h2>
            <p class="text-gray-400 font-bold mt-2">Click "Add Product" to start filling your digital shelf.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-2xl w-full max-w-xl p-10">
            <h2 class="text-3xl font-black mb-8 text-gray-900 dark:text-white">New Product</h2>
            
            <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Product Name</label>
                    <input type="text" name="name" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Price (Rs)</label>
                        <input type="number" name="price" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Category</label>
                        <select name="category_id" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                            @if($categories->isEmpty())
                                <option value="" disabled selected>Please create a category first</option>
                            @else
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($categories->isEmpty())
                            <p class="text-[10px] text-[#ff6b6b] font-black uppercase tracking-widest mt-1 cursor-pointer" onclick="document.getElementById('addProductModal').classList.add('hidden'); document.getElementById('addCategoryModal').classList.remove('hidden');">
                                ➕ Create your first category here
                            </p>
                        @endif
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Product Photo</label>
                    <input type="file" name="image" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 font-bold text-gray-900 dark:text-white">
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b6b] text-white rounded-2xl font-black text-xl shadow-xl shadow-[#ff6b6b]/20">Save Product</button>
            </form>
        </div>
    </div>
</div>
<!-- Add Category Modal -->
<div id="addCategoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-2xl w-full max-w-sm p-10">
            <h2 class="text-3xl font-black mb-8 text-gray-900 dark:text-white">New Category</h2>
            
            <form action="{{ route('dashboard.categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g., Summer Wear, Electronics" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b6b] text-white rounded-2xl font-black text-xl shadow-xl shadow-[#ff6b6b]/20">Create Category</button>
            </form>
        </div>
    </div>
</div>

@endsection

<!-- Edit Product Modal -->
<div id="editProductModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="this.parentElement.parentElement.classList.add('hidden')"></div>
        
        <div class="relative bg-white dark:bg-[#1e293b] rounded-[3rem] shadow-2xl w-full max-w-xl p-10">
            <h2 class="text-3xl font-black mb-8 text-gray-900 dark:text-white">Edit Product</h2>
            
            <form id="editProductForm" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Product Name</label>
                    <input type="text" name="name" id="edit_name" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Price (Rs)</label>
                        <input type="number" name="price" id="edit_price" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Category</label>
                        <select name="category_id" id="edit_category_id" required class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                     <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Stock Status</label>
                     <select name="is_in_stock" id="edit_is_in_stock" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#ff6b6b] font-bold text-gray-900 dark:text-white">
                         <option value="1">In Stock</option>
                         <option value="0">Out of Stock</option>
                     </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black uppercase text-gray-400 tracking-widest">Product Photo</label>
                    <input type="file" name="image" class="w-full bg-gray-50 dark:bg-[#0f172a] border-none rounded-2xl p-4 font-bold text-gray-900 dark:text-white">
                    <p class="text-xs text-gray-400">Leave empty to keep current image</p>
                </div>

                <button type="submit" class="w-full py-5 bg-[#ff6b6b] text-white rounded-2xl font-black text-xl shadow-xl shadow-[#ff6b6b]/20">Update Product</button>
            </form>
        </div>
    </div>
</div>

<script>
    function editProduct(product) {
        document.getElementById('editProductModal').classList.remove('hidden');
        
        // Set form action
        const form = document.getElementById('editProductForm');
        form.action = `/dashboard/products/${product.id}`;
        
        // Populate fields
        document.getElementById('edit_name').value = product.name;
        document.getElementById('edit_price').value = product.price;
        document.getElementById('edit_category_id').value = product.category_id;
        document.getElementById('edit_is_in_stock').value = product.is_in_stock ? '1' : '0';
    }
</script>
