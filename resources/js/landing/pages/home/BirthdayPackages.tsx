import { Cake, Gift, Users, Crown, PartyPopper, Check } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';
import { Button } from '../../components/Button';

export function BirthdayPackages() {
  const packages = [
    {
      name: 'Mini Party',
      icon: Cake,
      price: '450 LEI',
      duration: '2 ore',
      kids: 'Până la 10 copii',
      color: 'from-sky to-blue-400',
      features: [
        'Acces nelimitat la toate atracțiile',
        'Masă decorată tematic',
        'Invitații personalizate (format digital)',
        'Supervizare de către personalul nostru',
        'Băuturi răcoritoare pentru copii',
        'Zona privată pentru 1 oră',
      ],
    },
    {
      name: 'Jungle Party',
      icon: PartyPopper,
      price: '750 LEI',
      duration: '3 ore',
      kids: 'Până la 15 copii',
      color: 'from-jungle to-jungle-green',
      popular: true,
      features: [
        'Tot ce e inclus în Mini Party',
        'Animator profesionist (1 oră)',
        'Decorațiuni jungle premium',
        'Jocuri interactive organizate',
        'Muzică și dans',
        'Pizza sau sandvișuri pentru copii',
        'Zona privată pentru toată durata',
        'Tort de aniversare (1 kg)',
      ],
    },
    {
      name: 'VIP Party',
      icon: Crown,
      price: '1200 LEI',
      duration: '4 ore',
      kids: 'Până la 25 copii',
      color: 'from-banana to-yellow-400',
      features: [
        'Tot ce e inclus în Jungle Party',
        'Oraș în miniatură (roluri: doctor, pompier, etc.)',
        'Mascotă personaj (30 min)',
        'Fotograf profesionist (1 oră)',
        'Meniu complet: pizza, snacks, desert',
        'Tort personalizat (2 kg)',
        'Pachete cadou pentru invitați',
        'Video personalizat de aniversare',
        'Dedicare specială pe ecran',
      ],
    },
  ];

  const extras = [
    'Animator suplimentar - 150 LEI/oră',
    'Mascotă personaj suplimentar - 200 LEI',
    'Tort tematic personalizat - de la 100 LEI',
    'Fotograf extra 1 oră - 200 LEI',
    'Face painting - 150 LEI',
    'Baloane decorative - de la 80 LEI',
  ];

  return (
    <Section background="sky" id="parties">
      <div className="text-center mb-12">
        <div className="inline-flex items-center gap-2 bg-white rounded-full px-6 py-2 mb-4">
          <Gift className="w-5 h-5 text-jungle" />
          <span className="text-sm font-semibold text-jungle-dark">Petreceri de Neuitat</span>
        </div>
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Aniversări de Vis în Bongoland
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Lasă-ne să transformăm ziua specială a copilului tău într-o aventură magică. Alege pachetul potrivit și relaxează-te — noi ne ocupăm de tot!
        </p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        {packages.map((pkg, index) => (
          <Card key={index} className={pkg.popular ? 'ring-4 ring-jungle shadow-2xl scale-105' : ''}>
            {pkg.popular && (
              <div className="bg-jungle text-white text-sm font-bold px-4 py-1 rounded-full inline-block mb-4">
                🌟 CEL MAI POPULAR
              </div>
            )}
            <div className={`bg-gradient-to-br ${pkg.color} rounded-2xl p-6 text-white mb-6`}>
              <pkg.icon className="w-12 h-12 mb-3" />
              <h3 className="text-2xl font-bold mb-2">{pkg.name}</h3>
              <div className="text-3xl font-bold mb-1">{pkg.price}</div>
              <div className="opacity-90 text-sm">{pkg.duration} • {pkg.kids}</div>
            </div>

            <ul className="space-y-3 mb-6">
              {pkg.features.map((feature, i) => (
                <li key={i} className="flex items-start gap-2">
                  <Check className="w-5 h-5 text-jungle shrink-0 mt-0.5" />
                  <span className="text-gray-700 text-sm leading-relaxed">{feature}</span>
                </li>
              ))}
            </ul>

            <Button
              variant={pkg.popular ? 'primary' : 'outline'}
              size="md"
              className="w-full"
              onClick={() => window.location.hash = '#contact'}
            >
              Rezervă Acum
            </Button>
          </Card>
        ))}
      </div>

      <div className="bg-white rounded-3xl p-8 md:p-12">
        <div className="flex flex-col md:flex-row gap-8">
          <div className="flex-1">
            <h3 className="text-2xl font-bold text-jungle-dark mb-4 flex items-center gap-2">
              <Users className="w-7 h-7 text-jungle" />
              Opțiuni Suplimentare
            </h3>
            <p className="text-gray-600 mb-6 leading-relaxed">
              Personalizează petrecerea exact cum îți dorești! Adaugă servicii extra pentru o experiență și mai specială.
            </p>
            <ul className="grid grid-cols-1 md:grid-cols-2 gap-3">
              {extras.map((extra, i) => (
                <li key={i} className="flex items-center gap-2">
                  <div className="w-2 h-2 bg-jungle rounded-full"></div>
                  <span className="text-gray-700 text-sm">{extra}</span>
                </li>
              ))}
            </ul>
          </div>
          <div className="flex-1 bg-gradient-to-br from-jungle to-jungle-green rounded-2xl p-8 text-white">
            <h4 className="text-2xl font-bold mb-4">Ce faci tu?</h4>
            <p className="leading-relaxed mb-6 opacity-95">
              Absolut nimic! Noi ne ocupăm de pregătire, organizare, animație și curățenie. Tu trebuie doar să te bucuri de zâmbetul copilului tău și să faci poze.
            </p>
            <div className="bg-white/20 backdrop-blur-sm rounded-xl p-4">
              <p className="text-sm font-semibold mb-2">📞 Vrei să personalizezi pachetul?</p>
              <p className="text-sm opacity-90">
                Sună-ne și îți creăm o ofertă personalizată pentru bugetul și dorințele tale!
              </p>
            </div>
          </div>
        </div>
      </div>
    </Section>
  );
}

