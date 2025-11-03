@extends('layouts.app')

@section('title', 'Rezervări Zile Naștere')
@section('page-title', 'Rezervări Zile Naștere')

@section('content')
<div class="space-y-4 md:space-y-6">
    <!-- Calendar Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 card-hover">
        <div class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div class="flex items-center">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-2 md:mr-3">
                        <i class="fas fa-birthday-cake text-pink-600 text-sm md:text-base"></i>
                    </div>
                    <h2 class="text-lg md:text-xl font-bold text-gray-900">Calendar Rezervări</h2>
                </div>
                <div class="flex items-center gap-2">
                    <button id="viewMonthBtn" class="px-3 py-1.5 md:py-2 text-xs md:text-sm rounded-md bg-indigo-600 text-white hover:bg-indigo-700 font-medium">Lună</button>
                    <button id="viewWeekBtn" class="px-3 py-1.5 md:py-2 text-xs md:text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 font-medium">Săptămână</button>
                </div>
            </div>
        </div>
        <div class="p-3 md:p-4 lg:p-6">
            <div id="calendar" class="w-full"></div>
        </div>
    </div>
</div>

<!-- Modal pentru Adăugare/Editare Rezervare -->
<div id="reservationModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeModal()"></div>

        <!-- Modal Content -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full w-full">
            <form id="reservationForm" class="bg-white">
                <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200">
                    <h3 class="text-lg md:text-xl font-bold text-gray-900" id="modalTitle">Adaugă Rezervare</h3>
                </div>
                <div class="px-4 md:px-6 py-4 md:py-5 space-y-4">
                    <input type="hidden" id="reservationId" name="id">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Data rezervării *</label>
                        <input type="date" id="reservationDate" name="reservation_date" required
                               class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ora rezervării *</label>
                        <input type="time" id="reservationTime" name="reservation_time" required
                               class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Numele copilului *</label>
                        <input type="text" id="childName" name="child_name" required maxlength="255"
                               class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Telefon părinte *</label>
                        <input type="tel" id="guardianPhone" name="guardian_phone" required maxlength="20"
                               class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Număr copii participanți *</label>
                        <input type="number" id="numberOfChildren" name="number_of_children" required min="1" max="100"
                               class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Altele (note)</label>
                        <textarea id="notes" name="notes" rows="3" maxlength="1000"
                                  class="w-full px-3 py-2.5 md:py-2 border border-gray-300 rounded-md text-base md:text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                </div>
                <div class="px-4 md:px-6 py-4 md:py-5 bg-gray-50 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                            class="w-full sm:w-auto px-4 py-2.5 md:py-2 rounded-md border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 text-base md:text-sm font-medium">
                        Anulează
                    </button>
                    <button type="button" id="deleteBtn" onclick="deleteReservation()" class="hidden w-full sm:w-auto px-4 py-2.5 md:py-2 rounded-md bg-red-600 text-white hover:bg-red-700 text-base md:text-sm font-medium">
                        Șterge
                    </button>
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2.5 md:py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-base md:text-sm font-medium">
                        Salvează
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css' rel='stylesheet' />
<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/locales/ro.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendar;
    let currentView = 'dayGridMonth';
    
    // Initialize calendar
    const calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'ro',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: ''
        },
        buttonText: {
            today: 'Astăzi',
            month: 'Lună',
            week: 'Săptămână',
            day: 'Zi'
        },
        height: 'auto',
        eventDisplay: 'block',
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch('/birthday-reservations-api/calendar?start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successCallback(data.events);
                } else {
                    failureCallback();
                }
            })
            .catch(error => {
                console.error('Error loading events:', error);
                failureCallback();
            });
        },
        dateClick: function(info) {
            // Click pe zi - deschide modal pentru adăugare
            openModal(info.dateStr);
        },
        eventClick: function(info) {
            // Click pe eveniment - deschide modal pentru editare
            const event = info.event;
            const extendedProps = event.extendedProps;
            openModal(
                extendedProps.reservation_date,
                extendedProps.reservation_time,
                event.id,
                extendedProps.child_name,
                extendedProps.guardian_phone,
                extendedProps.number_of_children,
                extendedProps.notes
            );
        },
        // Mobile optimizations
        firstDay: 1, // Luni
        views: {
            dayGridMonth: {
                dayHeaderFormat: { weekday: 'short' }
            },
            timeGridWeek: {
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                slotDuration: '01:00:00',
                dayHeaderFormat: { weekday: 'short', day: 'numeric' }
            }
        }
    });
    
    calendar.render();
    
    // View switcher
    document.getElementById('viewMonthBtn').addEventListener('click', function() {
        calendar.changeView('dayGridMonth');
        currentView = 'dayGridMonth';
        updateViewButtons();
    });
    
    document.getElementById('viewWeekBtn').addEventListener('click', function() {
        calendar.changeView('timeGridWeek');
        currentView = 'timeGridWeek';
        updateViewButtons();
    });
    
    function updateViewButtons() {
        const monthBtn = document.getElementById('viewMonthBtn');
        const weekBtn = document.getElementById('viewWeekBtn');
        
        if (currentView === 'dayGridMonth') {
            monthBtn.classList.remove('bg-gray-200', 'text-gray-700');
            monthBtn.classList.add('bg-indigo-600', 'text-white');
            weekBtn.classList.remove('bg-indigo-600', 'text-white');
            weekBtn.classList.add('bg-gray-200', 'text-gray-700');
        } else {
            weekBtn.classList.remove('bg-gray-200', 'text-gray-700');
            weekBtn.classList.add('bg-indigo-600', 'text-white');
            monthBtn.classList.remove('bg-indigo-600', 'text-white');
            monthBtn.classList.add('bg-gray-200', 'text-gray-700');
        }
    }
    
    // Modal functions
    window.openModal = function(dateStr = null, timeStr = null, id = null, childName = '', guardianPhone = '', numberOfChildren = 1, notes = '') {
        const modal = document.getElementById('reservationModal');
        const form = document.getElementById('reservationForm');
        const deleteBtn = document.getElementById('deleteBtn');
        const modalTitle = document.getElementById('modalTitle');
        
        // Reset form
        form.reset();
        
        if (id) {
            // Edit mode
            modalTitle.textContent = 'Editează Rezervare';
            document.getElementById('reservationId').value = id;
            document.getElementById('reservationDate').value = dateStr;
            document.getElementById('reservationTime').value = timeStr;
            document.getElementById('childName').value = childName;
            document.getElementById('guardianPhone').value = guardianPhone;
            document.getElementById('numberOfChildren').value = numberOfChildren;
            document.getElementById('notes').value = notes || '';
            deleteBtn.classList.remove('hidden');
        } else {
            // Add mode
            modalTitle.textContent = 'Adaugă Rezervare';
            document.getElementById('reservationDate').value = dateStr || '';
            document.getElementById('reservationTime').value = '';
            deleteBtn.classList.add('hidden');
        }
        
        modal.classList.remove('hidden');
        // Prevent body scroll on mobile
        document.body.style.overflow = 'hidden';
    };
    
    window.closeModal = function() {
        const modal = document.getElementById('reservationModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };
    
    // Form submission
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = formData.get('id');
        const data = {
            child_name: formData.get('child_name'),
            guardian_phone: formData.get('guardian_phone'),
            reservation_date: formData.get('reservation_date'),
            reservation_time: formData.get('reservation_time'),
            number_of_children: parseInt(formData.get('number_of_children')),
            notes: formData.get('notes') || ''
        };
        
        const url = id ? '/birthday-reservations/' + id : '/birthday-reservations';
        const method = id ? 'PUT' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                calendar.refetchEvents();
                closeModal();
                // Show success message
                showNotification('Rezervarea a fost salvată cu succes!', 'success');
            } else {
                showNotification(result.message || 'Eroare la salvare', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Eroare la salvare', 'error');
        });
    });
    
    // Delete reservation
    window.deleteReservation = function() {
        if (!confirm('Ești sigur că vrei să ștergi această rezervare?')) {
            return;
        }
        
        const id = document.getElementById('reservationId').value;
        
        fetch('/birthday-reservations/' + id, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                calendar.refetchEvents();
                closeModal();
                showNotification('Rezervarea a fost ștearsă cu succes!', 'success');
            } else {
                showNotification(result.message || 'Eroare la ștergere', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Eroare la ștergere', 'error');
        });
    };
    
    // Notification helper
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-md shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.transition = 'opacity 0.5s';
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});
</script>

<style>
/* FullCalendar mobile optimizations */
.fc {
    font-size: 0.875rem;
}

@media (max-width: 640px) {
    .fc-header-toolbar {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
    }
    
    .fc-button {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .fc-daygrid-day {
        min-height: 80px;
    }
    
    .fc-event {
        font-size: 0.75rem;
        padding: 2px 4px;
    }
}

/* Modal mobile optimizations */
@media (max-width: 640px) {
    #reservationModal > div {
        padding: 0;
    }
    
    #reservationModal .inline-block {
        width: 100%;
        max-width: 100%;
        margin: 0;
        border-radius: 0;
    }
    
    /* Fix date and time inputs in modal */
    #reservationModal input[type="date"],
    #reservationModal input[type="time"] {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        box-sizing: border-box;
    }
    
    /* Ensure modal content doesn't overflow */
    #reservationModal .space-y-4 {
        overflow-x: hidden;
    }
}
</style>
@endsection
