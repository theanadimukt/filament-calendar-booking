{{--
<div>

    <div class="rounded-lg shadow-md p-6 w-full">
        <div class="flex justify-between items-center mb-4">
            <button wire:click="prevMonth" class="text-gray-600 hover:text-gray-900">
                &larr; Previous
            </button>

            <h2 class="text-xl font-semibold">
                {{ \Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
            </h2>

            <button wire:click="nextMonth" class="text-gray-600 hover:text-gray-900">
                Next &rarr;
            </button>
        </div>

        <div class="grid grid-cols-7 gap-2 text-center font-semibold text-gray-700">
            <div>Sun</div>
            <div>Mon</div>
            <div>Tue</div>
            <div>Wed</div>
            <div>Thu</div>
            <div>Fri</div>
            <div>Sat</div>
        </div>

        <div class="grid grid-cols-7 gap-2 mt-2">
            @php
                $daysInMonth = \Carbon\Carbon::create($currentYear, $currentMonth)->daysInMonth;
                $startDay = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->dayOfWeek;
            @endphp

            @for ($i = 0; $i < $startDay; $i++)
                <div></div>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                <div class="py-2 px-3 bg-blue-50 hover:bg-blue-100 rounded-md cursor-pointer">
                    {{ $day }}
                </div>
            @endfor
        </div>
    </div>



</div>--}}


<div class="min-h-screen flex items-center justify-center py-5 px-4 sm:px-6 lg:px-8">
    <div class="max-w-8xl w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">
            <!-- Calendar Section -->
            <div class="col-span-1 border-r p-6">
                <h2 class="text-2xl font-bold mb-4">Select a Date</h2>
                <div class="grid grid-cols-7 gap-2 text-center text-gray-700">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>

                    <!-- Days (Dynamic Example) -->
                    <div class="col-start-3">1</div>
                    <div class="py-2 px-3 bg-blue-500 text-white rounded">2</div>
                    <div class="py-2 px-3 hover:bg-blue-100 cursor-pointer">3</div>
                    <div class="py-2 px-3 hover:bg-blue-100 cursor-pointer">4</div>
                    <div class="py-2 px-3 hover:bg-blue-100 cursor-pointer">5</div>
                    <div class="py-2 px-3 hover:bg-blue-100 cursor-pointer">6</div>
                    <div class="py-2 px-3 hover:bg-blue-100 cursor-pointer">7</div>
                    <!-- Fill the rest dynamically -->
                </div>
            </div>

            <!-- Time Slots Section -->
            <div class="col-span-1 border-r p-6">
                <h2 class="text-2xl font-bold mb-4">Select a Time</h2>
                <div class="space-y-4">
                    <button class="w-full py-2 px-4 bg-gray-100 hover:bg-blue-100 rounded">10:00 AM</button>
                    <button class="w-full py-2 px-4 bg-gray-100 hover:bg-blue-100 rounded">11:30 AM</button>
                    <button class="w-full py-2 px-4 bg-gray-100 hover:bg-blue-100 rounded">2:00 PM</button>
                    <button class="w-full py-2 px-4 bg-gray-100 hover:bg-blue-100 rounded">4:00 PM</button>
                </div>
            </div>

            <!-- Booking Form Section -->
            <div class="col-span-1 p-6">
                <h2 class="text-2xl font-bold mb-4">Confirm Your Details</h2>
                <form class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                        <textarea id="notes" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>