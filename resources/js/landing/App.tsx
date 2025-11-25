import { useState, useEffect } from 'react';
import { Header } from './components/Header';
import { Footer } from './components/Footer';
import { WhatsAppButton } from './components/WhatsAppButton';
import { Home } from './pages/Home';
import { Playground } from './pages/Playground';
import { Pricing } from './pages/Pricing';
import { Contact } from './pages/Contact';
import { Terms } from './pages/Terms';

type Page = 'home' | 'playground' | 'pricing' | 'contact' | 'terms';

function App() {
  const [currentPage, setCurrentPage] = useState<Page>('home');

  useEffect(() => {
    const handleHashChange = () => {
      const hash = window.location.hash.slice(1);

      if (hash === 'playground') setCurrentPage('playground');
      else if (hash === 'pricing') setCurrentPage('pricing');
      else if (hash === 'contact') setCurrentPage('contact');
      else if (hash === 'terms' || hash === 'privacy') setCurrentPage('terms');
      else if (hash === 'home' || hash === 'parties' || hash === 'gallery' || hash === 'location' || hash === 'attractions') {
        setCurrentPage('home');
      }
      else if (!hash) setCurrentPage('home');
    };

    handleHashChange();
    window.addEventListener('hashchange', handleHashChange);

    return () => window.removeEventListener('hashchange', handleHashChange);
  }, []);

  const renderPage = () => {
    switch (currentPage) {
      case 'playground':
        return <Playground />;
      case 'pricing':
        return <Pricing />;
      case 'contact':
        return <Contact />;
      case 'terms':
        return <Terms />;
      default:
        return <Home />;
    }
  };

  return (
    <div className="min-h-screen bg-white">
      <Header />
      <main>
        {renderPage()}
      </main>
      <Footer />
      <WhatsAppButton />
    </div>
  );
}

export default App;

