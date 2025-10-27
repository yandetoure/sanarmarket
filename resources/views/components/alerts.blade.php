@if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('.fixed.top-4.right-4').remove();
        }, 5000);
    </script>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2">
        <i data-lucide="alert-circle" class="w-5 h-5"></i>
        {{ session('error') }}
    </div>
    <script>
        setTimeout(() => {
            document.querySelector('.fixed.top-4.right-4').remove();
        }, 5000);
    </script>
@endif

