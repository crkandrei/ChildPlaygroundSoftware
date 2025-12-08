import { useState } from 'react';
import { Gift, Crown, PartyPopper, Check, X, ChevronLeft, ChevronRight, Calendar } from 'lucide-react';
import { Section } from '../../components/Section';
import { Card } from '../../components/Card';
import { Button } from '../../components/Button';

export function BirthdayPackages() {
  const [lightboxOpen, setLightboxOpen] = useState(false);
  const [selectedImage, setSelectedImage] = useState(0);

  const flyerImages = [
    '/images/pachet-aniversar-luni-joi.png',
    '/images/pachet-aniversar-vineri-duminica.png',
    '/images/pachet-regele-junglei.png',
  ];

  const packages = [
    {
      name: 'Pachet Aniversar',
      subtitle: 'Luni - Joi',
      icon: Calendar,
      price: '90 LEI',
      priceNote: '/ copil',
      duration: 'Timp nelimitat',
      kids: 'Minim 10 copii',
      color: 'from-sky to-blue-400',
      flyerIndex: 0,
      features: [
        'Pizza sau Crispy la alegere',
        '1 sticlă de apă + 1 suc Tedi',
        '1 șampanie pentru copii',
        'Momentul tortului',
        'Lumânări pentru tort',
        'Invitație digitală pe WhatsApp',
        'Timp NELIMITAT la locul de joacă',
      ],
    },
    {
      name: 'Pachet Aniversar',
      subtitle: 'Vineri - Duminică',
      icon: PartyPopper,
      price: '110 LEI',
      priceNote: '/ copil',
      duration: '3 ore',
      kids: 'Minim 10 copii',
      color: 'from-jungle to-jungle-green',
      popular: true,
      flyerIndex: 1,
      features: [
        'Pizza sau Crispy la alegere',
        '1 apă plată + 2 Tedi',
        '1 șampanie pentru copii',
        'Pahare',
        'Momentul tortului',
        'Lumânări pentru tort',
        'Acces la locul de joacă (3 ore)',
        'Invitație digitală pe WhatsApp',
        '1 voucher de 1 oră gratis ulterior',
      ],
    },
    {
      name: 'Pachet Regele Junglei',
      subtitle: 'Luni - Duminică',
      icon: Crown,
      price: '2500 LEI',
      priceNote: 'pachet complet',
      duration: '3 ore',
      kids: '10 copii + 10 părinți',
      color: 'from-banana to-orange',
      flyerIndex: 2,
      features: [
        'Pizza sau Crispy la alegere / copil',
        '1 apă plată + 2 Tedi / copil',
        'Platouri mix grill pentru părinți',
        '1 șampanie pentru copii',
        'Pahare',
        'Momentul tortului + Lumânări',
        'Acces la locul de joacă',
        'Invitație digitală pe WhatsApp',
        '1 voucher de 1 oră gratis ulterior',
      ],
    },
  ];

  const openLightbox = (index: number) => {
    setSelectedImage(index);
    setLightboxOpen(true);
  };

  const navigate = (direction: 'prev' | 'next') => {
    if (direction === 'prev') {
      setSelectedImage((prev) => (prev === 0 ? flyerImages.length - 1 : prev - 1));
    } else {
      setSelectedImage((prev) => (prev === flyerImages.length - 1 ? 0 : prev + 1));
    }
  };

  return (
    <Section background="sky" id="parties">
      <div className="text-center mb-12">
        <div className="inline-flex items-center gap-2 bg-white rounded-full px-6 py-2 mb-4">
          <Gift className="w-5 h-5 text-jungle" />
          <span className="text-sm font-semibold text-jungle-dark">Petreceri de Neuitat</span>
        </div>
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Petreceri pentru Copii în Vaslui
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Organizăm petreceri, aniversări și evenimente tematice pentru copii în Vaslui, 
          într-un mediu sigur și plin de distracție. Mâncare proaspătă din bucătăria noastră, 
          acces la toate atracțiile și personal dedicat. Tu te relaxezi, noi ne ocupăm de tot!
        </p>
        <a 
          href="/petreceri-copii-vaslui" 
          className="inline-block mt-4 text-jungle font-semibold hover:text-jungle-dark underline"
        >
          Vezi toate detaliile despre petreceri →
        </a>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
        {packages.map((pkg, index) => (
          <Card key={index} className={`relative ${pkg.popular ? 'ring-4 ring-jungle shadow-2xl lg:scale-105' : ''}`}>
            {pkg.popular && (
              <div className="absolute top-4 right-4 z-10 bg-jungle text-white text-sm font-bold px-4 py-1 rounded-full shadow-lg">
                🌟 CEL MAI POPULAR
              </div>
            )}
            
            {/* Imaginea flyerului */}
            <div className="relative mb-6 rounded-2xl overflow-hidden cursor-pointer group" onClick={() => openLightbox(pkg.flyerIndex)}>
              <img
                src={flyerImages[pkg.flyerIndex]}
                alt={`${pkg.name} - ${pkg.subtitle} - Petreceri copii Vaslui Bongoland`}
                loading="lazy"
                className="w-full h-auto rounded-2xl transition-transform duration-300 group-hover:scale-105"
              />
              <div className="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors rounded-2xl flex items-center justify-center">
                <span className="opacity-0 group-hover:opacity-100 text-white bg-jungle px-4 py-2 rounded-full font-semibold transition-opacity">
                  Click pentru mărire
                </span>
              </div>
            </div>

            {/* Buton de rezervare */}
            <Button
              variant={pkg.popular ? 'primary' : 'outline'}
              size="lg"
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
              🍕 Mâncare Proaspătă din Bucătăria Noastră
            </h3>
            <p className="text-gray-600 mb-6 leading-relaxed">
              Toate pachetele includ mâncare preparată proaspăt în bucătăria noastră. Nu servim produse congelate — totul este făcut cu grijă pentru copii și părinți!
            </p>
            <ul className="space-y-3">
              <li className="flex items-center gap-2">
                <Check className="w-5 h-5 text-jungle" />
                <span className="text-gray-700">Pizza proaspătă sau Crispy</span>
              </li>
              <li className="flex items-center gap-2">
                <Check className="w-5 h-5 text-jungle" />
                <span className="text-gray-700">Platouri mix grill pentru părinți (Regele Junglei)</span>
              </li>
              <li className="flex items-center gap-2">
                <Check className="w-5 h-5 text-jungle" />
                <span className="text-gray-700">Băuturi răcoritoare incluse</span>
              </li>
            </ul>
          </div>
          <div className="flex-1 bg-gradient-to-br from-jungle to-jungle-green rounded-2xl p-8 text-white">
            <h4 className="text-2xl font-bold mb-4">Ce faci tu?</h4>
            <p className="leading-relaxed mb-6 opacity-95">
              Absolut nimic! Noi ne ocupăm de mâncare și organizare. Tu trebuie doar să te bucuri de zâmbetul copilului tău și să faci poze.
            </p>
            <div className="bg-white/20 backdrop-blur-sm rounded-xl p-4">
              <p className="text-sm font-semibold mb-2">📞 Vrei să rezervi?</p>
              <p className="text-sm opacity-90">
                Sună la <a href="tel:+40748394441" className="font-bold underline">0748 394 441</a> sau scrie-ne pe WhatsApp!
              </p>
            </div>
          </div>
        </div>
      </div>

      {/* Lightbox for flyer images */}
      {lightboxOpen && (
        <div className="fixed inset-0 z-50 bg-black/95 flex items-center justify-center p-4">
          <button
            onClick={() => setLightboxOpen(false)}
            className="absolute top-4 right-4 text-white hover:text-banana transition-colors"
          >
            <X className="w-8 h-8" />
          </button>

          <button
            onClick={() => navigate('prev')}
            className="absolute left-4 text-white hover:text-banana transition-colors"
          >
            <ChevronLeft className="w-12 h-12" />
          </button>

          <div className="max-w-2xl max-h-[90vh] flex flex-col items-center">
            <img
              src={flyerImages[selectedImage]}
              alt={`Pachet petrecere ${selectedImage + 1}`}
              className="max-h-[85vh] object-contain rounded-2xl shadow-2xl"
            />
            <p className="text-white/60 text-sm mt-4">
              {selectedImage + 1} / {flyerImages.length}
            </p>
          </div>

          <button
            onClick={() => navigate('next')}
            className="absolute right-4 text-white hover:text-banana transition-colors"
          >
            <ChevronRight className="w-12 h-12" />
          </button>
        </div>
      )}
    </Section>
  );
}
