<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 z-50 sticky-bottom">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-4 md:p-2 rounded-lg bg-gray-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="max-w-full flex-1 items-center md:w-0 md:inline">
                    <p class="md:ml-3 text-gray-800 cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#dc3545]">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    /* Cookie consent button styling */
.js-cookie-consent-agree {
    background-color: #dc3545; /* Primary red color */
    color: white; /* Text color */
    padding: 0.5rem 1rem; /* Padding */
    font-weight: 500; /* Font weight */
    cursor: pointer; /* Pointer cursor */
    border: none; /* No border */
    transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover and focus effects */
}

.js-cookie-consent-agree:hover {
    background-color: #c82333; /* Darker red for hover */
}

.js-cookie-consent-agree:focus {
    outline: none; /* Remove default outline */
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.5); /* Custom focus ring */
}

</style>

