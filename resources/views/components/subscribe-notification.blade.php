@if(session('subscribe_success'))
<div id="subscribe-notification" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-[#85BB3F] text-[#FCFCFC] px-6 py-4 rounded-lg shadow-lg flex items-center gap-4 w-[95%] max-w-none">
    <div class="flex-shrink-0">
        <img src="/images/success-circle.png" alt="Success" class="w-6 h-6">
    </div>
    <div class="flex-1">
        <div class="font-semibold text-sm">You have successfully subscribed to our mailing list</div>
    </div>
    <button onclick="closeSubscribeNotification()" class="flex-shrink-0 text-[#FCFCFC] hover:opacity-80 transition-opacity">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
    </button>
</div>

<script>
    function closeSubscribeNotification() {
        const notification = document.getElementById('subscribe-notification');
        if (notification) {
            notification.style.opacity = '0';
            notification.style.transform = 'translate(-50%, -100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }

    // Auto-hide after 5 seconds
    setTimeout(() => {
        closeSubscribeNotification();
    }, 5000);
</script>
@endif
