<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6">Customer Listing</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Dropdown for Import/Export -->
        <div class="mb-6">
            <div class="relative inline-block text-left">
                <button type="button" class="btn btn-primary">
                    Options
                </button>
                <div class="dropdown-content absolute hidden bg-white text-black shadow-lg rounded-md w-48 mt-1 z-10">
                    {{-- <a href="{{ route('admin.customers.export') }}" class="block px-4 py-2">Export</a> --}}
                    {{-- <a href="{{ route('admin.customers.import') }}" class="block px-4 py-2">Import</a> --}}
                </div>
            </div>
        </div>

        <!-- DataTable for Customer Listing -->
        <table class="table table-zebra w-full" id="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>

    <script>
        $(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('customers.index') }}',  
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'mobile', name: 'mobile' },
                    {
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="{{ url('customers/edit') }}/${row.id}" class="btn btn-primary btn-sm">Edit</a>
                                <button data-id="${row.id}" class="btn btn-error btn-sm delete-btn">Delete</button>
                            `;
                        }
                    }
                ]
            });

            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
                var customerId = $(this).data('id');

                if (confirm('Are you sure you want to delete this customer?')) {
                    $.ajax({
                        url: '{{ url('customers') }}/' + customerId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            alert(response.success);  
                            table.ajax.reload();  
                        },
                        error: function() {
                            alert('Error deleting customer');
                        }
                    });
                }
            });

            // Dropdown Toggle
            $('.btn-primary').on('click', function() {
                $(this).next('.dropdown-content').toggleClass('hidden');
            });

            // Close dropdown if clicked outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.btn-primary').length) {
                    $('.dropdown-content').addClass('hidden');
                }
            });
        });
    </script>
</x-app-layout>
