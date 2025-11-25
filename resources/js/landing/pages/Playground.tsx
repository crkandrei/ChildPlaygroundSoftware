import { Baby, Users, Zap, Shield, Sparkles, Shirt, Clock, AlertCircle } from 'lucide-react';
import { Section } from '../components/Section';
import { Card } from '../components/Card';

export function Playground() {
  const ageGroups = [
    {
      age: '1-3 ani',
      icon: Baby,
      color: 'bg-pink-500',
      title: 'Zona Bebeluși',
      activities: [
        'Jucării educative moi și colorate',
        'Scări mici și suprafețe catifelate',
        'Tobogan mic pentru primele aventuri',
        'Piscină cu bile mari (siguranță maximă)',
        'Blocuri de construcție XXL',
        'Muzică liniștitoare de fundal',
      ],
      description: 'Pentru cei mai mici exploratori, am creat un spațiu cald și liniștit unde pot începe să descopere lumea în siguranță. Fiecare element este gândit pentru dezvoltarea senzorială și motorie.',
    },
    {
      age: '4-6 ani',
      icon: Users,
      color: 'bg-sky',
      title: 'Zona Preșcolari',
      activities: [
        'Soft play cu obstacole distractive',
        'Tobogane medii și tuneluri',
        'Trambuline cu plasă de protecție',
        'Zone de jocuri de rol (bucătărie, garaj)',
        'Piscină cu bile pentru sărituri și căutări',
        'Jocuri interactive de echipă',
      ],
      description: 'Vârsta explorărilor și prieteniilor! Aici copiii își dezvoltă imaginația, învață să interacționeze social și își testează abilitățile fizice într-un mediu plin de culoare și energie.',
    },
    {
      age: '7-10 ani',
      icon: Zap,
      color: 'bg-jungle',
      title: 'Zona Copii Mari',
      activities: [
        'Parcurs aventură cu provocări fizice',
        'Tobogane uriașe și super rapide',
        'Trambuline profesionale',
        'Ziduri de cățărat și poduri suspendate',
        'Arenă fotbal & curse',
        'Jocuri competitive și provocări',
      ],
      description: 'Pentru copiii care caută adrenalină și provocări! Zone special create pentru a-și elibera energia, a-și dezvolta curajul și a concura cu prietenii în siguranță deplină.',
    },
  ];

  const safetyRules = [
    'Șosete obligatorii pentru toți copiii (disponibile și la cumpărare)',
    'Adulții trebuie să poarte șosete pentru a intra în zonele de joacă',
    'Fără mâncare sau băuturi în zonele de joacă',
    'Copiii sub 3 ani trebuie supravegheați direct de părinți',
    'Respectarea instrucțiunilor personalului în orice moment',
    'Folosirea corespunzătoare a echipamentelor conform vârstei',
  ];

  const hygiene = [
    'Dezinfectare zilnică completă a tuturor suprafețelor',
    'Curățare după fiecare sesiune intensă',
    'Aer condiționat și ventilație premium',
    'Verificare constantă a siguranței echipamentelor',
    'Gel dezinfectant disponibil în mai multe puncte',
  ];

  return (
    <div id="playground" className="pt-20">
      <Section background="jungle" className="text-center">
        <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
          <Sparkles className="w-5 h-5 text-banana" />
          <span className="text-sm font-semibold">Locul de Joacă</span>
        </div>
        <h1 className="text-5xl md:text-6xl font-bold mb-6">
          Aventura Perfectă Pentru Fiecare Vârstă
        </h1>
        <p className="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
          La Bongoland, fiecare copil găsește propriul paradis. De la bebeluși curioși la copii plini de energie, avem tot ce le trebuie pentru ore întregi de joacă.
        </p>
      </Section>

      <Section background="white">
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
            Zone Dedicate pe Vârste
          </h2>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Siguranța și distracția merg mână în mână. Am organizat spațiul pentru ca fiecare vârstă să se simtă în largul ei.
          </p>
        </div>

        <div className="space-y-12">
          {ageGroups.map((group, index) => (
            <div key={index} className={`flex flex-col ${index % 2 === 0 ? 'lg:flex-row' : 'lg:flex-row-reverse'} gap-8 items-center`}>
              <div className="flex-1">
                <Card className="h-full">
                  <div className={`${group.color} rounded-2xl w-20 h-20 flex items-center justify-center mb-6 text-white`}>
                    <group.icon className="w-10 h-10" />
                  </div>
                  <div className="flex items-center gap-3 mb-4">
                    <h3 className="text-3xl font-bold text-jungle-dark">{group.title}</h3>
                    <span className="bg-jungle/10 text-jungle font-bold px-4 py-1 rounded-full text-sm">
                      {group.age}
                    </span>
                  </div>
                  <p className="text-gray-600 leading-relaxed mb-6">{group.description}</p>
                  <ul className="space-y-3">
                    {group.activities.map((activity, i) => (
                      <li key={i} className="flex items-start gap-2">
                        <div className="w-2 h-2 bg-jungle rounded-full mt-2 shrink-0"></div>
                        <span className="text-gray-700">{activity}</span>
                      </li>
                    ))}
                  </ul>
                </Card>
              </div>
              <div className="flex-1">
                <div className="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center">
                  <div className={`${group.color} rounded-full w-32 h-32 flex items-center justify-center text-white`}>
                    <group.icon className="w-20 h-20" />
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </Section>

      <Section background="sky">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <Card>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-6">
              <Shield className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="text-2xl font-bold text-jungle-dark mb-4">Siguranță și Supraveghere</h3>
            <p className="text-gray-600 leading-relaxed mb-6">
              Personalul nostru calificat supraveghează constant toate zonele. Suntem instruiți în prim ajutor și știm cum să reacționăm prompt în orice situație.
            </p>
            <ul className="space-y-3">
              {safetyRules.map((rule, i) => (
                <li key={i} className="flex items-start gap-2">
                  <AlertCircle className="w-5 h-5 text-jungle shrink-0 mt-0.5" />
                  <span className="text-gray-700 text-sm">{rule}</span>
                </li>
              ))}
            </ul>
          </Card>

          <Card>
            <div className="bg-sky/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-6">
              <Sparkles className="w-8 h-8 text-sky" />
            </div>
            <h3 className="text-2xl font-bold text-jungle-dark mb-4">Curățenie și Igienă</h3>
            <p className="text-gray-600 leading-relaxed mb-6">
              Sănătatea copiilor este prioritatea noastră. Menținem standarde ridicate de igienă și oferim un mediu curat și plăcut pentru toată familia.
            </p>
            <ul className="space-y-3">
              {hygiene.map((item, i) => (
                <li key={i} className="flex items-start gap-2">
                  <Sparkles className="w-5 h-5 text-sky shrink-0 mt-0.5" />
                  <span className="text-gray-700 text-sm">{item}</span>
                </li>
              ))}
            </ul>
          </Card>
        </div>
      </Section>

      <Section background="white">
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <Card>
            <div className="bg-banana/20 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Clock className="w-8 h-8 text-yellow-700" />
            </div>
            <h3 className="text-xl font-bold text-jungle-dark mb-3">Program și Recomandări</h3>
            <div className="text-gray-600 space-y-3 text-sm">
              <p><span className="font-semibold">Luni - Vineri:</span> 10:00 - 20:00</p>
              <p><span className="font-semibold">Weekend:</span> 09:00 - 21:00</p>
              <p className="pt-3 border-t"><span className="font-semibold">Tip:</span> Dimineața în timpul săptămânii este mai liniștit și perfect pentru cei mici!</p>
            </div>
          </Card>

          <Card>
            <div className="bg-jungle/10 rounded-2xl w-16 h-16 flex items-center justify-center mb-4">
              <Shirt className="w-8 h-8 text-jungle" />
            </div>
            <h3 className="text-xl font-bold text-jungle-dark mb-3">Ce Să Aduci</h3>
            <ul className="text-gray-600 space-y-2 text-sm">
              <li className="flex items-start gap-2">
                <div className="w-2 h-2 bg-jungle rounded-full mt-1.5 shrink-0"></div>
                <span>Șosete curate pentru copii și adulți</span>
              </li>
              <li className="flex items-start gap-2">
                <div className="w-2 h-2 bg-jungle rounded-full mt-1.5 shrink-0"></div>
                <span>Haine confortabile pentru mișcare</span>
              </li>
              <li className="flex items-start gap-2">
                <div className="w-2 h-2 bg-jungle rounded-full mt-1.5 shrink-0"></div>
                <span>Apă pentru hidratare (disponibilă și la noi)</span>
              </li>
              <li className="flex items-start gap-2">
                <div className="w-2 h-2 bg-jungle rounded-full mt-1.5 shrink-0"></div>
                <span>Prosop mic (opțional)</span>
              </li>
            </ul>
          </Card>
        </div>
      </Section>
    </div>
  );
}

