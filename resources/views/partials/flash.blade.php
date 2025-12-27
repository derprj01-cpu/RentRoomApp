@if (session('success'))
    <x-flash-message type="success">
        {{ session('success') }}
    </x-flash-message>
@endif

@if (session('error'))
    <x-flash-message type="error">
        {{ session('error') }}
    </x-flash-message>
@endif

@if (session('warning'))
    <x-flash-message type="warning">
        {{ session('warning') }}
    </x-flash-message>
@endif

@if (session('info'))
    <x-flash-message type="info">
        {{ session('info') }}
    </x-flash-message>
@endif
