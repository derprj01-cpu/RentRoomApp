<div
    x-data="confirmModal()"
    x-show="show"
    x-cloak
    x-on:open-confirm-modal.window="open($event.detail)"
    x-on:keydown.escape.window="close()"
    class="fixed inset-0 z-[9999] flex items-center justify-center"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <!-- Overlay -->
    <div x-show="show"
         x-transition.opacity
         class="fixed inset-0 bg-black/50">
    </div>

    <!-- Modal -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show"
             x-transition
             @click.outside="close()"
             class="relative w-full max-w-lg bg-white dark:bg-gray-800 rounded-lg shadow-xl">

            <!-- Header -->
            <div class="p-6">
                <h3 x-text="title"
                    class="text-lg font-semibold text-gray-900 dark:text-gray-100"></h3>
                <p x-text="message"
                   class="mt-2 text-sm text-gray-600 dark:text-gray-400"></p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 dark:bg-gray-700">

                <!-- Cancel -->
                <button
                    @click="close()"
                    class="px-4 py-2 text-sm rounded bg-gray-200 dark:bg-gray-600">
                    Cancel
                </button>

                <!-- Confirm -->
                <form x-ref="form" :action="actionUrl" method="POST">
                    @csrf
                    <template x-if="method !== 'POST'">
                        <input type="hidden" name="_method" :value="method">
                    </template>

                    <button
                        type="submit"
                        :class="confirmButtonClass"
                        class="px-4 py-2 text-sm text-white rounded">
                        <span x-text="confirmText"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function confirmModal() {
    return {
        show: false,
        title: '',
        message: '',
        confirmText: 'Confirm',
        actionUrl: '',
        method: 'POST',
        type: 'danger',

        open(data) {
            this.title = data.title ?? 'Confirm Action';
            this.message = data.message ?? 'Are you sure?';
            this.confirmText = data.confirmText ?? 'Confirm';
            this.actionUrl = data.actionUrl;
            this.method = data.method ?? 'POST';
            this.type = data.type ?? 'danger';
            this.show = true;
            document.body.classList.add('overflow-hidden');
        },

        close() {
            this.show = false;
            document.body.classList.remove('overflow-hidden');
        },

        get confirmButtonClass() {
            return {
                success: 'bg-green-600 hover:bg-green-700',
                danger: 'bg-red-600 hover:bg-red-700',
                warning: 'bg-yellow-600 hover:bg-yellow-700',
                info: 'bg-blue-600 hover:bg-blue-700',
            }[this.type];
        }
    }
}
</script>


<style>
[x-cloak] {
    display: none !important;
}
</style>
