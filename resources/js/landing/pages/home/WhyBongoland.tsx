import { Shield, Sparkles, Users, Heart, Trophy, ChefHat, Coffee, Maximize } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function WhyBongoland() {
  const benefits = [
    {
      icon: ChefHat,
      title: 'Bucătărie Proprie',
      description: 'Preparăm mâncare proaspătă în bucătăria noastră. Pizza, crispy și multe alte bunătăți făcute pe loc, nu produse congelate!',
    },
    {
      icon: Coffee,
      title: 'Zonă Restaurant Părinți',
      description: 'Relaxează-te în zona noastră tip restaurant în timp ce copiii se joacă. Mese confortabile, mâncare bună și liniște.',
    },
    {
      icon: Maximize,
      title: 'Cea Mai Mare Suprafață',
      description: 'Cel mai mare loc de joacă din Vaslui! Spațiu generos pentru ca fiecare copil să exploreze și să se joace în voie.',
    },
    {
      icon: Shield,
      title: 'Siguranță Maximă',
      description: 'Echipamente certificate, suprafețe moi și atenție la fiecare detaliu. Fiecare colț este gândit pentru siguranța copiilor.',
    },
    {
      icon: Sparkles,
      title: 'Curățenie Impecabilă',
      description: 'Dezinfectăm zilnic toate zonele de joacă. Spații luminate și ventilate pentru confortul și sănătatea micuților.',
    },
    {
      icon: Trophy,
      title: 'Echipamente Diverse',
      description: 'Tiroliană, trambuline, tobogane, piscină cu bile, traseu obstacole și zonă specială pentru cei mai mici.',
    },
  ];

  return (
    <Section background="gray">
      <div className="text-center mb-12">
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          De ce să Alegi Bongoland Vaslui?
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Suntem cel mai modern loc de joacă din Vaslui, cu parteneriat cu Restaurant Stil. 
          Spațiu încălzit/răcit tot timpul anului, curățenie și siguranță permanentă.
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {benefits.map((benefit, index) => (
          <Card key={index}>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <benefit.icon className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="text-xl font-bold text-jungle-dark mb-3">{benefit.title}</h3>
            <p className="text-gray-600 leading-relaxed">{benefit.description}</p>
          </Card>
        ))}
      </div>

      <div className="mt-12 bg-gradient-to-r from-jungle to-jungle-green rounded-3xl p-8 md:p-12 text-white text-center">
        <h3 className="text-3xl font-bold mb-4">Promisiunea Bongoland</h3>
        <p className="text-lg leading-relaxed max-w-3xl mx-auto opacity-95 mb-4">
          La Bongoland, copiii se joacă în cel mai mare loc de joacă din Vaslui, iar părinții se 
          relaxează cu mâncare proaspătă din bucătăria noastră. Nu doar îi aduci la joacă — 
          petreci timp de calitate împreună!
        </p>
        <a 
          href="/loc-de-joaca-vaslui" 
          className="inline-block mt-2 text-sand hover:text-white font-semibold underline"
        >
          Descoperă tot ce oferim →
        </a>
      </div>
    </Section>
  );
}

