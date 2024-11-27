<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <table id="table" class="min-w-full table-auto bg-white dark:bg-gray-800 border-collapse text-left border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-gray-600 dark:text-gray-200 font-semibold border-b">Id</th>
                    <th class="px-4 py-2 text-gray-600 dark:text-gray-200 font-semibold border-b">Name</th>
                    <th class="px-4 py-2 text-gray-600 dark:text-gray-200 font-semibold border-b">Email</th>
                    <th class="px-4 py-2 text-gray-600 dark:text-gray-200 font-semibold border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <!-- Data will be dynamically loaded here -->
            </tbody>
        </table>
    </div>

    <script>
        $(function() {
            // Function to apply dark mode styles
            function applyDarkModeStyles() {
                const isDark = document.documentElement.classList.contains('dark');

                // Apply styles to DataTable elements
                $('.dataTables_filter input').toggleClass('bg-gray-700 text-gray-200 border-gray-600', isDark);
                $('.dataTables_filter input').toggleClass('bg-white text-gray-900 border-gray-300', !isDark);

                $('.dataTables_length select').toggleClass('bg-gray-700 text-gray-200 border-gray-600', isDark);
                $('.dataTables_length select').toggleClass('bg-white text-gray-900 border-gray-300', !isDark);
            }

            // Initialize DataTable
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('user/view') }}', // Fetch data from this route
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="/user/${row.id}/edit" class="inline-block px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">Edit</a>
                                <a href="javascript:void(0);" data-id="${row.id}" class="delete-btn inline-block px-3 py-1 text-sm text-white bg-red-500 rounded hover:bg-red-600">Delete</a>
                            `;
                        }
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Apply dark mode styles to rows
                    if (document.documentElement.classList.contains('dark')) {
                        $(row).addClass('dark:bg-gray-700 dark:text-gray-200');
                    }
                },
                initComplete: function() {
                    // Apply dark mode styles on initialization
                    applyDarkModeStyles();
                }
            });

            // Reapply styles on redraw
            table.on('draw', function() {
                applyDarkModeStyles();
            });

            // Delete user logic
            $(document).on('click', '.delete-btn', function() {
                const userId = $(this).data('id');
                if (confirm('Are you sure you want to delete this user?')) {
                    $.ajax({
                        url: `/user/${userId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            alert(response.success || 'User deleted successfully!');
                            table.ajax.reload(); // Reload the DataTable
                        },
                        error: function(xhr) {
                            alert('Failed to delete user. Please try again.');
                        }
                    });
                }
            });

            // Toggle dark mode
            document.getElementById('toggleDarkMode').addEventListener('click', function() {
                document.documentElement.classList.toggle('dark');
                applyDarkModeStyles();
            });
        });
    </script>
</x-app-layout>
