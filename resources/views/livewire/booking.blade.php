<div class="container mx-auto">
    <div class="mx-auto max-w-3xl mb-10 text-center">
        <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            {{ \Illuminate\Support\Str::headline($meeting->title) }}
        </h2>
        <p class="text-gray-600 mt-4 flex items-center justify-center text-center space-x-4">
            <x-filament::icon icon="heroicon-o-clock" class="w-6 h-6" />&nbsp;
            {{ $meeting->slots_period_minutes }} Minutes
            <span class="text-gray-900">|</span>
            <x-filament::icon icon="heroicon-o-calendar-date-range" class="w-6 h-6" />&nbsp;
            @if ($meeting->start_at->year === $meeting->end_at->year)
                {{ $meeting->start_at->format('d-M') }} to {{ $meeting->end_at->format('d-M') }} {{ $meeting->end_at->format('Y') }}
            @else
                {{ $meeting->start_at->format('d-M-Y') }} to {{ $meeting->end_at->format('d-M-Y') }}
            @endif
        </p>


        <hr class="border-t mt-4 border-gray-300" />
        <div class="mt-4 text-gray-500 sm:text-xl">
            {!! $meeting->description !!}
        </div>
    </div>
    <div class=" flex items-center justify-center">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">

            <!-- Column 1 (50%) -->
            <div class="bg-gray-200 p-6 rounded-lg shadow-md text-center">
                <div class="flex justify-between items-center mb-6">
                    <!-- Month and Year -->
                    <p class="text-xl font-bold">
                        {{ $currentMonth }} {{ $currentYear }}
                    </p>
                    <!-- Navigation Buttons -->
                    <div class="flex gap-4">
                        <button
                                wire:click="prevMonth"
                                class="font-semibold">
                            Previous
                        </button>
                        <button
                                wire:click="nextMonth"
                                class="font-semibold">
                            Next
                        </button>
                    </div>
                </div>
                <!-- Separator -->
                <hr class="border-t border-gray-300" />
                <!-- Days of the Week -->
                <div class="grid grid-cols-7 gap-4 mt-6 text-sm font-bold">
                    @foreach($days as $day)
                        <div>
                            {{ \Illuminate\Support\Str::ucfirst($day) }}
                        </div>
                    @endforeach
                </div>
                <!-- Date Numbers -->
                <div class="grid grid-cols-7 gap-4 mt-6">
                    @foreach (range(1, $date->daysInMonth) as $dateNumber)
                        @php
                            // Check if the date is enabled
                            $isEnabled = in_array($dateNumber, $dateNumbers);
                        @endphp
                        <div class="flex justify-center">
                            @if($isEnabled)
                                <!-- Enabled Date (Clickable) -->
                                <button
                                        class="h-10 w-10 flex items-center justify-center font-semibold rounded-full cursor-pointer
                        hover:bg-blue-500 hover:text-white
                        transition"
                                        wire:click="selectDate({{ $dateNumber }})"
                                >
                                    {{ $dateNumber }}
                                </button>
                            @else
                                <!-- Disabled Date (Non-Clickable) -->
                                <p
                                        class="h-10 w-10 flex items-center justify-center font-semibold rounded-full
                        bg-gray-300 text-gray-500 cursor-not-allowed"
                                >
                                    {{ $dateNumber }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Column 2 (50%) -->
            <div class="bg-gray-200 p-6 rounded-lg shadow-md text-center">
                <h3 class="text-lg font-semibold mb-2">Available Time Slots</h3>

                @if (count($availableSlots) > 0)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach ($availableSlots as $slot)
                            <button
                                    class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition"
                                    wire:click="bookSlot('{{ $slot }}')"
                            >
                                {{ $slot }}
                            </button>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No slots available for the selected date.</p>
                @endif
            </div>
        </div>
    </div>
</div>