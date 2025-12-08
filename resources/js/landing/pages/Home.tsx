import { HeroSection } from './home/HeroSection';
import { WelcomeSection } from './home/WelcomeSection';
import { WhyBongoland } from './home/WhyBongoland';
import { Attractions } from './home/Attractions';
import { BirthdayPackages } from './home/BirthdayPackages';
import { SchoolEventsSection } from './home/SchoolEventsSection';
import { Gallery } from './home/Gallery';
import { Testimonials } from './home/Testimonials';
import { LocationSection } from './home/LocationSection';

export function Home() {
  return (
    <div id="home">
      <HeroSection />
      <WelcomeSection />
      <Attractions />
      <WhyBongoland />
      <BirthdayPackages />
      <SchoolEventsSection />
      <Gallery />
      <Testimonials />
      <LocationSection />
    </div>
  );
}
