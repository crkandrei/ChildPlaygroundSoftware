import { useState } from 'react';
import { X, ChevronLeft, ChevronRight, Image as ImageIcon } from 'lucide-react';
import { Section } from '../../components/Section';

export function Gallery() {
  const [lightboxOpen, setLightboxOpen] = useState(false);
  const [selectedImage, setSelectedImage] = useState(0);

  const images = [
    {
      url: 'https://images.pexels.com/photos/8613089/pexels-photo-8613089.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Zonă soft play multicolor',
    },
    {
      url: 'https://images.pexels.com/photos/8612997/pexels-photo-8612997.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Copii fericiți la joacă',
    },
    {
      url: 'https://images.pexels.com/photos/8613314/pexels-photo-8613314.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Trambuline și distracție',
    },
    {
      url: 'https://images.pexels.com/photos/8613317/pexels-photo-8613317.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Zone sigure pentru cei mici',
    },
    {
      url: 'https://images.pexels.com/photos/8613295/pexels-photo-8613295.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Aventuri pe tobogane',
    },
    {
      url: 'https://images.pexels.com/photos/8613012/pexels-photo-8613012.jpeg?auto=compress&cs=tinysrgb&w=800',
      caption: 'Petreceri de neuitat',
    },
  ];

  const openLightbox = (index: number) => {
    setSelectedImage(index);
    setLightboxOpen(true);
  };

  const navigate = (direction: 'prev' | 'next') => {
    if (direction === 'prev') {
      setSelectedImage((prev) => (prev === 0 ? images.length - 1 : prev - 1));
    } else {
      setSelectedImage((prev) => (prev === images.length - 1 ? 0 : prev + 1));
    }
  };

  return (
    <Section background="gray" id="gallery">
      <div className="text-center mb-12">
        <div className="inline-flex items-center gap-2 bg-white rounded-full px-6 py-2 mb-4">
          <ImageIcon className="w-5 h-5 text-jungle" />
          <span className="text-sm font-semibold text-jungle-dark">Galerie Foto</span>
        </div>
        <h2 className="text-4xl md:text-5xl font-bold text-jungle-dark mb-4">
          Zâmbete și Aventuri
        </h2>
        <p className="text-xl text-gray-600 max-w-3xl mx-auto">
          Vezi cum arată distracția la Bongoland! Explorează galeria noastră și imaginează-ți copilul tău jucându-se în acest paradis colorat.
        </p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        {images.map((image, index) => (
          <div
            key={index}
            className="relative aspect-square rounded-2xl overflow-hidden cursor-pointer group"
            onClick={() => openLightbox(index)}
          >
            <img
              src={image.url}
              alt={image.caption}
              className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-4">
                <p className="text-white font-semibold">{image.caption}</p>
              </div>
            </div>
          </div>
        ))}
      </div>

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

          <div className="max-w-5xl max-h-[90vh] flex flex-col items-center">
            <img
              src={images[selectedImage].url}
              alt={images[selectedImage].caption}
              className="max-h-[80vh] object-contain rounded-2xl"
            />
            <p className="text-white text-lg mt-4 text-center">{images[selectedImage].caption}</p>
            <p className="text-white/60 text-sm mt-2">
              {selectedImage + 1} / {images.length}
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

