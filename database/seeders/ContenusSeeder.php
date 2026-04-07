<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\Chapitre;
use App\Models\SousChapitre;
use App\Models\Contenu;
use Illuminate\Database\Seeder;

class ContenusSeeder extends Seeder
{
    public function run(): void
    {
        // Création de la formation
        $formation = Formation::firstOrCreate(
            ['nom' => 'Anglais niveau débutant'],
            [
                'description' => 'Formation complète pour apprendre les bases de l\'anglais.',
                'niveau'      => 'Débutant',
                'duree'       => '4 semaines',
            ]
        );

        // Chapitre unique
        $chapitre = Chapitre::firstOrCreate(
            ['titre' => 'Les verbes irréguliers', 'formation_id' => $formation->id],
            ['description' => 'Comprendre, apprendre et mémoriser les verbes irréguliers anglais.']
        );

        // ──────────────────────────────────────────────────────
        // Sous-chapitre 1 : Définition
        // ──────────────────────────────────────────────────────
        $sc1 = SousChapitre::firstOrCreate(
            ['titre' => 'Définition', 'chapitre_id' => $chapitre->id],
            ['contenu' => 'Un verbe irrégulier est un verbe dont la conjugaison ne suit pas les règles habituelles. En anglais, les verbes réguliers forment leur prétérit et leur participe passé en ajoutant simplement -ed (ex : work → worked). Les verbes irréguliers, eux, ont des formes spécifiques qu\'il faut mémoriser (ex : go → went → gone).']
        );

        Contenu::firstOrCreate(
            ['titre' => 'Qu\'est-ce qu\'un verbe irrégulier ?', 'sous_chapitre_id' => $sc1->id],
            [
                'texte' => "Un verbe irrégulier est un verbe dont les formes du passé (prétérit et participe passé) ne se construisent pas selon les règles habituelles.\n\n"
                    . "En anglais, les verbes réguliers ajoutent simplement **-ed** à l'infinitif :\n"
                    . "- work → worked → worked\n"
                    . "- play → played → played\n\n"
                    . "Les verbes irréguliers, eux, changent de forme de façon imprévisible :\n"
                    . "- go → went → gone\n"
                    . "- eat → ate → eaten\n"
                    . "- be → was/were → been\n\n"
                    . "Il existe environ 200 verbes irréguliers courants en anglais. La bonne nouvelle : seule une cinquantaine est réellement indispensable dans la vie quotidienne.",
                'lien_ressource' => 'https://www.perfect-english-grammar.com/irregular-verbs.html',
            ]
        );

        // ──────────────────────────────────────────────────────
        // Sous-chapitre 2 : 10 verbes indispensables
        // ──────────────────────────────────────────────────────
        $sc2 = SousChapitre::firstOrCreate(
            ['titre' => '10 verbes indispensables', 'chapitre_id' => $chapitre->id],
            ['contenu' => 'Voici les 10 verbes irréguliers les plus utilisés en anglais courant, à connaître absolument.']
        );

        Contenu::firstOrCreate(
            ['titre' => 'Les 10 verbes irréguliers essentiels', 'sous_chapitre_id' => $sc2->id],
            [
                'texte' => "Voici les 10 verbes irréguliers les plus fréquents en anglais. Apprenez-les par cœur !\n\n"
                    . "| Infinitif | Prétérit | Participe Passé | Traduction |\n"
                    . "|-----------|----------|-----------------|------------|\n"
                    . "| be        | was/were | been            | être        |\n"
                    . "| have      | had      | had             | avoir       |\n"
                    . "| do        | did      | done            | faire       |\n"
                    . "| go        | went     | gone            | aller       |\n"
                    . "| say       | said     | said            | dire        |\n"
                    . "| get       | got      | got/gotten      | obtenir     |\n"
                    . "| make      | made     | made            | faire/créer |\n"
                    . "| know      | knew     | known           | savoir      |\n"
                    . "| think     | thought  | thought         | penser      |\n"
                    . "| come      | came     | come            | venir       |\n\n"
                    . "💡 Astuce : commencez par mémoriser la colonne 'Prétérit', la plus utilisée dans les phrases au passé.",
                'lien_ressource' => null,
            ]
        );

        // ──────────────────────────────────────────────────────
        // Sous-chapitre 3 : Méthode de mémorisation
        // ──────────────────────────────────────────────────────
        $sc3 = SousChapitre::firstOrCreate(
            ['titre' => 'Méthode de mémorisation', 'chapitre_id' => $chapitre->id],
            ['contenu' => 'Des techniques pratiques pour retenir les verbes irréguliers anglais efficacement et durablement.']
        );

        Contenu::firstOrCreate(
            ['titre' => '5 techniques pour mémoriser les verbes irréguliers', 'sous_chapitre_id' => $sc3->id],
            [
                'texte' => "Mémoriser des listes de verbes peut sembler fastidieux. Voici 5 méthodes éprouvées qui rendront l'apprentissage plus efficace et plus durable.\n\n"
                    . "**1. La répétition espacée (Spaced Repetition)**\n"
                    . "Utilisez des applications comme Anki ou Quizlet pour revoir les verbes à intervalles croissants. Votre cerveau retient mieux ce qu'il révise juste avant d'oublier.\n\n"
                    . "**2. Apprendre par groupes phonétiques**\n"
                    . "Regroupez les verbes qui ont une sonorité similaire :\n"
                    . "- ring/rang/rung, sing/sang/sung, drink/drank/drunk\n"
                    . "- find/found, bind/bound, wind/wound\n\n"
                    . "**3. Créer des phrases contextuelles**\n"
                    . "Au lieu de mémoriser 'go–went–gone' en isolation, créez une phrase : \"Yesterday, I *went* to the market and I have *gone* there many times.\"\n\n"
                    . "**4. La méthode des histoires mnémotechniques**\n"
                    . "Inventez une histoire absurde qui relie les formes : \"Le roi *felt* (felt) une *fée* (feel) qui *feel*ait sa barbe.\"\n\n"
                    . "**5. La pratique active (input compréhensible)**\n"
                    . "Lisez, regardez des films et écoutez des podcasts en anglais. Vous rencontrerez naturellement ces verbes en contexte, ce qui est la forme d'apprentissage la plus durable.",
                'lien_ressource' => 'https://www.ankiapp.com/',
            ]
        );

        $this->command->info('✅ Seeder ContenusSeeder exécuté avec succès !');
        $this->command->info("   Formation : {$formation->nom}");
        $this->command->info("   Chapitre  : {$chapitre->titre}");
        $this->command->info('   Sous-chapitres + Contenus créés : 3');
    }
}
