import { MapPin, Phone, Mail, Clock } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function LocationSection() {
  return (
    <Section background="gray" id="location">
      <div className="text-center mb-12">
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Vino să Ne Cunoști!
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Suntem ușor de găsit și te așteptăm cu brațele deschise. Iată cum ne poți contacta:
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <Card hover={false}>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <MapPin className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Adresă</h3>
            <p className="text-gray-600 leading-relaxed">
              Strada Exemplu nr. 123<br />
              Vaslui 730001<br />
              România
            </p>
          </Card>

          <Card hover={false}>
            <div className="bg-sky/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Phone className="w-8 h-8 text-sky" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Telefon</h3>
            <a href="tel:+40700000000" className="text-jungle hover:text-jungle-dark transition-colors font-semibold">
              +40 700 000 000
            </a>
            <p className="text-sm text-gray-500 mt-1">Luni - Duminică</p>
          </Card>

          <Card hover={false}>
            <div className="bg-banana/20 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Mail className="w-8 h-8 text-yellow-700" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Email</h3>
            <a href="mailto:contact@bongoland.ro" className="text-jungle hover:text-jungle-dark transition-colors break-all">
              contact@bongoland.ro
            </a>
          </Card>

          <Card hover={false}>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Clock className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Program</h3>
            <div className="text-gray-600 text-sm space-y-1">
              <p className="font-semibold">Luni - Vineri</p>
              <p>10:00 - 20:00</p>
              <p className="font-semibold mt-2">Sâmbătă - Duminică</p>
              <p>09:00 - 21:00</p>
            </div>
          </Card>
        </div>

        <Card hover={false} className="h-full min-h-[400px]">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d87326.38219495799!2d27.66045!3d46.63672!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b4415f48ed5c91%3A0x32c1e923e8cc3f32!2sVaslui!5e0!3m2!1sen!2sro!4v1234567890"
            width="100%"
            height="100%"
            style={{ border: 0, borderRadius: '1rem', minHeight: '350px' }}
            allowFullScreen
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            title="Locație Bongoland"
          ></iframe>
        </Card>
      </div>

      <div className="bg-gradient-to-r from-jungle via-jungle-green to-sky rounded-3xl p-8 md:p-12 text-white text-center">
        <h3 className="text-3xl font-bold mb-4">Parcare Gratuită Disponibilă</h3>
        <p className="text-lg opacity-95 max-w-2xl mx-auto leading-relaxed">
          Avem locuri de parcare suficiente pentru toți vizitatorii. Vino fără griji — totul este gândit pentru confortul tău!
        </p>
      </div>
    </Section>
  );
}

