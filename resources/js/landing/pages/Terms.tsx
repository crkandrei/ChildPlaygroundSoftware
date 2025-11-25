import { Shield, FileText, Lock, AlertCircle } from 'lucide-react';
import { Section } from '../components/Section';
import { Card } from '../components/Card';

export function Terms() {
  return (
    <div id="terms" className="pt-20">
      <Section background="jungle" className="text-center">
        <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-6 py-2 mb-6">
          <FileText className="w-5 h-5 text-banana" />
          <span className="text-sm font-semibold">Termeni și Condiții</span>
        </div>
        <h1 className="text-5xl md:text-6xl font-bold mb-6">
          Termeni, Condiții & Politici
        </h1>
        <p className="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed opacity-95">
          Transparență și siguranță pentru toată familia. Citește regulamentul și politica noastră de confidențialitate.
        </p>
      </Section>

      <Section background="white">
        <div className="max-w-4xl mx-auto space-y-8">
          <Card>
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-jungle/10 rounded-full p-3">
                <FileText className="w-8 h-8 text-jungle" />
              </div>
              <h2 className="text-3xl font-bold text-jungle-dark">Regulament Intern</h2>
            </div>

            <div className="space-y-6 text-gray-700">
              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">1. Acces și Intrare</h3>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Locul de joacă Bongoland este destinat copiilor cu vârste cuprinse între 1 și 12 ani.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Adulții însoțitori pot intra gratuit în zonele de joacă pentru a supraveghea copiii.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Șosetele sunt obligatorii pentru toți (copii și adulți). Șosetele se pot achiziționa la recepție.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Copiii sub 3 ani trebuie supravegheați permanent și direct de către părinți sau însoțitori.</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">2. Siguranță și Supraveghere</h3>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Personalul Bongoland supraveghează general zonele de joacă, dar părinții/însoțitorii rămân responsabili pentru comportamentul și siguranța copiilor lor.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Copiii trebuie să respecte instrucțiunile personalului și să folosească echipamentele conform indicațiilor.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Comportamentul violent, agresiv sau periculos nu este tolerat și poate duce la excluderea din locație.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>În caz de accidentare ușoară, personalul nostru instruit va acorda primul ajutor. Pentru situații grave, se va apela 112.</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">3. Reguli de Igienă</h3>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Nu este permis accesul copiilor bolnavi (febră, viroze, boli contagioase) pentru a proteja ceilalți copii.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Mâncarea și băuturile se consumă exclusiv în zona dedicată (cafenea/zonă relaxare).</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Obiectele personale (genți, haine, încălțăminte) se păstrează în dulapurile puse la dispoziție.</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">4. Responsabilitate</h3>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Bongoland nu își asumă răspunderea pentru bunurile personale pierdute, furate sau deteriorate.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Părinții/însoțitorii sunt răspunzători pentru daunele cauzate de copiii lor asupra echipamentelor.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Intrarea în Bongoland implică acceptarea acestor termeni și condiții.</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">5. Tarife și Plăți</h3>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Tarifele se plătesc la intrare, la recepție.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Timpul de joacă începe de la momentul plății și nu poate fi întrerupt sau transferat.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Pentru petreceri private, se încheie un contract separat cu detalii specifice.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Abonamentele și pachetele promoționale au termen de valabilitate specificat la achiziție.</span>
                  </li>
                </ul>
              </div>
            </div>
          </Card>

          <Card>
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-sky/10 rounded-full p-3">
                <Lock className="w-8 h-8 text-sky" />
              </div>
              <h2 className="text-3xl font-bold text-jungle-dark">Politica de Confidențialitate (GDPR)</h2>
            </div>

            <div className="space-y-6 text-gray-700">
              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">Colectarea și Utilizarea Datelor</h3>
                <p className="mb-3">
                  SC Bongoland SRL colectează și procesează date cu caracter personal în conformitate cu Regulamentul General privind Protecția Datelor (GDPR). Datele colectate includ:
                </p>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Nume și prenume (părinte/însoțitor)</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Număr de telefon</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Adresă email (opțional)</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Vârsta copilului (pentru asigurarea siguranței)</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">Scopul Prelucrării</h3>
                <p className="mb-3">Datele personale sunt utilizate exclusiv pentru:</p>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Gestionarea rezervărilor și programărilor</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Contactarea în caz de urgență</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Trimiterea de oferte și promoții (doar cu consimțământul explicit)</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span>Îndeplinirea obligațiilor legale și fiscale</span>
                  </li>
                </ul>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">Drepturile Tale</h3>
                <p className="mb-3">În conformitate cu GDPR, ai următoarele drepturi:</p>
                <ul className="space-y-2 ml-4">
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span><strong>Dreptul de acces:</strong> Poți solicita o copie a datelor tale personale.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span><strong>Dreptul la rectificare:</strong> Poți corecta datele incorecte sau incomplete.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span><strong>Dreptul la ștergere:</strong> Poți solicita ștergerea datelor (cu excepția obligațiilor legale).</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span><strong>Dreptul la portabilitate:</strong> Poți primi datele într-un format structurat.</span>
                  </li>
                  <li className="flex items-start gap-2">
                    <span className="text-jungle mt-1">•</span>
                    <span><strong>Dreptul la opoziție:</strong> Te poți opune prelucrării în anumite scopuri.</span>
                  </li>
                </ul>
                <p className="mt-4">
                  Pentru exercitarea drepturilor tale, contactează-ne la: <a href="mailto:contact@bongoland.ro" className="text-jungle font-semibold">contact@bongoland.ro</a>
                </p>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">Securitatea Datelor</h3>
                <p>
                  Bongoland implementează măsuri tehnice și organizatorice pentru a proteja datele tale personale împotriva accesului neautorizat, pierderii sau distrugerii. Datele sunt stocate securizat și accesibile doar personalului autorizat.
                </p>
              </div>

              <div>
                <h3 className="text-xl font-bold text-jungle-dark mb-3">Fotografii și Video</h3>
                <p>
                  Ocazional, personalul Bongoland poate realiza fotografii sau videoclipuri în timpul activităților pentru promovare pe site și social media. Dacă nu dorești ca imaginea copilului tău să apară în materiale promoționale, anunță-ne la recepție sau prin email.
                </p>
              </div>
            </div>
          </Card>

          <Card className="bg-gradient-to-br from-jungle to-jungle-green text-white">
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-white/20 rounded-full p-3">
                <AlertCircle className="w-8 h-8" />
              </div>
              <h2 className="text-3xl font-bold">Modificări ale Termenilor</h2>
            </div>
            <p className="leading-relaxed opacity-95">
              Bongoland își rezervă dreptul de a modifica acești termeni și condiții. Orice modificare va fi comunicată prin afișare la sediu și pe site-ul web. Continuarea utilizării serviciilor după modificare implică acceptarea noilor termeni.
            </p>
            <p className="mt-4 leading-relaxed opacity-95">
              <strong>Ultima actualizare:</strong> Decembrie 2024
            </p>
          </Card>

          <Card>
            <div className="flex items-center gap-3 mb-6">
              <div className="bg-jungle/10 rounded-full p-3">
                <Shield className="w-8 h-8 text-jungle" />
              </div>
              <h2 className="text-3xl font-bold text-jungle-dark">Contact pentru Întrebări</h2>
            </div>
            <p className="text-gray-700 mb-4">
              Dacă ai întrebări despre termenii și condițiile noastre sau despre politica de confidențialitate, nu ezita să ne contactezi:
            </p>
            <div className="space-y-2 text-gray-700">
              <p><strong>Email:</strong> <a href="mailto:contact@bongoland.ro" className="text-jungle hover:text-jungle-dark transition-colors">contact@bongoland.ro</a></p>
              <p><strong>Telefon:</strong> <a href="tel:+40700000000" className="text-jungle hover:text-jungle-dark transition-colors">+40 700 000 000</a></p>
              <p><strong>Adresă:</strong> Strada Exemplu nr. 123, Vaslui 730001, România</p>
            </div>
          </Card>
        </div>
      </Section>
    </div>
  );
}

