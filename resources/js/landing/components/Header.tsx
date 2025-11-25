import { useState } from 'react';
import { Menu, X, Palmtree } from 'lucide-react';
import { Button } from './Button';

export function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const navigation = [
    { name: 'Acasă', href: '#home' },
    { name: 'Locul de Joacă', href: '#playground' },
    { name: 'Petreceri', href: '#parties' },
    { name: 'Prețuri', href: '#pricing' },
    { name: 'Galerie', href: '#gallery' },
    { name: 'Contact', href: '#contact' },
  ];

  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-jungle-dark via-jungle to-leaf shadow-2xl border-b-4 border-leaf-light">
      <nav className="container mx-auto px-4 md:px-6 max-w-7xl">
        <div className="flex items-center justify-between h-20">
          <div className="flex items-center gap-3">
            <div className="bg-sand rounded-full p-2 shadow-lg">
              <Palmtree className="w-7 h-7 text-jungle-dark" />
            </div>
            <div>
              <h1 className="font-display text-2xl font-bold text-white drop-shadow-md">Bongoland</h1>
              <p className="text-xs font-bold text-leaf-light hidden sm:block">Aventura în Junglă</p>
            </div>
          </div>

          <div className="hidden lg:flex items-center gap-8">
            {navigation.map((item) => (
              <a
                key={item.name}
                href={item.href}
                className="text-white font-bold hover:text-sand transition-colors drop-shadow-md"
              >
                {item.name}
              </a>
            ))}
          </div>

          <div className="hidden lg:block">
            <Button size="md" onClick={() => window.location.hash = '#contact'}>
              Rezervă Acum
            </Button>
          </div>

          <button
            className="lg:hidden p-2"
            onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          >
            {mobileMenuOpen ? (
              <X className="w-6 h-6 text-white" />
            ) : (
              <Menu className="w-6 h-6 text-white" />
            )}
          </button>
        </div>

        {mobileMenuOpen && (
          <div className="lg:hidden pb-6 space-y-4 bg-jungle-dark/95 backdrop-blur-sm rounded-b-3xl">
            {navigation.map((item) => (
              <a
                key={item.name}
                href={item.href}
                className="block text-white font-semibold hover:text-sand transition-colors py-2"
                onClick={() => setMobileMenuOpen(false)}
              >
                {item.name}
              </a>
            ))}
            <Button
              size="md"
              className="w-full"
              onClick={() => {
                setMobileMenuOpen(false);
                window.location.hash = '#contact';
              }}
            >
              Rezervă Acum
            </Button>
          </div>
        )}
      </nav>
    </header>
  );
}

