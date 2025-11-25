import axios from 'axios';

const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
  },
});

export interface ContactSubmission {
  name: string;
  phone: string;
  message: string;
}

export interface PartyBooking {
  name: string;
  phone: string;
  childAge: string;
  date: string;
  kids: string;
  package: string;
}

export async function submitContactForm(data: ContactSubmission) {
  const response = await api.post('/api/landing/contact', {
    parent_name: data.name,
    phone: data.phone,
    message: data.message,
  });
  return response.data;
}

export async function submitPartyBooking(data: PartyBooking) {
  const response = await api.post('/api/landing/reservation', {
    parent_name: data.name,
    phone: data.phone,
    child_age: parseInt(data.childAge),
    birthday_date: data.date,
    number_of_children: parseInt(data.kids),
    package: data.package,
    message: `Pachet solicitat: ${data.package}`,
  });
  return response.data;
}

