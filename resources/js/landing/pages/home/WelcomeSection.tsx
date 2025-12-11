import { Heart, Star, Shield, Sparkles } from 'lucide-react';
import { Section } from '../../components/Section';

export function WelcomeSection() {
  return (
    <Section background="white" id="welcome">
      <div className="max-w-4xl mx-auto text-center">
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-6">
          Bine ai venit la Bongoland – locul de joacă perfect pentru copii în Vaslui
        </h2>
        
        <div className="prose prose-lg max-w-none text-gray-700 leading-relaxed mb-8">
          <p className="text-xl mb-6">
            <strong>Bongoland</strong> este cel mai modern <strong>loc de joacă interior din Vaslui</strong>, 
            situat în incinta Restaurantului Stil. Un spațiu sigur, curat și plin de joacă pentru copiii 
            de toate vârstele, de la bebeluși până la copii de 12 ani.
          </p>
          
          <p className="text-lg mb-6">
            La Bongoland, fiecare vizită devine o aventură. Copiii tăi vor explora o lume plină de 
            culori, râsete și activități captivante, în timp ce tu te poți relaxa în zona noastră 
            de restaurant cu mâncare proaspătă din bucătăria proprie.
          </p>
          
          <p className="text-lg">
            Fie că vii pentru o oră de joacă, o zi întreagă sau organizezi o 
            <a href="/petreceri-copii-vaslui" className="text-jungle hover:text-jungle-dark font-semibold"> petrecere de ziua copilului</a>, 
            Bongoland este alegerea perfectă pentru familiile din Vaslui și împrejurimi.
          </p>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
          {[
            { icon: Heart, label: 'Iubit de copii', color: 'text-red-500' },
            { icon: Star, label: 'Apreciat de părinți', color: 'text-banana' },
            { icon: Shield, label: '100% sigur', color: 'text-jungle' },
            { icon: Sparkles, label: 'Curat zilnic', color: 'text-sky' },
          ].map((item, index) => (
            <div key={index} className="flex flex-col items-center p-4 bg-gray-50 rounded-2xl">
              <item.icon className={`w-10 h-10 ${item.color} mb-2`} />
              <span className="text-sm font-semibold text-jungle-dark">{item.label}</span>
            </div>
          ))}
        </div>
      </div>
    </Section>
  );
}


