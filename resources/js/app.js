import './bootstrap';

import Alpine from 'alpinejs';
import mask from '@alpinejs/mask';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin, { Draggable } from '@fullcalendar/interaction';

Alpine.plugin(mask);
window.Alpine = Alpine;

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.interactionPlugin = interactionPlugin;
window.Draggable = Draggable;

Alpine.start();
