import { useState } from 'react';
import { Menu, X } from 'lucide-react';
import { Button } from './Button';

export function Header() {
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  const navigation = [
    { name: 'Acasă', href: '/', isExternal: false },
    { name: 'Loc de Joacă', href: '/loc-de-joaca-vaslui', isExternal: true },
    { name: 'Petreceri', href: '/petreceri-copii-vaslui', isExternal: true },
    { name: 'Serbări', href: '/serbari-copii-vaslui', isExternal: true },
    { name: 'Prețuri', href: '#pricing', isExternal: false },
    { name: 'Contact', href: '#contact', isExternal: false },
  ];

  const handleNavClick = (href: string, isExternal: boolean) => {
    if (isExternal) {
      window.location.href = href;
    } else if (href.startsWith('#')) {
      window.location.hash = href;
    } else {
      window.location.href = href;
    }
  };

  return (
    <header className="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-jungle-dark via-jungle to-leaf shadow-2xl border-b-4 border-leaf-light">
      <nav className="container mx-auto px-4 md:px-6 max-w-7xl">
        <div className="flex items-center justify-between h-20">
          <a href="/" className="flex items-center gap-3">
            <img 
              src="/images/bongoland-logo.png" 
              alt="Bongoland - Loc de joacă Vaslui" 
              className="h-14 w-auto drop-shadow-lg"
              loading="eager"
            />
          </a>

          <div className="hidden lg:flex items-center gap-6">
            {navigation.map((item) => (
              <a
                key={item.name}
                href={item.href}
                onClick={(e) => {
                  if (!item.isExternal && item.href.startsWith('#')) {
                    e.preventDefault();
                    handleNavClick(item.href, item.isExternal);
                  }
                }}
                className="text-white font-bold hover:text-sand transition-colors drop-shadow-md text-sm"
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
            aria-label="Meniu navigare"
          >
            {mobileMenuOpen ? (
              <X className="w-6 h-6 text-white" />
            ) : (
              <Menu className="w-6 h-6 text-white" />
            )}
          </button>
        </div>

        {mobileMenuOpen && (
          <div className="lg:hidden pb-6 space-y-4 bg-jungle-dark/95 backdrop-blur-sm rounded-b-3xl px-4">
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
