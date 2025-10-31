<?php

namespace Database\Seeders;

use App\Models\Child;
use App\Models\Guardian;
use Illuminate\Database\Seeder;

class Tenant2ManualSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = 2;

        // Cleanup existing demo data for tenant 2
        Child::where('tenant_id', $tenantId)->delete();
        Guardian::where('tenant_id', $tenantId)->delete();

        // 50 guardians (manual, deterministic)
        $g1 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Mihai Popescu','phone'=>'+40700000001','email'=>'mihai.popescu01@example.ro','notes'=>null]);
        $g2 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Elena Ionescu','phone'=>'+40700000002','email'=>'elena.ionescu02@example.ro','notes'=>null]);
        $g3 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Andrei Popa','phone'=>'+40700000003','email'=>'andrei.popa03@example.ro','notes'=>null]);
        $g4 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Ioana Dumitru','phone'=>'+40700000004','email'=>'ioana.dumitru04@example.ro','notes'=>null]);
        $g5 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Alexandru Stan','phone'=>'+40700000005','email'=>'alexandru.stan05@example.ro','notes'=>null]);
        $g6 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Maria Gheorghe','phone'=>'+40700000006','email'=>'maria.gheorghe06@example.ro','notes'=>null]);
        $g7 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Cristian Tudor','phone'=>'+40700000007','email'=>'cristian.tudor07@example.ro','notes'=>null]);
        $g8 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Ana Radu','phone'=>'+40700000008','email'=>'ana.radu08@example.ro','notes'=>null]);
        $g9 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Vlad Nistor','phone'=>'+40700000009','email'=>'vlad.nistor09@example.ro','notes'=>null]);
        $g10 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Irina Moldovan','phone'=>'+40700000010','email'=>'irina.moldovan10@example.ro','notes'=>null]);
        $g11 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Stefan Stoica','phone'=>'+40700000011','email'=>'stefan.stoica11@example.ro','notes'=>null]);
        $g12 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Alina Marin','phone'=>'+40700000012','email'=>'alina.marin12@example.ro','notes'=>null]);
        $g13 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Ionut Dobre','phone'=>'+40700000013','email'=>'ionut.dobre13@example.ro','notes'=>null]);
        $g14 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Cristina Diaconu','phone'=>'+40700000014','email'=>'cristina.diaconu14@example.ro','notes'=>null]);
        $g15 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Razvan Nita','phone'=>'+40700000015','email'=>'razvan.nita15@example.ro','notes'=>null]);
        $g16 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Sorin Gavrila','phone'=>'+40700000016','email'=>'sorin.gavrila16@example.ro','notes'=>null]);
        $g17 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Daniel Oprea','phone'=>'+40700000017','email'=>'daniel.oprea17@example.ro','notes'=>null]);
        $g18 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Roxana Toma','phone'=>'+40700000018','email'=>'roxana.toma18@example.ro','notes'=>null]);
        $g19 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Florin Petrescu','phone'=>'+40700000019','email'=>'florin.petrescu19@example.ro','notes'=>null]);
        $g20 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Simona Enache','phone'=>'+40700000020','email'=>'simona.enache20@example.ro','notes'=>null]);
        $g21 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Radu Matei','phone'=>'+40700000021','email'=>'radu.matei21@example.ro','notes'=>null]);
        $g22 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Andreea Ilie','phone'=>'+40700000022','email'=>'andreea.ilie22@example.ro','notes'=>null]);
        $g23 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Bogdan Rusu','phone'=>'+40700000023','email'=>'bogdan.rusu23@example.ro','notes'=>null]);
        $g24 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Mihaela Sandu','phone'=>'+40700000024','email'=>'mihaela.sandu24@example.ro','notes'=>null]);
        $g25 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Robert Barbu','phone'=>'+40700000025','email'=>'robert.barbu25@example.ro','notes'=>null]);
        $g26 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Marian Voicu','phone'=>'+40700000026','email'=>'marian.voicu26@example.ro','notes'=>null]);
        $g27 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Ciprian Rotaru','phone'=>'+40700000027','email'=>'ciprian.rotaru27@example.ro','notes'=>null]);
        $g28 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Gabriel Neagu','phone'=>'+40700000028','email'=>'gabriel.neagu28@example.ro','notes'=>null]);
        $g29 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Danut Sava','phone'=>'+40700000029','email'=>'danut.sava29@example.ro','notes'=>null]);
        $g30 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Dorian Badea','phone'=>'+40700000030','email'=>'dorian.badea30@example.ro','notes'=>null]);
        $g31 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Paul Vasilescu','phone'=>'+40700000031','email'=>'paul.vasilescu31@example.ro','notes'=>null]);
        $g32 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Elena Dragomir','phone'=>'+40700000032','email'=>'elena.dragomir32@example.ro','notes'=>null]);
        $g33 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Victor Munteanu','phone'=>'+40700000033','email'=>'victor.munteanu33@example.ro','notes'=>null]);
        $g34 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Ioana Constantin','phone'=>'+40700000034','email'=>'ioana.constantin34@example.ro','notes'=>null]);
        $g35 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Eduard Preda','phone'=>'+40700000035','email'=>'eduard.preda35@example.ro','notes'=>null]);
        $g36 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Maria Lazar','phone'=>'+40700000036','email'=>'maria.lazar36@example.ro','notes'=>null]);
        $g37 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Lucian Cojocaru','phone'=>'+40700000037','email'=>'lucian.cojocaru37@example.ro','notes'=>null]);
        $g38 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Alina Coman','phone'=>'+40700000038','email'=>'alina.coman38@example.ro','notes'=>null]);
        $g39 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Cristina Paraschiv','phone'=>'+40700000039','email'=>'cristina.paraschiv39@example.ro','notes'=>null]);
        $g40 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Simona Sima','phone'=>'+40700000040','email'=>'simona.sima40@example.ro','notes'=>null]);
        $g41 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Mihaela Grigore','phone'=>'+40700000041','email'=>'mihaela.grigore41@example.ro','notes'=>null]);
        $g42 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Roxana Florea','phone'=>'+40700000042','email'=>'roxana.florea42@example.ro','notes'=>null]);
        $g43 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Oana Georgescu','phone'=>'+40700000043','email'=>'oana.georgescu43@example.ro','notes'=>null]);
        $g44 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Teodora Balasa','phone'=>'+40700000044','email'=>'teodora.balasa44@example.ro','notes'=>null]);
        $g45 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Larisa Baciu','phone'=>'+40700000045','email'=>'larisa.baciu45@example.ro','notes'=>null]);
        $g46 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Bianca Iacob','phone'=>'+40700000046','email'=>'bianca.iacob46@example.ro','notes'=>null]);
        $g47 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Adela Cretu','phone'=>'+40700000047','email'=>'adela.cretu47@example.ro','notes'=>null]);
        $g48 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Carmen Neacsu','phone'=>'+40700000048','email'=>'carmen.neacsu48@example.ro','notes'=>null]);
        $g49 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Diana Pavel','phone'=>'+40700000049','email'=>'diana.pavel49@example.ro','notes'=>null]);
        $g50 = Guardian::create(['tenant_id'=>$tenantId,'name'=>'Mara Antonescu','phone'=>'+40700000050','email'=>'mara.antonescu50@example.ro','notes'=>null]);

        // 70 children (manual), at least 20 named Andrei, last name equals guardian last name
        // First 20: Andrei under different guardians
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g1->id,'first_name'=>'Andrei','last_name'=>'Popescu','birth_date'=>now()->subYears(6)->subDays(10)->toDateString(),'allergies'=>null,'internal_code'=>'ANPO101','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g2->id,'first_name'=>'Andrei','last_name'=>'Ionescu','birth_date'=>now()->subYears(7)->subDays(20)->toDateString(),'allergies'=>null,'internal_code'=>'ANIO102','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g3->id,'first_name'=>'Andrei','last_name'=>'Popa','birth_date'=>now()->subYears(5)->subDays(30)->toDateString(),'allergies'=>null,'internal_code'=>'ANPO103','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g4->id,'first_name'=>'Andrei','last_name'=>'Dumitru','birth_date'=>now()->subYears(8)->subDays(15)->toDateString(),'allergies'=>null,'internal_code'=>'ANDU104','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g5->id,'first_name'=>'Andrei','last_name'=>'Stan','birth_date'=>now()->subYears(9)->subDays(90)->toDateString(),'allergies'=>null,'internal_code'=>'ANST105','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g6->id,'first_name'=>'Andrei','last_name'=>'Gheorghe','birth_date'=>now()->subYears(4)->subDays(5)->toDateString(),'allergies'=>null,'internal_code'=>'ANGH106','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g7->id,'first_name'=>'Andrei','last_name'=>'Tudor','birth_date'=>now()->subYears(6)->subDays(60)->toDateString(),'allergies'=>null,'internal_code'=>'ANTU107','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g8->id,'first_name'=>'Andrei','last_name'=>'Radu','birth_date'=>now()->subYears(7)->subDays(40)->toDateString(),'allergies'=>null,'internal_code'=>'ANRA108','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g9->id,'first_name'=>'Andrei','last_name'=>'Nistor','birth_date'=>now()->subYears(5)->subDays(70)->toDateString(),'allergies'=>null,'internal_code'=>'ANNI109','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g10->id,'first_name'=>'Andrei','last_name'=>'Moldovan','birth_date'=>now()->subYears(10)->subDays(12)->toDateString(),'allergies'=>null,'internal_code'=>'ANMO110','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g11->id,'first_name'=>'Andrei','last_name'=>'Stoica','birth_date'=>now()->subYears(6)->subDays(22)->toDateString(),'allergies'=>null,'internal_code'=>'ANST111','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g12->id,'first_name'=>'Andrei','last_name'=>'Marin','birth_date'=>now()->subYears(7)->subDays(11)->toDateString(),'allergies'=>null,'internal_code'=>'ANMA112','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g13->id,'first_name'=>'Andrei','last_name'=>'Dobre','birth_date'=>now()->subYears(8)->subDays(33)->toDateString(),'allergies'=>null,'internal_code'=>'ANDO113','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g14->id,'first_name'=>'Andrei','last_name'=>'Diaconu','birth_date'=>now()->subYears(5)->subDays(21)->toDateString(),'allergies'=>null,'internal_code'=>'ANDI114','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g15->id,'first_name'=>'Andrei','last_name'=>'Nita','birth_date'=>now()->subYears(4)->subDays(44)->toDateString(),'allergies'=>null,'internal_code'=>'ANNI115','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g16->id,'first_name'=>'Andrei','last_name'=>'Gavrila','birth_date'=>now()->subYears(3)->subDays(9)->toDateString(),'allergies'=>null,'internal_code'=>'ANGA116','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g17->id,'first_name'=>'Andrei','last_name'=>'Oprea','birth_date'=>now()->subYears(6)->subDays(13)->toDateString(),'allergies'=>null,'internal_code'=>'ANOP117','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g18->id,'first_name'=>'Andrei','last_name'=>'Toma','birth_date'=>now()->subYears(7)->subDays(17)->toDateString(),'allergies'=>null,'internal_code'=>'ANTO118','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g19->id,'first_name'=>'Andrei','last_name'=>'Petrescu','birth_date'=>now()->subYears(9)->subDays(19)->toDateString(),'allergies'=>null,'internal_code'=>'ANPE119','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g20->id,'first_name'=>'Andrei','last_name'=>'Enache','birth_date'=>now()->subYears(8)->subDays(24)->toDateString(),'allergies'=>null,'internal_code'=>'ANEN120','notes'=>null]);

        // Guardians g1..g10 each with a second child (2 per guardian) -> 10 more
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g1->id,'first_name'=>'Mara','last_name'=>'Popescu','birth_date'=>now()->subYears(5)->subDays(12)->toDateString(),'allergies'=>null,'internal_code'=>'MAPO201','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g2->id,'first_name'=>'Ioana','last_name'=>'Ionescu','birth_date'=>now()->subYears(4)->subDays(25)->toDateString(),'allergies'=>null,'internal_code'=>'IOIO202','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g3->id,'first_name'=>'Vlad','last_name'=>'Popa','birth_date'=>now()->subYears(6)->subDays(41)->toDateString(),'allergies'=>null,'internal_code'=>'VLPO203','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g4->id,'first_name'=>'Elena','last_name'=>'Dumitru','birth_date'=>now()->subYears(7)->subDays(27)->toDateString(),'allergies'=>null,'internal_code'=>'ELDU204','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g5->id,'first_name'=>'Robert','last_name'=>'Stan','birth_date'=>now()->subYears(9)->subDays(5)->toDateString(),'allergies'=>null,'internal_code'=>'ROST205','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g6->id,'first_name'=>'Alina','last_name'=>'Gheorghe','birth_date'=>now()->subYears(6)->subDays(16)->toDateString(),'allergies'=>null,'internal_code'=>'ALGH206','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g7->id,'first_name'=>'Stefan','last_name'=>'Tudor','birth_date'=>now()->subYears(8)->subDays(29)->toDateString(),'allergies'=>null,'internal_code'=>'STTU207','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g8->id,'first_name'=>'Roxana','last_name'=>'Radu','birth_date'=>now()->subYears(5)->subDays(8)->toDateString(),'allergies'=>null,'internal_code'=>'RORA208','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g9->id,'first_name'=>'Gabriel','last_name'=>'Nistor','birth_date'=>now()->subYears(7)->subDays(14)->toDateString(),'allergies'=>null,'internal_code'=>'GANI209','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g10->id,'first_name'=>'Ana','last_name'=>'Moldovan','birth_date'=>now()->subYears(6)->subDays(22)->toDateString(),'allergies'=>null,'internal_code'=>'ANMO210','notes'=>null]);

        // Guardians g11..g15 each with two more children (3 per guardian) -> 10 more
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g11->id,'first_name'=>'Maria','last_name'=>'Stoica','birth_date'=>now()->subYears(6)->subDays(31)->toDateString(),'allergies'=>null,'internal_code'=>'MAST301','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g11->id,'first_name'=>'Ion','last_name'=>'Stoica','birth_date'=>now()->subYears(4)->subDays(18)->toDateString(),'allergies'=>null,'internal_code'=>'IOST302','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g12->id,'first_name'=>'Simona','last_name'=>'Marin','birth_date'=>now()->subYears(9)->subDays(3)->toDateString(),'allergies'=>null,'internal_code'=>'SIMA303','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g12->id,'first_name'=>'Radu','last_name'=>'Marin','birth_date'=>now()->subYears(7)->subDays(44)->toDateString(),'allergies'=>null,'internal_code'=>'RAMA304','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g13->id,'first_name'=>'Cristian','last_name'=>'Dobre','birth_date'=>now()->subYears(5)->subDays(26)->toDateString(),'allergies'=>null,'internal_code'=>'CRDO305','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g13->id,'first_name'=>'Teodora','last_name'=>'Dobre','birth_date'=>now()->subYears(6)->subDays(7)->toDateString(),'allergies'=>null,'internal_code'=>'TEDO306','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g14->id,'first_name'=>'Bianca','last_name'=>'Diaconu','birth_date'=>now()->subYears(8)->subDays(36)->toDateString(),'allergies'=>null,'internal_code'=>'BIDI307','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g14->id,'first_name'=>'Marian','last_name'=>'Diaconu','birth_date'=>now()->subYears(4)->subDays(9)->toDateString(),'allergies'=>null,'internal_code'=>'MADI308','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g15->id,'first_name'=>'Ciprian','last_name'=>'Nita','birth_date'=>now()->subYears(7)->subDays(12)->toDateString(),'allergies'=>null,'internal_code'=>'CINI309','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g15->id,'first_name'=>'Elena','last_name'=>'Nita','birth_date'=>now()->subYears(6)->subDays(5)->toDateString(),'allergies'=>null,'internal_code'=>'ELNI310','notes'=>null]);

        // One child for guardians g16..g50 (35 children)
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g16->id,'first_name'=>'Paul','last_name'=>'Gavrila','birth_date'=>now()->subYears(8)->subDays(23)->toDateString(),'allergies'=>null,'internal_code'=>'PAGA401','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g17->id,'first_name'=>'Victor','last_name'=>'Oprea','birth_date'=>now()->subYears(9)->subDays(14)->toDateString(),'allergies'=>null,'internal_code'=>'VIOP402','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g18->id,'first_name'=>'Denisa','last_name'=>'Toma','birth_date'=>now()->subYears(5)->subDays(2)->toDateString(),'allergies'=>null,'internal_code'=>'DETO403','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g19->id,'first_name'=>'Lucian','last_name'=>'Petrescu','birth_date'=>now()->subYears(6)->subDays(19)->toDateString(),'allergies'=>null,'internal_code'=>'LUPE404','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g20->id,'first_name'=>'Anca','last_name'=>'Enache','birth_date'=>now()->subYears(7)->subDays(28)->toDateString(),'allergies'=>null,'internal_code'=>'ANEN405','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g21->id,'first_name'=>'Eduard','last_name'=>'Matei','birth_date'=>now()->subYears(4)->subDays(40)->toDateString(),'allergies'=>null,'internal_code'=>'EDMA406','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g22->id,'first_name'=>'Raluca','last_name'=>'Ilie','birth_date'=>now()->subYears(8)->subDays(32)->toDateString(),'allergies'=>null,'internal_code'=>'RAIL407','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g23->id,'first_name'=>'Adrian','last_name'=>'Rusu','birth_date'=>now()->subYears(6)->subDays(18)->toDateString(),'allergies'=>null,'internal_code'=>'ADRU408','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g24->id,'first_name'=>'Sabina','last_name'=>'Sandu','birth_date'=>now()->subYears(7)->subDays(8)->toDateString(),'allergies'=>null,'internal_code'=>'SASA409','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g25->id,'first_name'=>'George','last_name'=>'Barbu','birth_date'=>now()->subYears(5)->subDays(11)->toDateString(),'allergies'=>null,'internal_code'=>'GEBA410','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g26->id,'first_name'=>'Ilinca','last_name'=>'Voicu','birth_date'=>now()->subYears(9)->subDays(7)->toDateString(),'allergies'=>null,'internal_code'=>'ILVO411','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g27->id,'first_name'=>'Matei','last_name'=>'Rotaru','birth_date'=>now()->subYears(6)->subDays(21)->toDateString(),'allergies'=>null,'internal_code'=>'MARO412','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g28->id,'first_name'=>'Daria','last_name'=>'Neagu','birth_date'=>now()->subYears(8)->subDays(16)->toDateString(),'allergies'=>null,'internal_code'=>'DANE413','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g29->id,'first_name'=>'Sergiu','last_name'=>'Sava','birth_date'=>now()->subYears(7)->subDays(4)->toDateString(),'allergies'=>null,'internal_code'=>'SESA414','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g30->id,'first_name'=>'Laura','last_name'=>'Badea','birth_date'=>now()->subYears(5)->subDays(6)->toDateString(),'allergies'=>null,'internal_code'=>'LABA415','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g31->id,'first_name'=>'Tudor','last_name'=>'Vasilescu','birth_date'=>now()->subYears(8)->subDays(10)->toDateString(),'allergies'=>null,'internal_code'=>'TUVA416','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g32->id,'first_name'=>'Mara','last_name'=>'Dragomir','birth_date'=>now()->subYears(6)->subDays(14)->toDateString(),'allergies'=>null,'internal_code'=>'MADR417','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g33->id,'first_name'=>'Rares','last_name'=>'Munteanu','birth_date'=>now()->subYears(9)->subDays(20)->toDateString(),'allergies'=>null,'internal_code'=>'RAMU418','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g34->id,'first_name'=>'Teodora','last_name'=>'Constantin','birth_date'=>now()->subYears(7)->subDays(13)->toDateString(),'allergies'=>null,'internal_code'=>'TECO419','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g35->id,'first_name'=>'Iulia','last_name'=>'Preda','birth_date'=>now()->subYears(6)->subDays(9)->toDateString(),'allergies'=>null,'internal_code'=>'IUPR420','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g36->id,'first_name'=>'Cosmin','last_name'=>'Lazar','birth_date'=>now()->subYears(4)->subDays(19)->toDateString(),'allergies'=>null,'internal_code'=>'COLA421','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g37->id,'first_name'=>'Anastasia','last_name'=>'Cojocaru','birth_date'=>now()->subYears(5)->subDays(28)->toDateString(),'allergies'=>null,'internal_code'=>'ANCO422','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g38->id,'first_name'=>'Ioan','last_name'=>'Coman','birth_date'=>now()->subYears(6)->subDays(32)->toDateString(),'allergies'=>null,'internal_code'=>'IOCO423','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g39->id,'first_name'=>'Patricia','last_name'=>'Paraschiv','birth_date'=>now()->subYears(7)->subDays(26)->toDateString(),'allergies'=>null,'internal_code'=>'PAPA424','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g40->id,'first_name'=>'Bogdan','last_name'=>'Sima','birth_date'=>now()->subYears(8)->subDays(35)->toDateString(),'allergies'=>null,'internal_code'=>'BOSI425','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g41->id,'first_name'=>'Mihnea','last_name'=>'Grigore','birth_date'=>now()->subYears(9)->subDays(22)->toDateString(),'allergies'=>null,'internal_code'=>'MIGR426','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g42->id,'first_name'=>'Sorina','last_name'=>'Florea','birth_date'=>now()->subYears(5)->subDays(17)->toDateString(),'allergies'=>null,'internal_code'=>'SOFL427','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g43->id,'first_name'=>'David','last_name'=>'Georgescu','birth_date'=>now()->subYears(6)->subDays(24)->toDateString(),'allergies'=>null,'internal_code'=>'DAGE428','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g44->id,'first_name'=>'Ilinca','last_name'=>'Balasa','birth_date'=>now()->subYears(7)->subDays(11)->toDateString(),'allergies'=>null,'internal_code'=>'ILBA429','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g45->id,'first_name'=>'Vasile','last_name'=>'Baciu','birth_date'=>now()->subYears(8)->subDays(6)->toDateString(),'allergies'=>null,'internal_code'=>'VABA430','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g46->id,'first_name'=>'Silvia','last_name'=>'Iacob','birth_date'=>now()->subYears(6)->subDays(33)->toDateString(),'allergies'=>null,'internal_code'=>'SLIA431','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g47->id,'first_name'=>'Rares','last_name'=>'Cretu','birth_date'=>now()->subYears(5)->subDays(41)->toDateString(),'allergies'=>null,'internal_code'=>'RACR432','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g48->id,'first_name'=>'Cezar','last_name'=>'Neacsu','birth_date'=>now()->subYears(9)->subDays(13)->toDateString(),'allergies'=>null,'internal_code'=>'CENE433','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g49->id,'first_name'=>'Timea','last_name'=>'Pavel','birth_date'=>now()->subYears(7)->subDays(29)->toDateString(),'allergies'=>null,'internal_code'=>'TIPA434','notes'=>null]);
        Child::create(['tenant_id'=>$tenantId,'guardian_id'=>$g50->id,'first_name'=>'Narcis','last_name'=>'Antonescu','birth_date'=>now()->subYears(6)->subDays(37)->toDateString(),'allergies'=>null,'internal_code'=>'NAAN435','notes'=>null]);
    }
}


