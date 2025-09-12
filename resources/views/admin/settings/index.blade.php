@extends('layouts.admin-layout')

@push('scripts')
<script>
    function ensureToastifyLoaded() {
        if (typeof Toastify === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/toastify-js';
            script.onload = function() {
                // Add default styles if they don't exist
                if (!document.getElementById('toastify-styles')) {
                    const link = document.createElement('link');
                    link.id = 'toastify-styles';
                    link.rel = 'stylesheet';
                    link.href = 'https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css';
                    document.head.appendChild(link);
                }
            };
            document.head.appendChild(script);
            return false;
        }
        return true;
    }

    function showToast(options) {
        if (!ensureToastifyLoaded()) {
            // If Toastify is not loaded yet, try again after a short delay
            setTimeout(() => showToast(options), 100);
            return;
        }

        const defaultOptions = {
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            stopOnFocus: true,
            ariaLive: 'polite'
        };

        Toastify(Object.assign({}, defaultOptions, options)).showToast();
    }
    function toggleEditMode(button) {
        const row = button.closest('tr');
        const valueCell = row.querySelector('.value-cell');
        const valueDisplay = valueCell.querySelector('.value-display');
        const valueInput = valueCell.querySelector('.value-input');
        const editButton = row.querySelector('.edit-button');
        const saveButton = row.querySelector('.save-button');
        const cancelButton = row.querySelector('.cancel-button');

        if (valueDisplay.classList.contains('hidden')) {
            // Cancel edit mode
            valueDisplay.classList.remove('hidden');
            valueInput.classList.add('hidden');
            editButton.classList.remove('hidden');
            saveButton.classList.add('hidden');
            cancelButton.classList.add('hidden');
        } else {
            // Enter edit mode
            valueDisplay.classList.add('hidden');
            valueInput.classList.remove('hidden');
            editButton.classList.add('hidden');
            saveButton.classList.remove('hidden');
            cancelButton.classList.remove('hidden');
            valueInput.focus();
        }
    }

    function saveSetting(form, event) {
        console.log('Form submission started');
        if (event) {
            event.preventDefault();
        }

        const formData = new FormData(form);
        console.log('Form data:', Object.fromEntries(formData.entries()));

        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton ? submitButton.innerHTML : '';

        // Show loading state
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        }

        // Add a small delay to ensure the UI updates
        setTimeout(() => {

            console.log('Sending request to:', form.action);
            fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: formData
        })
        .then(async response => {
            console.log('Response status:', response.status);
            const responseData = await response.json().catch(() => ({}));
            console.log('Response data:', responseData);

            if (!response.ok) {
                const errorMsg = responseData.message || 'Network response was not ok';
                console.error('Error response:', errorMsg);
                throw new Error(errorMsg);
            }
            if (responseData.success) {
                const data = responseData;
                const row = form.closest('tr');
                const valueDisplay = row.querySelector('.value-display');
                const valueInput = row.querySelector('input[name="value"]');

                // Update the displayed value with the server response
                valueDisplay.textContent = data.setting.value;
                valueInput.value = data.setting.value;

                // Get the buttons before exiting edit mode
                const editButton = row.querySelector('.edit-button');
                const saveButton = row.querySelector('.save-button');
                const cancelButton = row.querySelector('.cancel-button');

                // Exit edit mode immediately
                valueDisplay.classList.remove('hidden');
                valueInput.classList.add('hidden');
                editButton.classList.remove('hidden');
                saveButton.classList.add('hidden');
                cancelButton.classList.add('hidden');

                // Show success message after UI has updated
                setTimeout(() => {
                    showToast({
                        text: 'Setting updated successfully',
                        backgroundColor: 'green',
                        duration: 3000
                    });
                }, 100);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'Error updating setting';

            if (error instanceof Error) {
                errorMessage += ': ' + error.message;
            } else if (typeof error === 'string') {
                errorMessage += ': ' + error;
            } else if (error && error.message) {
                errorMessage += ': ' + error.message;
            }

            showToast({
                text: errorMessage,
                backgroundColor: 'red',
                duration: 5000
            });
        })
        .finally(() => {
            // Reset button state
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
        }, 100);  // End of setTimeout

        return false;
    }
</script>
@endpush

@section('content')
<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Settings</h2>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($settings as $setting)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $setting->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 value-cell">
                            <span class="value-display">{{ $setting->value }}</span>
                            <form id="form-{{ $setting->id }}"
                                  action="{{ route('admin.settings.update', $setting) }}"
                                  method="POST"
                                  class="hidden value-input"
                                  onsubmit="return saveSetting(this, event)">
                                @csrf
                                @method('PUT')
                                <div class="flex items-center">
                                    @if($setting->key === 'vat')
                                        <div class="relative rounded-md shadow-sm">
                                            <input type="text"
                                                   name="value"
                                                   value="{{ $setting->value }}"
                                                   class="focus:ring-green-500 focus:border-green-500 block w-24 pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                                   required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            </div>
                                        </div>
                                    @else
                                        <input type="text"
                                               name="value"
                                               value="{{ $setting->value }}"
                                               class="focus:ring-green-500 focus:border-green-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                               required>
                                    @endif
                                </div>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <button type="button"
                                        onclick="toggleEditMode(this)"
                                        class="text-blue-600 hover:text-blue-900 mr-2 edit-button">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="button"
                                        onclick="document.getElementById('form-{{ $setting->id }}').dispatchEvent(new Event('submit', { cancelable: true }))"
                                        class="text-green-600 hover:text-green-900 mr-2 save-button hidden">
                                    <i class="fas fa-check"></i>
                                </button>

                                <button type="button"
                                        onclick="toggleEditMode(this)"
                                        class="text-gray-600 hover:text-gray-900 cancel-button hidden">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                           No settings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $settings->links() }}
        </div>
    </div>
</div>

@endsection
