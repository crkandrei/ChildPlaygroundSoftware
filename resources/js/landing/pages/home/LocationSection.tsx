import { MapPin, Phone, Clock, ExternalLink } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';
import { Button } from '../../components/Button';

export function LocationSection() {
  return (
    <Section background="gray" id="location">
      <div className="text-center mb-12">
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Prețuri, Program și Locație
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Găsești Bongoland în Parcul Copou, Vaslui, în incinta Restaurant Stil. 
          Suntem ușor de găsit și te așteptăm cu brațele deschise!
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
              Strada Andrei Mureșanu 28<br />
              Parcul Copou, Restaurant Stil<br />
              Vaslui, 730006
            </p>
            <a 
              href="https://www.google.com/maps/dir/?api=1&destination=46.64634280826934,27.726681232452396" 
              target="_blank" 
              rel="noopener noreferrer"
              className="inline-flex items-center gap-1 text-jungle hover:text-jungle-dark mt-2 text-sm font-semibold"
            >
              <ExternalLink className="w-4 h-4" />
              Navigare Google Maps
            </a>
          </Card>

          <Card hover={false}>
            <div className="bg-sky/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Phone className="w-8 h-8 text-sky" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Telefon / WhatsApp</h3>
            <a href="tel:+40748394441" className="text-jungle hover:text-jungle-dark transition-colors font-semibold text-lg">
              0748 394 441
            </a>
            <p className="text-sm text-gray-500 mt-1">Sună sau scrie pe WhatsApp</p>
            <a 
              href="https://wa.me/40748394441?text=Bună! Aș dori să fac o rezervare la Bongoland." 
              target="_blank" 
              rel="noopener noreferrer"
              className="inline-flex items-center gap-1 text-jungle hover:text-jungle-dark mt-2 text-sm font-semibold"
            >
              Scrie pe WhatsApp →
            </a>
          </Card>

          <Card hover={false} className="md:col-span-2">
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Clock className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="font-bold text-jungle-dark mb-2">Program Bongoland Vaslui</h3>
            <div className="text-gray-600 text-sm grid grid-cols-3 gap-4">
              <div>
                <p className="font-semibold">Luni - Joi</p>
                <p>15:30 - 20:30</p>
              </div>
              <div>
                <p className="font-semibold">Vineri</p>
                <p>15:30 - 22:00</p>
              </div>
              <div>
                <p className="font-semibold">Sâm - Dum</p>
                <p>11:00 - 21:00</p>
              </div>
            </div>
            <p className="text-xs text-gray-500 mt-3">
              * Programul poate varia în perioada sărbătorilor. Verifică pe Facebook sau sună pentru confirmare.
            </p>
          </Card>
        </div>

        <Card hover={false} className="h-full min-h-[400px]">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1361.5!2d27.726681232452396!3d46.64634280826934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40b4415d5a2c3b5f%3A0x123456789!2sBongoland%20Vaslui!5e0!3m2!1sro!2sro!4v1700000000000!5m2!1sro!2sro"
            width="100%"
            height="100%"
            style={{ border: 0, borderRadius: '1rem', minHeight: '350px' }}
            allowFullScreen
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            title="Locație Bongoland - Loc de joacă copii Vaslui - Parcul Copou"
          ></iframe>
        </Card>
      </div>

      <div className="bg-white rounded-3xl p-8 md:p-12 shadow-xl mb-8">
        <h3 className="text-2xl font-bold text-jungle-dark mb-6 text-center">
          Prețuri Loc de Joacă Bongoland Vaslui
        </h3>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
          <div className="text-center p-6 bg-gray-50 rounded-2xl">
            <p className="text-4xl font-bold text-jungle mb-2">30 lei</p>
            <p className="font-semibold text-jungle-dark">Pe oră</p>
            <p className="text-sm text-gray-500">Acces la toate atracțiile</p>
          </div>
          <div className="text-center p-6 bg-gradient-to-br from-jungle to-jungle-green rounded-2xl text-white">
            <p className="text-4xl font-bold mb-2">80 lei</p>
            <p className="font-semibold">Oferta Jungle</p>
            <p className="text-sm opacity-90">Timp nelimitat toată ziua!</p>
            <p className="text-xs opacity-75 mt-2">Doar Luni - Vineri</p>
          </div>
        </div>
        <p className="text-center text-gray-500 mt-6 text-sm">
          * Prețurile sunt valabile pentru un copil. Adulții au acces gratuit în zona de restaurant.
        </p>
        <div className="text-center mt-6">
          <a href="#pricing" className="text-jungle font-semibold hover:text-jungle-dark underline">
            Vezi toate prețurile și pachetele →
          </a>
        </div>
      </div>

      <div className="bg-gradient-to-r from-jungle via-jungle-green to-sky rounded-3xl p-8 md:p-12 text-white text-center">
        <h3 className="text-3xl font-bold mb-4">Vino la Bongoland - Cel mai mare loc de joacă din Vaslui!</h3>
        <p className="text-lg opacity-95 max-w-2xl mx-auto leading-relaxed mb-6">
          Suntem în incinta Restaurant Stil, Parcul Copou, cu acces facil din centrul orașului. 
          Te așteptăm cu bucătăria noastră proprie și cel mai mare loc de joacă din Vaslui!
        </p>
        <Button
          size="lg"
          variant="secondary"
          onClick={() => window.location.hash = '#contact'}
        >
          Rezervă Acum
        </Button>
      </div>
    </Section>
  );
}
