<div class="container mx-auto">
    <!-- Meeting Details -->
    <div class="mx-auto max-w-3xl mb-10 text-center">
        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            {{ \Illuminate\Support\Str::headline($meeting->title) }}
        </h2>
        <p class="text-gray-600 mt-4 flex items-center justify-center space-x-4">
            <x-filament::icon icon="heroicon-o-clock" class="w-6 h-6" />
            {{ $meeting->slots_period_minutes }} Minutes
            <span class="text-gray-900">|</span>
            <x-filament::icon icon="heroicon-o-calendar-date-range" class="w-6 h-6" />
            @if ($meeting->start_at->year === $meeting->end_at->year)
                {{ $meeting->start_at->format('d-M') }} to {{ $meeting->end_at->format('d-M Y') }}
            @else
                {{ $meeting->start_at->format('d-M-Y') }} to {{ $meeting->end_at->format('d-M-Y') }}
            @endif
        </p>
        <hr class="border-t mt-4 border-gray-300" />
        <div class="mt-4 text-gray-500 sm:text-xl">
            {!! $meeting->description !!}
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
        <!-- Calendar Column -->
        <div class="bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <!-- Month Navigation -->
            <div class="flex justify-between items-center mb-6">
                <p class="text-xl font-bold">{{ $currentMonth }} {{ $currentYear }}</p>
                <div class="flex gap-4">
                    <button wire:click="prevMonth" class="font-semibold">Previous</button>
                    <button wire:click="nextMonth" class="font-semibold">Next</button>
                </div>
            </div>
            <hr class="border-t border-gray-300" />

            <!-- Days of the Week -->
            <div class="grid grid-cols-7 gap-4 mt-6 text-sm font-bold">
                @foreach ($days as $day)
                    <div>{{ ucfirst($day) }}</div>
                @endforeach
            </div>

            <!-- Date Numbers -->
            <div class="grid grid-cols-7 gap-4 mt-6">
                @foreach ($dateNumbers as $date)
                    <div class="flex justify-center">
                        @if (is_null($date))
                            <div class="h-10 w-10"></div>
                        @else
                            <button
                                    class="h-10 w-10 flex items-center justify-center font-semibold rounded-full transition
                                {{ $date['enabled'] ? ($selectedDate === $date['day'] ? 'bg-red-500 text-white' : 'bg-white text-black hover:bg-blue-500 hover:text-white') : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                    wire:click="{{ $date['enabled'] ? "selectDate({$date['day']})" : '' }}"
                                    {{ !$date['enabled'] ? 'disabled' : '' }}>
                                {{ $date['day'] }}
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Time Slots Column -->
        <div class="bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold mb-2">Available Time Slots</h3>
            @if ($availableSlots)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach ($availableSlots as $slot)
                        <button
                                class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
                                wire:click="bookSlot('{{ $slot }}')">
                            {{ $slot }}
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No slots available for the selected date.</p>
            @endif
        </div>

        <!-- Booking Form Column -->
        <div class="col-span-2 bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <div class="mt-6">
                <h4 class="text-lg font-semibold">You selected: {{ session('selectedSlot') }}</h4>
                <form wire:submit="createAppointment">
                    {{ $this->form }}

                    <button type="submit">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
