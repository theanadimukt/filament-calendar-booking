import {
    add,
    eachDayOfInterval,
    endOfMonth,
    endOfWeek,
    format,
    getDay,
    isSameMonth,
    isToday,
    parse,
    startOfToday,
    startOfWeek,
} from "date-fns";
//import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/react/24/solid";
import { capitalizeFirstLetter } from "./functions";


document.addEventListener('livewire:load', () => {
    console.log("Livewire loaded from package script");

    // Listen for custom Livewire events
    Livewire.on('customEvent', () => {
        alert("Custom event triggered from Livewire!");
    });

    // Interact with DOM
    document.querySelector('#myButton')?.addEventListener('click', () => {
        console.log("Button clicked!");
    });
});