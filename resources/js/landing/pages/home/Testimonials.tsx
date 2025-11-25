import { Star, Quote } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';

export function Testimonials() {
  const testimonials = [
    {
      name: 'Maria Popescu',
      role: 'Mamă a doi copii',
      rating: 5,
      text: 'Bongoland este locul preferat al copiilor mei! Sunt impresionată de curățenie și de atenția personalului. Aici știu că sunt în siguranță și se distrează la maximum. Am organizat și aniversarea fetei mele aici — totul a fost perfect!',
    },
    {
      name: 'Andrei Ionescu',
      role: 'Tată a unui băiat de 4 ani',
      rating: 5,
      text: 'Cel mai bun loc de joacă din Vaslui! Fiul meu nu mai vrea să plece când ajungem aici. Atracțiile sunt diverse și captivante, iar zona pentru bebeluși este excelentă. Foarte mulțumit că avem un astfel de spațiu în oraș.',
    },
    {
      name: 'Elena Radu',
      role: 'Mamă a trei copii',
      rating: 5,
      text: 'Am încercat multe locuri de joacă, dar Bongoland este cu adevărat premium. Copiii mei de vârste diferite (2, 5 și 8 ani) se simt toți în largul lor. Prețurile sunt corecte pentru calitatea oferită, iar petrecerea de aniversare a fost organizată impecabil.',
    },
    {
      name: 'Gabriel Mihai',
      role: 'Tată a unei fetițe de 6 ani',
      rating: 5,
      text: 'Personalul este fantastic — prietenoși, atenți și pregătiți. Fetița mea s-a distrat de minune, iar eu am putut să mă relaxez știind că e supravegheată. Recomand cu căldură pentru toate vârstele!',
    },
    {
      name: 'Ioana Popa',
      role: 'Mamă a unui copil de 3 ani',
      rating: 5,
      text: 'Atmosfera este minunată — colorată, veselă și primitoare. Băiețelul meu este timid, dar personalul a știut cum să-l integreze în activități. Bongoland a devenit rutina noastră de weekend. Mulțumim pentru tot ce faceți!',
    },
    {
      name: 'Alexandru Stan',
      role: 'Tată a doi gemeni de 5 ani',
      rating: 5,
      text: 'Locație excelentă pentru energie nelimitată! Gemenii mei aleargă, sar și explorează ore întregi fără să se plictisească. Echipamentele sunt noi, sigure și bine întreținute. Mă bucur că avem un astfel de loc în Vaslui — merită fiecare leu!',
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
          Peste 500 de familii ne-au vizitat și s-au întors cu drag!
        </p>
        <p className="text-white/90">
          Vino și tu să faci parte din comunitatea Bongoland
        </p>
      </div>
    </Section>
  );
}

