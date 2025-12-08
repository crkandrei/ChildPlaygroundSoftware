import { Clock, Users, Ticket, Sparkles, AlertCircle, Check, Utensils } from 'lucide-react';
import { Section } from '../components/Section';
import { Card } from '../components/Card';
import { Button } from '../components/Button';

export function Pricing() {
  const pricing = [
    {
      title: 'Intrare Standard',
      price: '30 LEI',
      period: '/ oră',
      icon: Clock,
      color: 'from-sky to-blue-400',
      features: [
        'Acces la toate atracțiile',
        'Valabil oricând (L-D)',
        'Tiroliană, trambuline, tobogane',
        'Piscină cu bile',
        'Traseu obstacole',
      ],
    },
    {
      title: 'Oferta Jungle',
      subtitle: 'Luni - Joi',
      price: '80 LEI',
      period: '/ copil',
      icon: Utensils,
      color: 'from-jungle to-jungle-green',
      popular: true,
      features: [
        'Acces NELIMITAT la locul de joacă',
        'Pizza sau Crispy la alegere',
        '1 apă plată inclusă',
        'Perfect pentru o zi întreagă de distracție',
        'Mâncare proaspătă din bucătăria noastră',
      ],
    },
    {
      title: 'Petreceri Aniversare',
      price: 'de la 90 LEI',
      period: '/ copil',
      icon: Ticket,
      color: 'from-banana to-orange',
      features: [
        'Pachete complete organizate',
        'Mâncare inclusă pentru copii',
        'Invitații digitale',
        'Momentul tortului',
        'Vezi toate pachetele mai jos',
      ],
      cta: 'Vezi Pachete',
      ctaLink: '#parties',
    },
  ];

  const rules = [
    'Șosete obligatorii pentru copii (3 LEI/pereche dacă nu ai)',
    'Adulții însoțitori nu plătesc intrare',
    'Copiii sub 1 an intră gratuit',
    'Părinții sunt responsabili pentru supravegherea copiilor sub 3 ani',
    'Nu se consumă mâncare sau băuturi din afară în locul de joacă',
    'Puteți comanda mâncare proaspătă din bucătăria noastră',
  ];

  return (
    <div id="pricing" className="pt-20">
      <Section background="jungle" className="text-center">
        <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
          <Ticket className="w-5 h-5 text-banana" />
          <span className="text-sm font-semibold">Prețuri</span>
        </div>
        <h1 className="text-5xl md:text-6xl font-bold mb-6">
          Prețuri Simple și<br />
          <span className="text-banana">Corecte</span>
        </h1>
        <p className="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
          Fără costuri ascunse. 30 lei pe oră sau 80 lei pentru o zi întreagă cu mâncare inclusă!
        </p>
      </Section>

      <Section background="white">
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
            Tarife Intrare
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Prețurile includ acces la toate atracțiile: tiroliană, trambuline, tobogane, piscină cu bile și traseu obstacole.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
          {pricing.map((plan, index) => (
            <Card key={index} className={plan.popular ? 'ring-4 ring-jungle shadow-2xl md:scale-105' : ''}>
              {plan.popular && (
                <div className="bg-jungle text-white text-sm font-bold px-4 py-1 rounded-full inline-block mb-4">
                  ⭐ RECOMANDARE
                </div>
              )}
              <div className={`bg-gradient-to-br ${plan.color} rounded-2xl p-6 text-white mb-6`}>
                <plan.icon className="w-12 h-12 mb-3" />
                <h3 className="text-2xl font-bold">{plan.title}</h3>
                {plan.subtitle && <p className="text-sm opacity-90">{plan.subtitle}</p>}
                <div className="text-4xl font-bold mt-2">{plan.price}</div>
                <div className="text-sm opacity-90">{plan.period}</div>
              </div>
              <ul className="space-y-3 mb-6">
                {plan.features.map((feature, i) => (
                  <li key={i} className="flex items-start gap-2">
                    <Check className="w-5 h-5 text-jungle shrink-0 mt-0.5" />
                    <span className="text-gray-700">{feature}</span>
                  </li>
                ))}
              </ul>
              {plan.cta && (
                <Button
                  variant="outline"
                  size="md"
                  className="w-full"
                  onClick={() => window.location.hash = plan.ctaLink || '#contact'}
                >
                  {plan.cta}
                </Button>
              )}
            </Card>
          ))}
        </div>

        <div className="bg-gradient-to-r from-jungle/5 to-sky/5 rounded-3xl p-6 text-center">
          <Users className="w-12 h-12 text-jungle mx-auto mb-3" />
          <p className="text-jungle-dark font-semibold text-lg mb-2">
            Adulții însoțitori nu plătesc intrare!
          </p>
          <p className="text-gray-600">
            Părinții și bunicii pot sta relaxați în zona noastră de restaurant în timp ce copiii se joacă.
          </p>
        </div>
      </Section>

      <Section background="sky">
        <div className="text-center mb-12">
          <Sparkles className="w-16 h-16 text-jungle mx-auto mb-4" />
          <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
            De Ce Oferta Jungle?
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Cea mai bună valoare pentru o zi completă de distracție!
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
          <Card className="bg-gradient-to-br from-jungle to-jungle-green text-white">
            <h3 className="text-3xl font-bold mb-6">Oferta Jungle - 80 LEI</h3>
            <p className="text-lg opacity-90 mb-4">Disponibilă Luni - Joi</p>
            <div className="space-y-4">
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">⏰ Timp NELIMITAT</h4>
                <p className="text-sm opacity-90">Copilul se poate juca cât vrea, fără limită de timp!</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">🍕 Pizza sau Crispy inclus</h4>
                <p className="text-sm opacity-90">Mâncare proaspătă din bucătăria noastră.</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">💧 1 Apă plată inclusă</h4>
                <p className="text-sm opacity-90">Hidratare asigurată pentru cei mici.</p>
              </div>
            </div>
            <div className="mt-6 pt-6 border-t border-white/20">
              <p className="text-sm opacity-80">
                Compară: 3 ore x 30 lei = 90 lei (fără mâncare)<br />
                Cu Oferta Jungle: 80 lei + mâncare + timp nelimitat!
              </p>
            </div>
          </Card>

          <div className="space-y-6">
            <Card>
              <h3 className="text-xl font-bold text-jungle-dark mb-4">Zonă Restaurant pentru Părinți</h3>
              <p className="text-gray-600 leading-relaxed">
                În timp ce copiii se joacă, tu te poți relaxa la mesele noastre confortabile. Bucătăria noastră proprie prepară mâncare proaspătă - nu doar pentru copii, ci și pentru adulți!
              </p>
            </Card>
            <Card>
              <h3 className="text-xl font-bold text-jungle-dark mb-4">Cea Mai Mare Suprafață din Vaslui</h3>
              <p className="text-gray-600 leading-relaxed">
                Avem spațiu suficient pentru ca fiecare copil să se joace în voie, fără aglomerație. Tiroliană, trambuline, tobogane, piscină cu bile și multe altele!
              </p>
            </Card>
          </div>
        </div>
      </Section>

      <Section background="white">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
          <div>
            <AlertCircle className="w-16 h-16 text-jungle mb-6" />
            <h2 className="text-4xl font-bold text-jungle-dark mb-6">
              Informații Utile
            </h2>
            <p className="text-gray-600 leading-relaxed mb-6">
              Pentru siguranța și confortul tuturor, te rugăm să respecți câteva reguli simple.
            </p>
            <ul className="space-y-3">
              {rules.map((rule, i) => (
                <li key={i} className="flex items-start gap-3">
                  <div className="bg-jungle/10 rounded-full p-1 mt-0.5">
                    <Check className="w-4 h-4 text-jungle" />
                  </div>
                  <span className="text-gray-700">{rule}</span>
                </li>
              ))}
            </ul>
          </div>

          <Card className="bg-gradient-to-br from-banana to-orange text-jungle-dark">
            <h3 className="text-3xl font-bold mb-6">Program</h3>
            <div className="space-y-4">
              <div className="bg-white/30 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-1">Luni - Joi</h4>
                <p className="text-2xl font-bold">15:30 - 20:30</p>
                <p className="text-sm mt-1">Oferta Jungle disponibilă!</p>
              </div>
              <div className="bg-white/30 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-1">Vineri</h4>
                <p className="text-2xl font-bold">15:30 - 22:00</p>
              </div>
              <div className="bg-white/30 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-1">Sâmbătă - Duminică</h4>
                <p className="text-2xl font-bold">11:00 - 21:00</p>
              </div>
            </div>
          </Card>
        </div>
      </Section>

      <Section background="gray">
        <div className="bg-gradient-to-r from-jungle via-jungle-green to-sky rounded-3xl p-8 md:p-12 text-white text-center">
          <h3 className="text-3xl md:text-4xl font-bold mb-4">
            Vino la Bongoland!
          </h3>
          <p className="text-lg md:text-xl opacity-95 mb-6 max-w-2xl mx-auto">
            Nu e nevoie de rezervare pentru intrări simple. Pentru petreceri, sună-ne în avans!
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="lg" variant="secondary" onClick={() => window.location.hash = '#parties'}>
              Vezi Pachete Petreceri
            </Button>
            <Button size="lg" variant="outline" className="bg-white/95 hover:bg-white" onClick={() => window.location.hash = '#contact'}>
              Contactează-ne
            </Button>
          </div>
        </div>
      </Section>
    </div>
  );
}
