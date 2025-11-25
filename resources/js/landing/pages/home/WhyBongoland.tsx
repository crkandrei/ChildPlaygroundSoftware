import { Shield, Sparkles, Users, Heart, Trophy, Star } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function WhyBongoland() {
  const benefits = [
    {
      icon: Shield,
      title: 'Siguranță Maximă',
      description: 'Echipamente certificate, suprafețe moi și personal instruit în prim ajutor. Fiecare colț este gândit pentru siguranța copiilor.',
    },
    {
      icon: Sparkles,
      title: 'Curățenie Impecabilă',
      description: 'Dezinfectăm zilnic toate zonele de joacă. Spații luminate natural, aer condiționat și ventilație optimă pentru confortul micuților.',
    },
    {
      icon: Users,
      title: 'Personal Calificat',
      description: 'Echipa noastră iubește copiii și știe cum să creeze un mediu prietenos și distractiv. Supraveghere constantă și atentă.',
    },
    {
      icon: Heart,
      title: 'Spațiu Generos',
      description: 'Peste 400 mp de distracție! Fiecare copil are spațiu să exploreze, să alerge și să se joace în voie, fără aglomerație.',
    },
    {
      icon: Trophy,
      title: 'Echipamente Noi',
      description: 'Am investit în cele mai moderne și sigure echipamente de joacă. Tobogane uriașe, trambuline profesionale și multe altele.',
    },
    {
      icon: Star,
      title: 'Zone pe Vârste',
      description: 'Arii dedicate pentru bebeluși, preșcolari și copii mari. Fiecare vârstă are propriile aventuri adaptate nivelului de dezvoltare.',
    },
  ];

  return (
    <Section background="gray">
      <div className="text-center mb-12">
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          De ce să alegi Bongoland?
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Ne-am gândit la fiecare detaliu pentru ca experiența copiilor tăi să fie perfectă. Iată ce ne face diferiți:
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
        <h3 className="text-3xl font-bold mb-4">Promisiunea noastră</h3>
        <p className="text-lg leading-relaxed max-w-3xl mx-auto opacity-95">
          La Bongoland, fiecare copil este special. Ne asigurăm că fiecare vizită este o aventură de neuitat, într-un mediu în care părinții pot avea încredere deplină. Copiii tăi sunt în mâini bune!
        </p>
      </div>
    </Section>
  );
}

