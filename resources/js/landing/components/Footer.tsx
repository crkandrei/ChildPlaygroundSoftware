import { MapPin, Phone, Mail, Clock, Facebook, Instagram } from 'lucide-react';

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
              <div className="bg-white rounded-full p-3 shadow-lg">
                <span className="text-3xl">🎪</span>
              </div>
              <div>
                <h3 className="font-display text-2xl font-bold">Bongoland</h3>
                <p className="text-sm text-banana font-bold">Aventura copiilor! 🎉</p>
              </div>
            </div>
            <p className="text-gray-200 text-sm leading-relaxed font-semibold">
              Cel mai tare loc de joacă pentru copii din Vaslui! Distracție, siguranță și zâmbete în fiecare zi! 😄
            </p>
          </div>

          <div>
            <h4 className="font-bold text-lg mb-4">Linkuri Rapide</h4>
            <ul className="space-y-2">
              <li><a href="#home" className="text-gray-300 hover:text-banana transition-colors">Acasă</a></li>
              <li><a href="#playground" className="text-gray-300 hover:text-banana transition-colors">Locul de Joacă</a></li>
              <li><a href="#parties" className="text-gray-300 hover:text-banana transition-colors">Petreceri</a></li>
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
                <span className="text-gray-300 text-sm">Strada Exemplu nr. 123, Vaslui, România</span>
              </li>
              <li className="flex items-center gap-2">
                <Phone className="w-5 h-5 text-banana shrink-0" />
                <a href="tel:+40700000000" className="text-gray-300 hover:text-banana transition-colors text-sm">
                  +40 700 000 000
                </a>
              </li>
              <li className="flex items-center gap-2">
                <Mail className="w-5 h-5 text-banana shrink-0" />
                <a href="mailto:contact@bongoland.ro" className="text-gray-300 hover:text-banana transition-colors text-sm">
                  contact@bongoland.ro
                </a>
              </li>
            </ul>
          </div>

          <div>
            <h4 className="font-bold text-lg mb-4">Program</h4>
            <div className="space-y-3">
              <div className="flex items-start gap-2">
                <Clock className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <div className="text-sm">
                  <p className="text-gray-300 font-semibold">Luni - Vineri</p>
                  <p className="text-gray-400">10:00 - 20:00</p>
                </div>
              </div>
              <div className="flex items-start gap-2">
                <Clock className="w-5 h-5 text-banana shrink-0 mt-0.5" />
                <div className="text-sm">
                  <p className="text-gray-300 font-semibold">Sâmbătă - Duminică</p>
                  <p className="text-gray-400">09:00 - 21:00</p>
                </div>
              </div>
            </div>
            <div className="flex gap-4 mt-6">
              <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" className="bg-jungle hover:bg-banana text-white hover:text-jungle-dark transition-all p-2 rounded-lg">
                <Facebook className="w-5 h-5" />
              </a>
              <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" className="bg-jungle hover:bg-banana text-white hover:text-jungle-dark transition-all p-2 rounded-lg">
                <Instagram className="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>

        <div className="border-t border-jungle mt-8 pt-6 text-center">
          <p className="text-gray-400 text-sm">
            © {new Date().getFullYear()} Bongoland. Toate drepturile rezervate. |
            <a href="#terms" className="hover:text-banana transition-colors ml-1">Termeni și Condiții</a> |
            <a href="#privacy" className="hover:text-banana transition-colors ml-1">GDPR</a>
          </p>
        </div>
      </div>
    </footer>
  );
}

