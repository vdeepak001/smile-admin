@php
    $toast = session('toast');
    $status = session('status');
    $success = session('success');
    $error = session('error');

    // Handle different session flash message formats
    if (!$toast && $status) {
        $statusMessages = [
            'profile-updated' => 'Profile updated successfully.',
        ];

        $toast = [
            'type' => 'success',
            'message' => $statusMessages[$status] ?? $status,
        ];
    } elseif (!$toast && $success) {
        $toast = [
            'type' => 'success',
            'message' => $success,
        ];
    } elseif (!$toast && $error) {
        $toast = [
            'type' => 'error',
            'message' => $error,
        ];
    }

    $type = $toast['type'] ?? null;
    $message = $toast['message'] ?? null;
@endphp

<div x-data="{
        show: {{ $message ? 'true' : 'false' }},
        message: '{{ $message ? e($message) : '' }}',
        type: '{{ $type ?? 'success' }}',
        timeout: null,
        trigger(msg, t = 'success') {
            this.message = msg;
            this.type = t;
            this.show = true;
            if (this.timeout) clearTimeout(this.timeout);
            this.timeout = setTimeout(() => { this.show = false }, 3500);
        }
    }"
    x-init="if(show) trigger(message, type)"
    x-on:toast-message.window="trigger($event.detail.message, $event.detail.type)"
    x-show="show"
    x-transition
    class="fixed bottom-4 right-4 z-50"
    style="display: none;">
    <div :class="type === 'error' ? 'bg-red-600' : 'bg-green-600'"
        class="max-w-sm rounded-lg shadow-lg px-4 py-3 text-sm font-medium text-white">
        <span x-text="message"></span>
    </div>
</div>
