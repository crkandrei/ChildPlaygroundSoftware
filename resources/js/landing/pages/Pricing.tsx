import { Clock, Users, Ticket, TrendingDown, AlertCircle, Check } from 'lucide-react';
import { Section } from '../components/Section';
import { Card } from '../components/Card';
import { Button } from '../components/Button';

export function Pricing() {
  const pricing = [
    {
      title: '1 Oră de Joacă',
      price: '25 LEI',
      icon: Clock,
      color: 'from-sky to-blue-400',
      features: ['Acces la toate atracțiile', 'Supraveghere permanentă', 'Ideal pentru o vizită rapidă'],
    },
    {
      title: '2 Ore de Joacă',
      price: '40 LEI',
      icon: Clock,
      color: 'from-jungle to-jungle-green',
      popular: true,
      features: ['Acces nelimitat la toate zonele', 'Timp suficient pentru explorare', 'Cel mai popular pachet', 'Economisești 10 LEI'],
    },
    {
      title: 'Joacă Nelimitată',
      price: '55 LEI',
      icon: Ticket,
      color: 'from-banana to-yellow-400',
      features: ['Toată ziua în Bongoland', 'Perfect pentru weekend', 'Distracție maximă', 'Cea mai bună valoare'],
    },
  ];

  const discounts = [
    {
      title: 'Dimineața în Săptămână',
      discount: '20% reducere',
      time: 'Luni - Vineri, 10:00 - 14:00',
      description: 'Profită de liniștea dimineții și prețuri avantajoase!',
    },
    {
      title: 'Abonament 10 Intrări',
      discount: '200 LEI (în loc de 250 LEI)',
      time: 'Valabil 3 luni',
      description: 'Economisești 50 LEI și vii oricând vrei!',
    },
    {
      title: 'Fratele Doi',
      discount: '15% reducere',
      time: 'Pentru al doilea copil',
      description: 'Veniți cu mai mulți copii? Al doilea plătește mai puțin!',
    },
  ];

  const rules = [
    'Șosete obligatorii pentru copii și adulți (3 LEI/pereche dacă nu ai)',
    'Adulții nu plătesc intrare, dar trebuie să respecte regulile de igienă',
    'Copiii sub 1 an intră gratuit',
    'Părinții sunt responsabili pentru supravegherea copiilor sub 3 ani',
    'Fără mâncare sau băuturi în zonele de joacă (avem zonă dedicată)',
    'Respectarea programului și a timpului alocat',
  ];

  return (
    <div id="pricing" className="pt-20">
      <Section background="jungle" className="text-center">
        <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
          <Ticket className="w-5 h-5 text-banana" />
          <span className="text-sm font-semibold">Prețuri și Abonamente</span>
        </div>
        <h1 className="text-5xl md:text-6xl font-bold mb-6">
          Prețuri Corecte Pentru<br />
          <span className="text-banana">Distracție Maximă</span>
        </h1>
        <p className="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
          Oferim tarife accesibile pentru ca fiecare familie să se bucure de o zi minunată la Bongoland. Alege pachetul care ți se potrivește!
        </p>
      </Section>

      <Section background="white">
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
            Tarife Intrare Copii
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Prețurile includ acces la toate atracțiile și supravegherea profesională a personalului nostru.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
          {pricing.map((plan, index) => (
            <Card key={index} className={plan.popular ? 'ring-4 ring-jungle shadow-2xl scale-105' : ''}>
              {plan.popular && (
                <div className="bg-jungle text-white text-sm font-bold px-4 py-1 rounded-full inline-block mb-4">
                  ⭐ CEL MAI POPULAR
                </div>
              )}
              <div className={`bg-gradient-to-br ${plan.color} rounded-2xl p-6 text-white mb-6`}>
                <plan.icon className="w-12 h-12 mb-3" />
                <h3 className="text-2xl font-bold mb-2">{plan.title}</h3>
                <div className="text-4xl font-bold">{plan.price}</div>
                <div className="text-sm opacity-90 mt-1">per copil</div>
              </div>
              <ul className="space-y-3">
                {plan.features.map((feature, i) => (
                  <li key={i} className="flex items-start gap-2">
                    <Check className="w-5 h-5 text-jungle shrink-0 mt-0.5" />
                    <span className="text-gray-700">{feature}</span>
                  </li>
                ))}
              </ul>
            </Card>
          ))}
        </div>

        <div className="bg-gradient-to-r from-jungle/5 to-sky/5 rounded-3xl p-6 text-center">
          <Users className="w-12 h-12 text-jungle mx-auto mb-3" />
          <p className="text-jungle-dark font-semibold text-lg mb-2">
            Adulții însoțitori nu plătesc intrare!
          </p>
          <p className="text-gray-600">
            Părinții, bunicii sau însoțitorii pot intra gratuit și pot supraveghea copiii în confort.
          </p>
        </div>
      </Section>

      <Section background="sky">
        <div className="text-center mb-12">
          <TrendingDown className="w-16 h-16 text-jungle mx-auto mb-4" />
          <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
            Reduceri și Oferte Speciale
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Profită de ofertele noastre și economisește! Distracția nu trebuie să fie scumpă.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {discounts.map((discount, index) => (
            <Card key={index}>
              <div className="bg-jungle text-white rounded-2xl px-4 py-2 inline-block mb-4 font-bold">
                {discount.discount}
              </div>
              <h3 className="text-xl font-bold text-jungle-dark mb-2">{discount.title}</h3>
              <p className="text-sm text-jungle font-semibold mb-3">{discount.time}</p>
              <p className="text-gray-600 leading-relaxed">{discount.description}</p>
            </Card>
          ))}
        </div>

        <div className="mt-12 bg-white rounded-3xl p-8 text-center">
          <h3 className="text-2xl font-bold text-jungle-dark mb-4">
            Vrei un abonament personalizat?
          </h3>
          <p className="text-gray-600 mb-6 max-w-2xl mx-auto">
            Pentru familii cu 3+ copii, grădinițe sau grupuri mari, îți putem crea o ofertă specială. Contactează-ne!
          </p>
          <Button size="lg" onClick={() => window.location.hash = '#contact'}>
            Solicită Ofertă Personalizată
          </Button>
        </div>
      </Section>

      <Section background="white">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
          <div>
            <AlertCircle className="w-16 h-16 text-jungle mb-6" />
            <h2 className="text-4xl font-bold text-jungle-dark mb-6">
              Reguli și Informații Importante
            </h2>
            <p className="text-gray-600 leading-relaxed mb-6">
              Pentru siguranța și confortul tuturor, te rugăm să respecți câteva reguli simple. Suntem aici să creăm o experiență plăcută pentru fiecare familie!
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

          <Card className="bg-gradient-to-br from-jungle to-jungle-green text-white">
            <h3 className="text-3xl font-bold mb-6">Zone Suplimentare Gratuite</h3>
            <div className="space-y-4">
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">Zonă de Relaxare Părinți</h4>
                <p className="text-sm opacity-90">WiFi gratuit, cafea și loc confortabil pentru a supraveghea copiii.</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">Cameră de Alăptare</h4>
                <p className="text-sm opacity-90">Spațiu privat, curat și liniștit pentru mămici.</p>
              </div>
              <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-4">
                <h4 className="font-bold mb-2">Păstrare Obiecte Personale</h4>
                <p className="text-sm opacity-90">Dulapuri sigure pentru genți, haine și obiecte de valoare.</p>
              </div>
            </div>
          </Card>
        </div>
      </Section>

      <Section background="gray">
        <div className="bg-gradient-to-r from-jungle via-jungle-green to-sky rounded-3xl p-8 md:p-12 text-white text-center">
          <h3 className="text-3xl md:text-4xl font-bold mb-4">
            Vino Astăzi și Descoperă Bongoland!
          </h3>
          <p className="text-lg md:text-xl opacity-95 mb-6 max-w-2xl mx-auto">
            Nu e nevoie de rezervare pentru intrări simple. Vino oricând în programul nostru și începe aventura!
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="lg" variant="secondary" onClick={() => window.location.hash = '#contact'}>
              Rezervă pentru Petrecere
            </Button>
            <Button size="lg" variant="outline" className="bg-white/95 hover:bg-white" onClick={() => window.location.hash = '#location'}>
              Vezi Programul Complet
            </Button>
          </div>
        </div>
      </Section>
    </div>
  );
}

