import { Sparkles, Calendar, Leaf } from 'lucide-react';
import { Button } from '../../components/Button';

export function HeroSection() {
  return (
    <section className="relative min-h-screen flex items-center justify-center bg-gradient-to-br from-jungle-dark via-jungle to-leaf overflow-hidden pt-20">
      <div className="absolute inset-0">
        <div className="absolute top-20 left-10 w-32 h-32 bg-leaf-light/30 rounded-full blur-3xl animate-float"></div>
        <div className="absolute top-40 right-20 w-40 h-40 bg-jungle-light/20 rounded-full blur-3xl animate-bounce-slow"></div>
        <div className="absolute bottom-40 left-20 w-36 h-36 bg-leaf/30 rounded-full blur-3xl animate-float" style={{ animationDelay: '1s' }}></div>
        <div className="absolute bottom-20 right-40 w-44 h-44 bg-jungle/20 rounded-full blur-3xl animate-bounce-slow" style={{ animationDelay: '2s' }}></div>
        <svg className="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
          <pattern id="leaves" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
            <path d="M50 10 Q60 30 50 50 Q40 30 50 10" fill="#86EFAC" opacity="0.3"/>
            <path d="M20 40 Q30 60 20 80 Q10 60 20 40" fill="#A7F3D0" opacity="0.4"/>
            <path d="M80 60 Q90 80 80 100 Q70 80 80 60" fill="#6EE7B7" opacity="0.3"/>
          </pattern>
          <rect width="100%" height="100%" fill="url(#leaves)"/>
        </svg>
      </div>

      <div className="container mx-auto px-4 md:px-6 max-w-7xl relative z-10">
        <div className="text-center text-white">
          <div className="inline-flex items-center gap-3 bg-white/20 backdrop-blur-md rounded-full px-8 py-3 mb-8 shadow-xl border-2 border-white/30">
            <Leaf className="w-6 h-6 text-leaf-light" />
            <span className="text-lg font-bold">Locul de joacă premium din Vaslui</span>
            <Leaf className="w-6 h-6 text-leaf-light" />
          </div>

          <h1 className="font-display text-6xl md:text-8xl font-bold mb-8 leading-tight drop-shadow-2xl">
            Aventura în Junglă<br />
            <span className="text-sand text-7xl md:text-9xl">Începe Aici!</span>
          </h1>

          <p className="text-2xl md:text-3xl mb-10 max-w-3xl mx-auto leading-relaxed drop-shadow-lg">
            În Bongoland, copiii descoperă o lume unde jungla prinde viață.
            <br />
            Explorează, cațără-te și râzi în voie într-un mediu sigur!
          </p>

          <div className="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
            <Button
              size="lg"
              variant="secondary"
              className="flex items-center gap-3 text-xl font-bold shadow-2xl"
              onClick={() => window.location.hash = '#contact'}
            >
              <Sparkles className="w-6 h-6" />
              Rezervă o Sesiune
            </Button>
            <Button
              size="lg"
              variant="outline"
              className="flex items-center gap-3 text-xl font-bold bg-white/95 text-jungle-dark shadow-2xl"
              onClick={() => window.location.hash = '#parties'}
            >
              <Calendar className="w-6 h-6" />
              Petrecere Aniversare
            </Button>
          </div>

          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
            {[
              { number: '500+', label: 'Copii fericiți' },
              { number: '100%', label: 'Siguranță' },
              { number: '50+', label: 'Petreceri organizate' },
              { number: '10+', label: 'Ani experiență' },
            ].map((stat, index) => (
              <div key={index} className="bg-white/90 backdrop-blur-sm rounded-3xl p-6 shadow-2xl hover:bg-white transition-all border-4 border-leaf-light/50">
                <div className="text-4xl md:text-5xl font-bold text-jungle mb-2">{stat.number}</div>
                <div className="text-sm md:text-base font-bold text-jungle-dark">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div className="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 200" fill="none" xmlns="http://www.w3.org/2000/svg" className="w-full">
          <path d="M0 100L48 110C96 120 192 140 288 145C384 150 480 140 576 125C672 110 768 90 864 85C960 80 1056 90 1152 95C1248 100 1344 100 1392 100L1440 100V200H1392C1344 200 1248 200 1152 200C1056 200 960 200 864 200C768 200 672 200 576 200C480 200 384 200 288 200C192 200 96 200 48 200H0V100Z" fill="white"/>
          <path d="M0 130L48 125C96 120 192 110 288 115C384 120 480 140 576 145C672 150 768 140 864 130C960 120 1056 110 1152 110C1248 110 1344 120 1392 125L1440 130V200H1392C1344 200 1248 200 1152 200C1056 200 960 200 864 200C768 200 672 200 576 200C480 200 384 200 288 200C192 200 96 200 48 200H0V130Z" fill="#86EFAC" opacity="0.3"/>
        </svg>
      </div>
    </section>
  );
}

