import { Zap, Activity, Waves, Baby, Target, ArrowDownUp } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function Attractions() {
  const attractions = [
    {
      icon: Zap,
      title: 'Tiroliană',
      age: '4-12 ani',
      color: 'bg-gradient-to-br from-jungle to-leaf-dark',
      description: 'Zboară prin junglă cu tiroliană noastră! O experiență plină de adrenalină într-un mediu complet sigur, cu echipamente profesionale și supraveghere.',
    },
    {
      icon: Activity,
      title: 'Trambulină',
      age: '3-12 ani',
      color: 'bg-gradient-to-br from-sky to-blue-500',
      description: 'Trambuline profesionale cu plase de protecție. Sărituri libere care dezvoltă coordonarea, echilibrul și oferă distracție maximă pentru toate vârstele!',
    },
    {
      icon: ArrowDownUp,
      title: 'Tobogane',
      age: '2-12 ani',
      color: 'bg-gradient-to-br from-banana to-orange',
      description: 'Tobogane variate pentru toate vârstele! De la cele mai blânde pentru cei mici, până la cele rapide și captivante pentru cei mai mari.',
    },
    {
      icon: Waves,
      title: 'Piscină cu Bile',
      age: '1-8 ani',
      color: 'bg-gradient-to-br from-earth to-earth-dark',
      description: 'Mii de bile colorate într-o piscină sigură și distractivă. Spațiu ideal pentru jocuri imaginative, interacțiuni sociale și dezvoltare motrică.',
    },
    {
      icon: Target,
      title: 'Traseu Obstacole',
      age: '4-12 ani',
      color: 'bg-gradient-to-br from-jungle-brown to-earth',
      description: 'Parcurs cu provocări fizice: căi suspendate, obstacole și poduri de funie. Dezvoltă curajul, forța și coordonarea într-un mediu inspirat din junglă.',
    },
    {
      icon: Baby,
      title: 'Zonă pentru Cei Mici',
      age: '0-3 ani',
      color: 'bg-gradient-to-br from-leaf-light to-leaf',
      description: 'Zonă delimitată special pentru bebeluși și toddleri, cu echipamente adaptate vârstei lor. Suprafețe moi, jucării sigure și spațiu de explorare în siguranță.',
    },
  ];

  return (
    <Section background="white" id="attractions">
      <div className="text-center mb-12">
        <h2 className="font-display text-4xl md:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-jungle-dark via-jungle to-leaf mb-6">
          Ce Găsești la Bongoland Vaslui
        </h2>
        <p className="text-xl md:text-2xl font-bold text-gray-700 max-w-3xl mx-auto">
          Cel mai complet loc de joacă interior din Vaslui! De la bebeluși la copii de 12 ani, 
          fiecare găsește activități potrivite pentru vârsta lui.
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {attractions.map((attraction, index) => (
          <Card key={index} className="border-4 border-transparent hover:border-leaf transition-all">
            <div className={`${attraction.color} rounded-3xl w-24 h-24 flex items-center justify-center mb-6 text-white shadow-2xl mx-auto transform hover:scale-110 transition-transform`}>
              <attraction.icon className="w-12 h-12" />
            </div>
            <div className="flex flex-col items-center gap-3 mb-4">
              <h3 className="font-display text-2xl font-bold text-jungle-dark text-center">{attraction.title}</h3>
              <span className="bg-gradient-to-r from-leaf-light to-leaf text-jungle-dark text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                {attraction.age}
              </span>
            </div>
            <p className="text-gray-700 leading-relaxed text-center">{attraction.description}</p>
          </Card>
        ))}
      </div>

      <div className="mt-16 text-center">
        <div className="inline-block bg-gradient-to-r from-jungle-dark via-jungle to-leaf rounded-4xl p-1 shadow-2xl">
          <div className="bg-white rounded-4xl px-10 py-8">
            <p className="text-jungle-dark text-2xl font-bold">
              Toate atracțiile sunt incluse în prețul de intrare
              <br />
              <span className="text-xl">Distracție nelimitată pentru copilul tău!</span>
            </p>
          </div>
        </div>
      </div>
    </Section>
  );
}

