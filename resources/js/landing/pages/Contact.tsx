import { useState } from 'react';
import { MapPin, Phone, Send, Calendar, Users, Cake } from 'lucide-react';
import { Section } from '../components/Section';
import { Card } from '../components/Card';
import { Button } from '../components/Button';
import { submitContactForm, submitPartyBooking } from '../lib/api';

export function Contact() {
  const [contactForm, setContactForm] = useState({ name: '', phone: '', message: '' });
  const [partyForm, setPartyForm] = useState({ name: '', phone: '', childAge: '', date: '', kids: '', package: '' });
  const [contactSubmitting, setContactSubmitting] = useState(false);
  const [partySubmitting, setPartySubmitting] = useState(false);
  const [contactSuccess, setContactSuccess] = useState(false);
  const [partySuccess, setPartySuccess] = useState(false);

  const handleContactSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setContactSubmitting(true);

    try {
      await submitContactForm(contactForm);
      setContactSuccess(true);
      setContactForm({ name: '', phone: '', message: '' });
      setTimeout(() => setContactSuccess(false), 5000);
    } catch (error) {
      console.error('Error submitting form:', error);
      alert('A apărut o eroare. Te rugăm să încerci din nou sau să ne contactezi telefonic.');
    } finally {
      setContactSubmitting(false);
    }
  };

  const handlePartySubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setPartySubmitting(true);

    try {
      await submitPartyBooking(partyForm);
      setPartySuccess(true);
      setPartyForm({ name: '', phone: '', childAge: '', date: '', kids: '', package: '' });
      setTimeout(() => setPartySuccess(false), 5000);
    } catch (error) {
      console.error('Error submitting form:', error);
      alert('A apărut o eroare. Te rugăm să încerci din nou sau să ne contactezi telefonic.');
    } finally {
      setPartySubmitting(false);
    }
  };

  return (
    <div id="contact" className="pt-20">
      <Section background="jungle" className="text-center">
        <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
          <Phone className="w-5 h-5 text-banana" />
          <span className="text-sm font-semibold">Contactează-ne</span>
        </div>
        <h1 className="text-5xl md:text-6xl font-bold mb-6">
          Suntem Aici Pentru Tine!
        </h1>
        <p className="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
          Ai întrebări? Vrei să rezervi o petrecere? Contactează-ne și îți răspundem rapid cu toate detaliile!
        </p>
      </Section>

      <Section background="white">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <Card>
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-jungle/10 rounded-full p-3">
                <Send className="w-6 h-6 text-jungle" />
              </div>
              <h2 className="text-3xl font-bold text-jungle-dark">Formular Contact</h2>
            </div>
            <p className="text-gray-600 mb-6">
              Trimite-ne un mesaj și te contactăm în cel mai scurt timp!
            </p>

            {contactSuccess && (
              <div className="bg-jungle/10 border-2 border-jungle rounded-2xl p-4 mb-6">
                <p className="text-jungle font-semibold">
                  ✓ Mesaj trimis cu succes! Te contactăm în curând.
                </p>
              </div>
            )}

            <form onSubmit={handleContactSubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Nume complet *
                </label>
                <input
                  type="text"
                  required
                  value={contactForm.name}
                  onChange={(e) => setContactForm({ ...contactForm, name: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                  placeholder="Numele tău"
                />
              </div>
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Telefon *
                </label>
                <input
                  type="tel"
                  required
                  value={contactForm.phone}
                  onChange={(e) => setContactForm({ ...contactForm, phone: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                  placeholder="+40 700 000 000"
                />
              </div>
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Mesaj *
                </label>
                <textarea
                  required
                  rows={5}
                  value={contactForm.message}
                  onChange={(e) => setContactForm({ ...contactForm, message: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors resize-none"
                  placeholder="Scrie-ne întrebarea sau mesajul tău..."
                />
              </div>
              <Button
                type="submit"
                size="lg"
                className="w-full"
                disabled={contactSubmitting}
              >
                {contactSubmitting ? 'Se trimite...' : 'Trimite Mesaj'}
              </Button>
            </form>
          </Card>

          <Card>
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-banana/20 rounded-full p-3">
                <Cake className="w-6 h-6 text-yellow-700" />
              </div>
              <h2 className="text-3xl font-bold text-jungle-dark">Rezervare Petrecere</h2>
            </div>
            <p className="text-gray-600 mb-6">
              Completează formularul și primești o ofertă personalizată pentru petrecerea copilului tău!
            </p>

            {partySuccess && (
              <div className="bg-jungle/10 border-2 border-jungle rounded-2xl p-4 mb-6">
                <p className="text-jungle font-semibold">
                  ✓ Cerere trimisă! Te contactăm pentru detalii în maxim 24h.
                </p>
              </div>
            )}

            <form onSubmit={handlePartySubmit} className="space-y-4">
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Numele tău *
                </label>
                <input
                  type="text"
                  required
                  value={partyForm.name}
                  onChange={(e) => setPartyForm({ ...partyForm, name: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                  placeholder="Numele tău complet"
                />
              </div>
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Telefon *
                </label>
                <input
                  type="tel"
                  required
                  value={partyForm.phone}
                  onChange={(e) => setPartyForm({ ...partyForm, phone: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                  placeholder="+40 700 000 000"
                />
              </div>
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-semibold text-jungle-dark mb-2">
                    Vârsta copilului *
                  </label>
                  <input
                    type="number"
                    required
                    min="1"
                    max="15"
                    value={partyForm.childAge}
                    onChange={(e) => setPartyForm({ ...partyForm, childAge: e.target.value })}
                    className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                    placeholder="5 ani"
                  />
                </div>
                <div>
                  <label className="block text-sm font-semibold text-jungle-dark mb-2">
                    Nr. copii invitați *
                  </label>
                  <input
                    type="number"
                    required
                    min="5"
                    value={partyForm.kids}
                    onChange={(e) => setPartyForm({ ...partyForm, kids: e.target.value })}
                    className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                    placeholder="10"
                  />
                </div>
              </div>
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Data dorită *
                </label>
                <input
                  type="date"
                  required
                  value={partyForm.date}
                  onChange={(e) => setPartyForm({ ...partyForm, date: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                />
              </div>
              <div>
                <label className="block text-sm font-semibold text-jungle-dark mb-2">
                  Pachet dorit *
                </label>
                <select
                  required
                  value={partyForm.package}
                  onChange={(e) => setPartyForm({ ...partyForm, package: e.target.value })}
                  className="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-jungle focus:outline-none transition-colors"
                >
                  <option value="">Alege un pachet</option>
                  <option value="aniversar-lj">Pachet Aniversar L-J - 90 LEI/copil</option>
                  <option value="aniversar-vd">Pachet Aniversar V-D - 110 LEI/copil</option>
                  <option value="regele-junglei">Pachet Regele Junglei - 2500 LEI</option>
                  <option value="custom">Pachet personalizat</option>
                </select>
              </div>
              <Button
                type="submit"
                size="lg"
                variant="secondary"
                className="w-full"
                disabled={partySubmitting}
              >
                {partySubmitting ? 'Se trimite...' : 'Solicită Ofertă'}
              </Button>
            </form>
          </Card>
        </div>
      </Section>

      <Section background="gray">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <Card hover={false}>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <MapPin className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Adresă</h3>
            <p className="text-gray-600 text-sm leading-relaxed">
              Strada Andrei Mureșanu 28<br />
              Parcul Copou, Restaurant Stil<br />
              Vaslui
            </p>
          </Card>

          <Card hover={false}>
            <div className="bg-sky/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Phone className="w-8 h-8 text-sky" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Telefon / WhatsApp</h3>
            <a href="tel:+40748394441" className="text-jungle hover:text-jungle-dark transition-colors font-semibold text-sm">
              0748 394 441
            </a>
            <p className="text-xs text-gray-500 mt-1">Sună sau scrie pe WhatsApp</p>
          </Card>

          <Card hover={false}>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Calendar className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Program</h3>
            <div className="text-gray-600 text-sm space-y-1">
              <p><span className="font-semibold">L-J:</span> 15:30-20:30</p>
              <p><span className="font-semibold">V:</span> 15:30-22:00</p>
              <p><span className="font-semibold">S-D:</span> 11:00-21:00</p>
            </div>
          </Card>
        </div>

        <Card hover={false} className="overflow-hidden p-0">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2723.5!2d27.7297!3d46.6367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b4415e00000000%3A0x0!2sStrada%20Andrei%20Mure%C8%99anu%2028%2C%20Vaslui!5e0!3m2!1sro!2sro!4v1700000000000"
            width="100%"
            height="450"
            style={{ border: 0 }}
            allowFullScreen
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            title="Locație Bongoland - Parcul Copou, Vaslui"
          ></iframe>
        </Card>
      </Section>

      <Section background="white">
        <div className="bg-gradient-to-r from-jungle via-jungle-green to-sky rounded-3xl p-8 md:p-12 text-white text-center">
          <Users className="w-16 h-16 mx-auto mb-6" />
          <h3 className="text-3xl md:text-4xl font-bold mb-4">
            Vino Fără Programare!
          </h3>
          <p className="text-lg md:text-xl opacity-95 max-w-2xl mx-auto">
            Pentru intrări simple nu e nevoie să ne anunți. Vino direct în programul nostru și începe aventura! Rezervările sunt necesare doar pentru petreceri private.
          </p>
        </div>
      </Section>
    </div>
  );
}

