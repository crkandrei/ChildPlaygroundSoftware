import { Star, Quote } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function Testimonials() {
  const testimonials = [
    {
      name: 'Maria P.',
      role: 'Mamă a doi copii',
      rating: 5,
      text: 'Ce mi-a plăcut cel mai mult la Bongoland e că au bucătărie proprie! Copiii s-au jucat, iar eu am mâncat o pizza delicioasă făcută pe loc. Nu mai trebuie să cumperi mâncare înainte sau să pleci flămând.',
    },
    {
      name: 'Andrei I.',
      role: 'Tată a unui băiat de 4 ani',
      rating: 5,
      text: 'E clar cel mai mare loc de joacă din Vaslui! Fiul meu a adorat tiroliana și trambulinele. Spațiul e generos, nu e aglomerație ca în alte părți. Oferta Jungle de 80 lei e super convenabilă pentru o zi întreagă.',
    },
    {
      name: 'Elena R.',
      role: 'Mamă a trei copii',
      rating: 5,
      text: 'Am organizat petrecerea de aniversare aici și totul a fost perfect! Mâncarea proaspătă, copiii fericiți, noi relaxați la mese. Au și zonă specială pentru cei mici, așa că și bebelușul nostru s-a simțit bine.',
    },
    {
      name: 'Gabriel M.',
      role: 'Tată a unei fetițe de 6 ani',
      rating: 5,
      text: 'În sfârșit un loc de joacă unde și părinții pot sta confortabil! Zona de restaurant e genială - mă uit la fetița mea cum se joacă în timp ce beau o cafea și mănânc ceva bun. Win-win pentru toată lumea!',
    },
    {
      name: 'Ioana P.',
      role: 'Mamă a unui copil de 3 ani',
      rating: 5,
      text: 'Venim aproape săptămânal! Băiețelul meu adoră piscina cu bile și tobogoanele. Îmi place că au mâncare făcută acolo, nu congelate. Și personalul e mereu amabil și atent cu copiii.',
    },
    {
      name: 'Alexandru S.',
      role: 'Tată a doi gemeni de 5 ani',
      rating: 5,
      text: 'Cu doi copii activi, aveam nevoie de un spațiu mare unde să își consume energia. Bongoland e perfect - atâtea atracții încât nu se plictisesc! Iar eu stau la restaurant și lucrez linistit pe laptop. Recomand!',
    },
  ];

  return (
    <Section background="white">
      <div className="text-center mb-12">
        <div className="inline-flex items-center gap-2 bg-jungle/10 rounded-full px-6 py-2 mb-4">
          <Quote className="w-5 h-5 text-jungle" />
          <span className="text-sm font-semibold text-jungle-dark">Mărturii</span>
        </div>
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Ce Spun Părinții Noștri
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Fericirea copiilor și încrederea părinților sunt cele mai importante pentru noi. Iată ce ne spun familiile care ne vizitează:
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {testimonials.map((testimonial, index) => (
          <Card key={index}>
            <div className="flex gap-1 mb-4">
              {[...Array(testimonial.rating)].map((_, i) => (
                <Star key={i} className="w-5 h-5 fill-banana text-banana" />
              ))}
            </div>
            <p className="text-gray-700 leading-relaxed mb-4 italic">
              "{testimonial.text}"
            </p>
            <div className="border-t pt-4">
              <p className="font-bold text-jungle-dark">{testimonial.name}</p>
              <p className="text-sm text-gray-500">{testimonial.role}</p>
            </div>
          </Card>
        ))}
      </div>

      <div className="mt-12 text-center bg-gradient-to-r from-jungle to-jungle-green rounded-3xl p-8">
        <p className="text-white text-xl font-semibold mb-2">
          Familiile din Vaslui ne aleg pentru bucătăria proprie și spațiul generos!
        </p>
        <p className="text-white/90">
          Vino și tu să descoperi cel mai mare loc de joacă din oraș
        </p>
      </div>
    </Section>
  );
}

