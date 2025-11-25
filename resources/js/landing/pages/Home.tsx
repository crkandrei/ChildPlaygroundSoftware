import { HeroSection } from './home/HeroSection';
import { WhyBongoland } from './home/WhyBongoland';
import { Attractions } from './home/Attractions';
import { BirthdayPackages } from './home/BirthdayPackages';
import { Gallery } from './home/Gallery';
import { Testimonials } from './home/Testimonials';
import { LocationSection } from './home/LocationSection';

export function Home() {
  return (
    <div id="home">
      <HeroSection />
      <WhyBongoland />
      <Attractions />
      <BirthdayPackages />
      <Gallery />
      <Testimonials />
      <LocationSection />
    </div>
  );
}

