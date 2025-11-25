import { MessageCircle } from 'lucide-react';

export function WhatsAppButton() {
  const phoneNumber = '40700000000';
  const message = 'Bună ziua! Aș dori să aflu mai multe informații despre Bongoland.';

  const handleClick = () => {
    const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
  };

  return (
    <button
      onClick={handleClick}
      className="fixed bottom-6 right-6 z-50 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white rounded-full p-5 shadow-2xl transition-all duration-300 hover:scale-125 active:scale-95 group animate-bounce-slow border-4 border-white"
      aria-label="Contactează-ne pe WhatsApp"
    >
      <MessageCircle className="w-8 h-8 animate-pulse" />
      <span className="absolute right-full mr-4 top-1/2 -translate-y-1/2 bg-gradient-to-r from-banana to-orange text-jungle-dark px-6 py-3 rounded-3xl text-base font-bold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-2xl border-2 border-white">
        💬 Scrie-ne pe WhatsApp!
      </span>
    </button>
  );
}

