import { MapPin, Phone, Clock, Facebook, Instagram } from 'lucide-react';

export function Footer() {
  return (
    <footer className="bg-gradient-to-br from-jungle-dark via-jungle to-jungle-dark text-white relative overflow-hidden">
      <div className="absolute inset-0 opacity-10">
        <div className="absolute top-10 left-20 text-6xl">🎈</div>
        <div className="absolute bottom-20 right-20 text-6xl">🎨</div>
        <div className="absolute top-1/2 left-1/4 text-5xl">⭐</div>
        <div className="absolute bottom-1/3 right-1/3 text-5xl">🎪</div>
      </div>
      <div className="container mx-auto px-4 md:px-6 max-w-7xl py-12 relative z-10">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div>
            <div className="flex items-center gap-3 mb-4">
              <img 
                src="/images/bongoland-logo.png" 
                alt="Bongoland - Loc de joacă Vaslui" 
                className="h-12 w-auto"
                loading="lazy"
              />
            </div>
            <p className="text-gray-200 text-sm leading-relaxed font-semibold mb-4">
              Cel mai mare loc de joacă din Vaslui! Bucătărie proprie, mâncare proaspătă și zonă de relaxare pentru părinți.
            </p>
            {/* SEO Internal Links */}
            <div className="space-y-2">
              <a href="/loc-de-joaca-vaslui" className="block text-leaf-light hover:text-banana transition-colors text-sm font-semibold">
                → Loc de joacă copii Vaslui
              </a>
              <a href="/petreceri-copii-vaslui" className="block text-leaf-light hover:text-banana transition-colors text-sm font-semibold">
                → Petreceri copii Vaslui
              </a>
              <a href="/serbari-copii-vaslui" className="block text-leaf-light hover:text-banana transition-colors text-sm font-semibold">
                → Serbări grădiniță/școală Vaslui
              </a>
            </div>
          </div>

          <div>
            <h4 className="font-bold text-lg mb-4">Navigare</h4>
            <ul className="space-y-2">
              <li><a href="/" className="text-gray-300 hover:text-banana transition-colors">Acasă</a></li>
              <li><a href="/loc-de-joaca-vaslui" className="text-gray-300 hover:text-banana transition-colors">Loc de Joacă Vaslui</a></li>
              <li><a href="/petreceri-copii-vaslui" className="text-gray-300 hover:text-banana transition-colors">Petreceri Copii</a></li>
              <li><a href="/serbari-copii-vaslui" className="text-gray-300 hover:text-banana transition-colors">Serbări Școlare</a></li>
              <li><a href="#pricing" className="text-gray-300 hover:text-banana transition-colors">Prețuri</a></li>
              <li><a href="#gallery" className="text-gray-300 hover:text-banana transition-colors">Galerie</a></li>
              <li><a href="#terms" className="text-gray-300 hover:text-banana transition-colors">Termeni și Condiții</a></li>
            </ul>
          </div>

          <div>
            <h4 className="font-bold text-lg mb-4">Contact</h4>
            <ul className="space-y-3">
              <li className="flex items-start gap-2">
                <MapPin className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <span className="text-gray-300 text-sm">
                  Strada Andrei Mureșanu 28<br />
                  Parcul Copou, Restaurant Stil<br />
                  Vaslui, 730006
                </span>
              </li>
              <li className="flex items-center gap-2">
                <Phone className="w-5 h-5 text-banana shrink-0" />
                <a href="tel:+40748394441" className="text-gray-300 hover:text-banana transition-colors text-sm font-semibold">
                  0748 394 441
                </a>
              </li>
            </ul>
            <a 
              href="https://wa.me/40748394441?text=Bună! Aș dori informații despre Bongoland." 
              target="_blank" 
              rel="noopener noreferrer"
              className="inline-block mt-3 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors"
            >
              💬 WhatsApp
            </a>
          </div>

          <div>
            <h4 className="font-bold text-lg mb-4">Program Bongoland</h4>
            <div className="space-y-3">
              <div className="flex items-start gap-2">
                <Clock className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <div className="text-sm">
                  <p className="text-gray-300 font-semibold">Luni - Joi</p>
                  <p className="text-gray-400">15:30 - 20:30</p>
                </div>
              </div>
              <div className="flex items-start gap-2">
                <Clock className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <div className="text-sm">
                  <p className="text-gray-300 font-semibold">Vineri</p>
                  <p className="text-gray-400">15:30 - 22:00</p>
                </div>
              </div>
              <div className="flex items-start gap-2">
                <Clock className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <div className="text-sm">
                  <p className="text-gray-300 font-semibold">Sâmbătă - Duminică</p>
                  <p className="text-gray-400">11:00 - 21:00</p>
                </div>
              </div>
            </div>
            <div className="flex gap-4 mt-6">
              <a 
                href="https://www.facebook.com/bongolandvaslui" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="bg-jungle hover:bg-banana text-white hover:text-jungle-dark transition-all p-2 rounded-lg"
                aria-label="Facebook Bongoland"
              >
                <Facebook className="w-5 h-5" />
              </a>
              <a 
                href="https://www.instagram.com/bongoland_vaslui/" 
                target="_blank" 
                rel="noopener noreferrer" 
                className="bg-jungle hover:bg-banana text-white hover:text-jungle-dark transition-all p-2 rounded-lg"
                aria-label="Instagram Bongoland"
              >
                <Instagram className="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <div className="border-t border-jungle mt-8 pt-6">
          <div className="text-center mb-4">
            <p className="text-gray-300 text-sm">
              <strong>Bongoland Vaslui</strong> - Cel mai mare loc de joacă interior din Vaslui pentru copii. 
              Organizăm petreceri, aniversări și serbări școlare.
            </p>
          </div>
          <p className="text-gray-400 text-sm text-center">
            © {new Date().getFullYear()} Bongoland. Toate drepturile rezervate. |
            <a href="#terms" className="hover:text-banana transition-colors ml-1">Termeni și Condiții</a> |
            <a href="#privacy" className="hover:text-banana transition-colors ml-1">GDPR</a>
          </p>
        </div>
      </div>
    </footer>
  );
}
