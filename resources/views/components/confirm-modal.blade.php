<div
    x-data="{
        open: false,
        title: '',
        message: '',
        confirmText: 'Confirm',
        confirmColor: 'bg-red-600 hover:bg-red-700',
        actionUrl: '',
        method: 'POST'
    }"

    x-on:open-confirm-modal.window="
        open = true;
        title = $event.detail.title;
        message = $event.detail.message;
        confirmText = $event.detail.confirmText ?? 'Confirm';
        confirmColor = $event.detail.confirmColor ?? 'bg-red-600 hover:bg-red-700';
        actionUrl = $event.detail.action;
        method = $event.detail.method ?? 'POST';
    "

    x-show="open"
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    style="display: none"
>
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow dark:bg-gray-900">

        <!-- Title -->
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200"
            x-text="title">
        </h2>

        <!-- Message -->
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400"
           x-text="message">
        </p>

        <!-- Action -->
        <div class="flex justify-end mt-6 space-x-3">
            <button
                @click="open = false"
                class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-700">
                Cancel
            </button>

            <form :action="actionUrl" method="POST">
                @csrf
                <template x-if="method !== 'POST'">
                    <input type="hidden" name="_method" :value="method">
                </template>

                <button
                    type="submit"
                    class="px-4 py-2 text-sm text-white rounded"
                    :class="confirmColor"
                    x-text="confirmText">
                </button>
            </form>
        </div>
    </div>
</div>
