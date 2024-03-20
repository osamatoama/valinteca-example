<?php

namespace Database\Seeders;

use App\Models\Code;
use App\Models\Email;
use App\Models\Player;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $codes = [
            'wTVW6qg52S265cfeNb',
            'wTVW6dgy2x2a50f2Pd',
            'wTVW6ZgJ2X275cf9Q9',
            'wTVW6hgF2H215bfdRc',
            'wTVW6EgW2v245ef2S0',
            'wTVW6Pgi2c2d53f9T0',
            'wTVW6Qgs2M2b5bf0U0',
            'wTVW6RgJ2w2551f9V8',
            'wTVW6xgB2h205cf5Wc',
            'wTVW6Pgw242956fcXc',
            'wTVW6mgY2r265af6Y7',
            'wTVW6Egw2q2c5bf5Z6',
            'wTVW6wgW2A2652fda0',
            'wTVW6Fg22A2f5ff4b6',
            'wTVW6Wgy2e2458f7c1',
            'wTVW6TgN2A2b58fed8',
            'wTVW66gm2n2b5df6ef',
            'wTVW6Cgx272252f1f1',
            'wTVW6tgg2G2759f4ga',
            'wTVW6Ng62x2555ffh2',
            'wTVW6Qgc2H285bf0id',
            'wTVW63gr2F2354f5j6',
            'wTVW6sgn2j2f5cfbkf',
            'wTVW6mgp2W2454fcm6',
            'wTVW6ggL2V2458f0n2',
            'wTVW68gm2s2c52f1p0',
            'wTVW6Hgc2R275bfeq0',
            'wTVW6qgZ2A2256f5r7',
            'wTVW6vgU2q2f53f1se',
            'wTVW6wgb2f265bfdt7',
            'wTVW6ggm2J2a5bfdu0',
            'wTVW6xgn2u2c5dfbv1',
            'wTVW6xgS2V2d5cfcwd',
            'wTVW6VgE2K2f5ffaxd',
            'wTVW62gf2d2458f8ya',
            'wTVW6Wgn2D205ef0z6',
            'wTVW6Agq2p2d5bg521',
            'wTVW6Lgf2B2653g431',
            'wTVW6UgN2Q2452g843',
            'wTVW66g622225bg359',
            'wTVW6jgk2m2458gb63',
            'wTVW6ngW2b2553gd70',
            'wTVW6igU24255egf8f',
            'wTVW6Egx242a5bg596',
            'wTVW6Jgj2h2b5egbA9',
            'wTVW6vg32H2055geB4',
            'wTVW69gB282057g3C3',
            'wTVW6igG2Y285bgaD2',
            'wTVW6tgi2u235cg2E3',
            'wTVW65gZ222e55g8F7',
            'wTVW65g62X2150g9G8',
            'wTVW6rgs2n2f58geH7',
            'wTVW6EgN252c5dgeJd',
            'wTVW63gM2m255fg5Kf',
            'wTVW6pgd2X2950g0L7',
            'wTVW6YgM2Y2552gbMb',
            'wTVW6pgU2U295ag6N6',
            'wTVW6hgx2i245eg3Pc',
            'wTVW6Ggr2E2958g5Qa',
            'wTVW6wgf2m2a5cgfRe',
            'wTVW6hgj2c2151gbSb',
            'wTVW6FgN2H2852g7Ta',
            'wTVW6pga2d2750gfUd',
            'wTVW6sgN2k2555g4V6',
            'wTVW6RgD2Q2e5agdW6',
            'wTVW6xgW2W2459gdX9',
            'wTVW6HgL222159g4Y2',
            'wTVW6kgn2x2d54g0Z2',
            'wTVW6Ggq2b2b55g6a5',
            'wTVW6Vgm2H2959gdbc',
            'wTVW64gV2m2b57gccb',
            'wTVW6fgV2A2353gad6',
            'wTVW6hgK2V2459geea',
            'wTVW6Mgw2d2e59gef9',
            'wTVW6sgP2q295cg1gc',
            'wTVW65g82M2952gah3',
            'wTVW6ZgP2S2252g3i1',
            'wTVW6Zgu2G2152g4jb',
            'wTVW6KgC2r2d59g6k9',
            'wTVW6fgS2d245bgem3',
            'wTVW6hgU292e5agcn0',
            'wTVW6Hgu2P225eg9p2',
            'wTVW6Cgc2U2551gaq7',
            'wTVW6Tgj2R2c56gfr7',
            'wTVW67gc2Z2459ges8',
            'wTVW6vgf2S255cg8t4',
            'wTVW64g32b285egcu5',
            'wTVW6UgM2H2157g3vc',
            'wTVW6VgR2E2f5ag3w8',
            'wTVW6Mg72e245dgfx9',
            'wTVW6jga2u285eg3y3',
            'wTVW6sgr2p2c5eg9z8',
            'wTVW6Hg42E2b54hf26',
            'wTVW6WgV2x2257ha36',
            'wTVW6ggM2M205ah541',
            'wTVW6HgH2n235dhe56',
            'wTVW6UgK2p2051ha64',
            'wTVW66gZ2v2e55ha7f',
            'wTVW69gp2N2453h086',
            'REtMFAeW252541Q1Ec',
            'REtMFvec2a2549QdF5',
            'REtMFgeN272141QbGb',
            'REtMFker2L234fQ3H0',
            'REtMF6eQ2G224cQ1J9',
            'REtMFter262144Q6K3',
            'REtMFbey2P2644Q1L7',
            'REtMFfeL2s2240Q0M2',
            'REtMFQeE232049QbN7',
            'REtMFYeW2P2240Q3Pf',
            'REtMFveS2u2444Q7Qf',
            'REtMFyeN2J2441Q0R1',
            'REtMFLep2R2a4cQ4S3',
            'REtMFReN2H2340QeTd',
            'REtMFWeS2S274bQdUc',
            'REtMFke72J2144Q3V2',
            'REtMFceh2J2d45QaW6',
            'REtMF2eA2P2647QbX3',
            'REtMFdeK2N2e41Q5Yd',
            'REtMFeec2s2245Q0Z0',
            'REtMF5eY262b4bQ0a7',
            'REtMFieX2S2044Q4b6',
            'REtMFmer24254bQ5ce',
            'REtMFye42Q204eQbd9',
            'REtMFGeL2b2241Q6e9',
            'REtMFUe72g2143Qbf0',
            'REtMFkeU2B2a42Q2gf',
            'REtMFpeU262f4bQ4h0',
            'REtMFxe82P2545Q4i3',
            'REtMFLeY222a43Q0j5',
            'REtMFyeN2Y2b4cQckd',
            'REtMF5er2q2146Q0ma',
            'REtMFHed2T2c4aQ9nd',
            'REtMFKec2W2843Qcp4',
            'REtMFUee2b2641Q4q2',
            'REtMF6e92g2243Qdr2',
            'REtMFXee2w284cQesf',
            'REtMFUeG2R284bQdt0',
            'REtMFYeE2K264dQ7uf',
            'REtMFheZ2c2b42Q1v1',
            'REtMFheY2y2242Q8wd',
            'REtMF4eN2q2c46Q2x0',
            'REtMFsed2F2847Q3y0',
            'REtMF8ew2d2a43Qbz0',
            'REtMFPeC2J2948R02a',
            'REtMFye32C264fR939',
            'REtMFSeZ2q2d48R140',
            'REtMFPen272146Ra57',
            'REtMFae8272d4bRf67',
            'REtMFtep2e2f4bR072',
            'REtMFHeK2x2845Rd8b',
            'REtMFGe82L2f44R893',
            'REtMFrej2j2341R1A9',
            'REtMFrer2g2f41RbB2',
            'REtMFVeF2t2346R0C3',
            'REtMFmeE2f2345R5Da',
            'REtMFief222d46ReEa',
            'REtMFMe52n2d47RaF5',
            'REtMFDed2g2943R2G7',
            'REtMFJeJ2H2a4cRaHc',
            'REtMFheL2a2b46R8Jf',
            'REtMFSeM2g2a46R9K8',
            'REtMFmeD2T2945RbL9',
            'REtMFXe6262e4fR8M7',
            'REtMFyeZ2L2544R3N7',
            'REtMFde92K2c42R6P6',
            'REtMFLec2j244eR8Q2',
            'REtMFLex2p2b49RaRc',
            'REtMFueC2E224bRbS5',
            'REtMFbeU2J2e44R5T1',
            'REtMFsex2P2245R7U7',
            'REtMFFeQ2j2b4bR9V9',
            'REtMFgeC2w2d4aR5W6',
            'REtMFueU2m2349R1X5',
            'REtMF2eF29294bRcYd',
            'REtMFLed232042RdZ6',
            'REtMFQex2d254dR1ae',
            'REtMFBe62c2842Rdb5',
            'REtMFjej2Z2347Race',
            'REtMFxeM2n2a42R2d6',
            'REtMF3ey2k2a40R3ea',
            'REtMFReE2C2742R2ff',
            'REtMFveg292e41Rcg4',
            'REtMFdeb2P214aR5h3',
            'REtMFSeb2c224aRei2',
            'REtMFLeg2G2445R7jf',
            'REtMFMe8222344R4k8',
            'REtMFyeH2q274aR4ma',
            'REtMFNe32a2647R3n1',
            'REtMFgej2g2142R7pa',
            'REtMFWeY2f2e41R8qc',
            'REtMFHei2f2140R9r7',
            'REtMFTee2N2b40R2s6',
            'REtMFbeJ2i2d44R5t3',
            'REtMFyeV2M2343R8ud',
            'REtMFNep242a4bR9va',
            'REtMFPeB2A2c48R8w9',
            'REtMFPev2C2f45R7x4',
            'REtMFye52D2b43Reyf',
            'REtMFZek2i224fRdza',

        ];


        foreach ($codes as $code) {
            Code::create([
                'code' => $code,
            ]);
        }
        Player::create([
            'player_id' => '5254742728',
        ]);
        Player::create([
            'player_id' => '533038203',
        ]);

        Email::create([
            'username' => 'altoama@outlook.com' ,
            'password' => 'Kmw223963',
        ]);


        Email::create([
            'username' => 'kareem1alnouman@gmail.com' ,
            'password' => 'Youcan12@',
        ]);

        Email::create([
            'username' => 'zyayaolabi@gmail.com' ,
            'password' => 'Youcan12@',
        ]);

    }
}
