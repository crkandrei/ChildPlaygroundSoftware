import { GraduationCap, Users, Music, Gift, Calendar, Check } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';
import { Button } from '../../components/Button';

export function SchoolEventsSection() {
  const benefits = [
    'Spațiu generos pentru grupuri mari de copii',
    'Acces la toate atracțiile: trambuline, tobogane, tiroliană',
    'Mâncare proaspătă din bucătăria noastră',
    'Personal dedicat pentru supraveghere și organizare',
    'Prețuri speciale pentru grădinițe și școli',
    'Flexibilitate în alegerea datei și orei',
    'Zonă separată pentru servit masa',
    'Experiență de peste 1.000 de evenimente organizate',
  ];

  return (
    <Section background="gray" id="school-events">
      <div className="text-center mb-12">
        <div className="inline-flex items-center gap-2 bg-jungle/10 rounded-full px-6 py-2 mb-4">
          <GraduationCap className="w-5 h-5 text-jungle" />
          <span className="text-sm font-semibold text-jungle-dark">Evenimente Școlare</span>
        </div>
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Serbări pentru Grădinițe și Școli în Vaslui
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Organizăm serbări de Crăciun, 8 Martie, sfârșit de an și alte evenimente pentru 
          grădinițe și școli din Vaslui. Un spațiu perfect pentru ca micuții să se bucure 
          împreună de momente speciale!
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <Card className="p-8">
          <h3 className="text-2xl font-bold text-jungle-dark mb-6 flex items-center gap-3">
            <Users className="w-8 h-8 text-jungle" />
            De ce să alegi Bongoland pentru serbarea copiilor?
          </h3>
          <ul className="space-y-3">
            {benefits.map((benefit, index) => (
              <li key={index} className="flex items-start gap-3">
                <Check className="w-5 h-5 text-jungle shrink-0 mt-0.5" />
                <span className="text-gray-700">{benefit}</span>
              </li>
            ))}
          </ul>
        </Card>

        <div className="space-y-6">
          <Card className="p-6 bg-gradient-to-br from-jungle to-jungle-green text-white">
            <Music className="w-12 h-12 mb-4 text-leaf-light" />
            <h4 className="text-xl font-bold mb-2">Serbări de Crăciun</h4>
            <p className="opacity-90">
              Organizăm serbări de Crăciun memorabile! Copiii se bucură de joacă, 
              iar noi ne ocupăm de gustări și atmosfera festivă.
            </p>
          </Card>

          <Card className="p-6 bg-gradient-to-br from-sky to-blue-400 text-white">
            <Gift className="w-12 h-12 mb-4 text-white/80" />
            <h4 className="text-xl font-bold mb-2">Sfârșitul Anului Școlar</h4>
            <p className="opacity-90">
              Celebrează sfârșitul anului școlar în cel mai distractiv mod! 
              Distracție maximă pentru întreaga clasă sau grupa de grădiniță.
            </p>
          </Card>

          <Card className="p-6 bg-gradient-to-br from-banana to-orange text-jungle-dark">
            <Calendar className="w-12 h-12 mb-4 text-jungle-dark/70" />
            <h4 className="text-xl font-bold mb-2">Rezervări Flexibile</h4>
            <p className="opacity-90">
              Alegem împreună data și ora potrivită pentru grupul tău. 
              Contactează-ne pentru o ofertă personalizată!
            </p>
          </Card>
        </div>
      </div>

      <div className="bg-white rounded-3xl p-8 md:p-12 text-center shadow-xl">
        <h3 className="text-2xl font-bold text-jungle-dark mb-4">
          Organizezi o serbare pentru grădiniță sau școală?
        </h3>
        <p className="text-gray-600 mb-6 max-w-2xl mx-auto">
          Contactează-ne pentru a primi o ofertă personalizată. Avem experiență în organizarea 
          de evenimente pentru grupuri de 20-100+ copii. Prețuri speciale pentru instituții!
        </p>
        <div className="flex flex-col sm:flex-row gap-4 justify-center">
          <Button
            size="lg"
            variant="primary"
            onClick={() => window.location.hash = '#contact'}
          >
            Cere Ofertă Serbări
          </Button>
          <a 
            href="/serbari-copii-vaslui" 
            className="inline-flex items-center justify-center px-6 py-3 text-lg font-semibold text-jungle border-2 border-jungle rounded-xl hover:bg-jungle hover:text-white transition-colors"
          >
            Află Mai Multe
          </a>
        </div>
      </div>
    </Section>
  );
}

