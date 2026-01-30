# CONTRAT DE DÉVELOPPEMENT D'APPLICATION MOBILE
## Projet Sanar Market - Application Mobile Flutter

---

**ENTRE LES SOUSSIGNÉS :**

**Le Client :** [Nom du Client]
**Adresse :** [Adresse]
**Email :** [Email]
**Téléphone :** [Téléphone]

**Le Prestataire (Développeur Freelance) :** [Votre Nom]
**Adresse :** [Votre Adresse]
**Email :** [Votre Email]
**Téléphone :** [Votre Téléphone]

Ci-après dénommés respectivement "Le Client" et "Le Prestataire".

---

## 1. OBJET DU CONTRAT

Le présent contrat a pour objet la conception, le développement, la mise en production et l'accompagnement post-lancement d'une application mobile native pour la plateforme **Sanar Market**, marketplace communautaire destinée aux étudiants africains.

L'application mobile sera développée en **Flutter** et devra permettre l'accès complet à toutes les fonctionnalités de la plateforme web Laravel existante via une API REST.

---

## 2. DESCRIPTION DU PROJET

### 2.1. Vue d'ensemble
Sanar Market est une plateforme communautaire complète offrant :
- Marketplace d'annonces
- Boutiques/commerces en ligne
- Restaurants avec menus et horaires
- Gestion d'événements du campus
- Forum communautaire avec groupes
- Informations utiles (horaires de prière, pharmacies, carte du campus)
- Spotlight campus
- Système de publicités

### 2.2. Fonctionnalités à développer dans l'application mobile

#### A. Authentification et Profil Utilisateur
- Inscription/Connexion (email, téléphone)
- Profil utilisateur (édition, photo de profil)
- Gestion des préférences
- Notifications push
- Historique des activités

#### B. Marketplace d'Annonces
- Liste des annonces avec filtres et recherche
- Détail d'une annonce
- Création/édition/suppression d'annonces
- Upload de médias (photos, vidéos)
- Catégorisation avancée
- Favoris

#### C. Boutiques et Commerces
- Liste des boutiques approuvées
- Profil de boutique
- Catalogue d'articles avec recherche
- Détail d'un article
- Création et gestion de boutique (marchands)
- Gestion des articles et catégories

#### D. Restaurants
- Liste des restaurants
- Menus quotidiens
- Horaires d'ouverture
- Détail des plats
- Gestion de restaurant (propriétaires)
- Ajout/modification de menus

#### E. Événements
- Calendrier des événements
- Liste des événements du campus
- Détails d'un événement
- Création d'événements
- Inscription aux événements
- Partage d'événements

#### F. Forum Communautaire
- Liste des groupes de discussion
- Création/rejoindre un groupe
- Threads de discussion
- Système de réponses/nested comments
- Notifications de réponses
- Recherche dans les discussions

#### G. Informations Utiles
- Horaires de prière (selon géolocalisation)
- Pharmacies de garde
- Carte interactive du campus
- Contacts de l'université
- Autres informations pratiques

#### H. Campus Spotlight
- Contenus mis en avant
- Actualités du campus

#### I. Publicités
- Affichage des publicités approuvées
- Format bannière et interstitiel

#### J. Administration (pour administrateurs)
- Dashboard administratif
- Modération des contenus
- Gestion des utilisateurs
- Gestion des boutiques/restaurants
- Statistiques

#### K. Fonctionnalités Transverses
- Recherche globale avancée
- Filtres multiples
- Partage social (WhatsApp, Facebook, etc.)
- Géolocalisation
- Mode hors-ligne (cache de données essentielles)
- Push notifications
- Gestion des médias (photos, vidéos)

---

## 3. JUSTIFICATION DU CHOIX DE FLUTTER

### 3.1. Avantages techniques

#### A. Développement Cross-Platform Unique
- **Un seul codebase** pour iOS et Android, réduisant le temps de développement de 50% par rapport au développement natif séparé
- **Maintenance simplifiée** : une seule base de code à maintenir au lieu de deux
- **Consistance UI/UX** : expérience utilisateur identique sur toutes les plateformes

#### B. Performance Native
- **Compilation Ahead-of-Time (AOT)** : performance comparable aux applications natives
- **60 FPS** : animations fluides grâce au moteur de rendu Skia
- **Démarrage rapide** : temps de lancement optimisé

#### C. Productivité Développeur
- **Hot Reload** : modifications visibles instantanément sans redémarrer l'application (gain de temps considérable)
- **Widgets riches** : bibliothèque UI complète et moderne
- **Écosystème mature** : packages disponibles via pub.dev (plus de 30,000 packages)

#### D. Spécificités du Projet Sanar Market
- **API REST Laravel** : Flutter excelle dans la consommation d'APIs avec des packages comme `http`, `dio`, `retrofit`
- **Gestion de médias** : excellente prise en charge des images/vidéos avec `cached_network_image`, `video_player`
- **Offline-first** : packages robustes comme `sqflite`, `hive`, `get_storage` pour le cache local
- **Push notifications** : intégration simplifiée avec `firebase_messaging` ou `flutter_local_notifications`
- **Cartes et géolocalisation** : support natif avec `google_maps_flutter`, `geolocator`
- **Authentification** : intégration facile avec OAuth, JWT via Laravel Sanctum

#### E. Avantages Business
- **Réduction des coûts** : développement unique au lieu de deux équipes (iOS/Android)
- **Time-to-market plus court** : mise sur les stores plus rapide
- **Maintenance future facilitée** : mises à jour simultanées iOS/Android
- **Évolutivité** : facile d'ajouter de nouvelles fonctionnalités

#### F. Adoption et Communauté
- **Support Google** : framework soutenu activement par Google
- **Large communauté** : ressources, tutoriels, support abondants
- **Cas d'usage probants** : utilisée par Alibaba, Google Pay, BMW, eBay, etc.

#### G. Compatibilité Backend Laravel
- **Sanctum/T Passport** : authentification API seamless
- **WebSockets** : support pour temps réel avec Laravel Echo (package `pusher_channels_flutter`)
- **File upload** : gestion optimale des uploads multipart

### 3.2. Alternatives considérées et pourquoi Flutter est supérieur

**React Native :**
- ❌ Performance inférieure (bridge JavaScript)
- ❌ UI moins native
- ❌ Plus de dépendances natives

**Développement natif (Swift/Kotlin) :**
- ❌ Coût 2x plus élevé (2 équipes)
- ❌ Temps de développement 2x plus long
- ❌ Maintenance complexe (2 codebases)

**Ionic/Cordova :**
- ❌ Performance webview inférieure
- ❌ Expérience utilisateur moins native

**Flutter :**
- ✅ Meilleur rapport qualité/coût/temps
- ✅ Performance native
- ✅ Productivité maximale
- ✅ Idéal pour ce projet complexe multi-fonctionnalités

---

## 4. SPÉCIFICATIONS TECHNIQUES

### 4.1. Technologies et Outils

**Framework :**
- Flutter SDK 3.x (dernière version stable)
- Dart 3.x

**Architecture :**
- Architecture Clean Architecture / MVVM
- State Management : Provider ou Riverpod
- Navigation : Go Router ou Navigator 2.0
- Dependency Injection : GetIt ou Riverpod

**Gestion d'État et Logique Métier :**
- Provider/Riverpod pour la gestion d'état
- Repository pattern pour l'accès aux données
- Service layer pour la logique métier

**Réseau et API :**
- Dio ou HTTP pour les appels API
- Retrofit (optionnel) pour la génération de clients API
- Laravel Sanctum pour l'authentification

**Local Storage :**
- SharedPreferences pour les préférences simples
- Hive ou SQLite pour le cache de données
- Path Provider pour la gestion des fichiers

**UI/UX :**
- Material Design 3 ou Cupertino
- Packages UI : flutter_screenutil, cached_network_image
- Animations : flutter_animate, lottie

**Médias :**
- Image Picker pour la sélection de photos
- Image Cropper pour l'édition d'images
- Video Player pour les vidéos
- Cached Network Image pour le cache d'images

**Fonctionnalités Avancées :**
- Geolocator pour la géolocalisation
- Google Maps Flutter pour les cartes
- Firebase Messaging pour les push notifications
- Share Plus pour le partage social
- Connectivity Plus pour la gestion de la connectivité

**Tests :**
- Unit tests (test package)
- Widget tests
- Integration tests

### 4.2. Compatibilité
- **Android :** Android 5.0 (API 21) et supérieur (90%+ des appareils)
- **iOS :** iOS 12.0 et supérieur (95%+ des appareils)

### 4.3. API Backend
L'application consommera l'API REST Laravel existante. Le Prestataire devra :
- Documenter les endpoints nécessaires
- Proposer des améliorations API si nécessaire
- Gérer l'authentification via Sanctum/Passport

---

## 5. LIVRABLES

### 5.1. Code Source
- Code source complet de l'application Flutter
- Documentation technique complète
- Guide d'installation et de déploiement
- Architecture et décisions techniques documentées

### 5.2. Application Testable
- APK Android pour tests
- IPA iOS pour tests (via TestFlight)
- Version de démonstration fonctionnelle

### 5.3. Déploiement
- Publication sur Google Play Store
- Publication sur Apple App Store
- Gestion des métadonnées stores (descriptions, screenshots, icônes)

### 5.4. Documentation
- Documentation utilisateur (guide d'utilisation)
- Documentation développeur (architecture, APIs)
- Documentation de déploiement
- Charte graphique respectée

---

## 6. PLANNING ET DÉLAIS

### Phase 1 : Analyse et Conception (Semaine 1-2)
- Analyse des besoins détaillée
- Conception de l'architecture
- Wireframes et maquettes UI/UX
- Documentation API
- Setup du projet Flutter

**Livrables :** Architecture documentée, Wireframes, Plan de développement

### Phase 2 : Développement Core (Semaine 3-6)
- Setup architecture et packages
- Authentification et profil
- Marketplace d'annonces
- Boutiques et Restaurants
- Événements

**Livrables :** Module d'authentification, Modules core fonctionnels

### Phase 3 : Développement Avancé (Semaine 7-10)
- Forum communautaire
- Informations utiles
- Campus Spotlight
- Administration
- Fonctionnalités transverses

**Livrables :** Toutes les fonctionnalités implémentées

### Phase 4 : Tests et Optimisation (Semaine 11-12)
- Tests unitaires et d'intégration
- Tests utilisateurs (bêta)
- Correction de bugs
- Optimisation des performances
- Finalisation UI/UX

**Livrables :** Application testée et optimisée

### Phase 5 : Déploiement (Semaine 13-14)
- Préparation pour les stores
- Soumission Google Play
- Soumission App Store
- Accompagnement post-lancement (1 mois)

**Livrables :** Application publiée sur les stores

**Durée totale estimée :** 14 semaines (3.5 mois)

**Début prévu :** [Date]
**Fin prévue :** [Date + 14 semaines]

---

## 7. TARIFS ET MODALITÉS DE PAIEMENT

### 7.1. Tarification

Le projet est estimé à **2,400 heures** de développement (3.5 mois à temps plein).

#### Tarif Horaire
- **Tarif horaire :** 15,000 FCFA/heure
- **Justification du tarif :** 
  - Expertise Flutter avancée
  - Architecture complexe multi-modules
  - Intégration API complexe
  - UI/UX soignée
  - Tests et qualité
  - Déploiement sur stores

#### Répartition détaillée des coûts

| Phase | Tâches | Heures | Montant (FCFA) |
|-------|--------|--------|----------------|
| **Phase 1 : Analyse et Conception** | Architecture, Wireframes, Setup | 120h | 1,800,000 |
| **Phase 2 : Core** | Auth, Annonces, Boutiques, Restos, Événements | 800h | 12,000,000 |
| **Phase 3 : Avancé** | Forum, Infos, Admin, Transverse | 800h | 12,000,000 |
| **Phase 4 : Tests** | Tests, Bugs, Optimisation | 400h | 6,000,000 |
| **Phase 5 : Déploiement** | Stores, Documentation, Support | 280h | 4,200,000 |
| **TOTAL** | | **2,400h** | **36,000,000 FCFA** |

#### Options supplémentaires (hors contrat)

| Service | Tarif |
|---------|-------|
| Support technique mensuel | 2,000,000 FCFA/mois |
| Ajout de fonctionnalités supplémentaires | 15,000 FCFA/heure |
| Maintenance corrective | 15,000 FCFA/heure |
| Formation équipe technique | 3,000,000 FCFA/jour |
| Optimisation et refactoring | 15,000 FCFA/heure |

### 7.2. Modalités de paiement

Le paiement sera effectué selon le calendrier suivant :

- **Acompte (Signature du contrat) :** 30% = **10,800,000 FCFA**
- **Milestone 1 (Fin Phase 2 - Core) :** 30% = **10,800,000 FCFA**
- **Milestone 2 (Fin Phase 4 - Tests) :** 25% = **9,000,000 FCFA**
- **Solde (Livraison finale - Stores) :** 15% = **5,400,000 FCFA**

**Total : 36,000,000 FCFA**

### 7.3. Conditions de paiement
- Paiements par virement bancaire ou Mobile Money
- Facturation à chaque milestone avec facture professionnelle
- Délai de paiement : 7 jours ouvrés après validation du milestone
- Retard de paiement : pénalité de 2% par semaine de retard

---

## 8. OBLIGATIONS DU PRESTATAIRE

### 8.1. Développement
- Respecter les délais convenus
- Fournir un code de qualité, maintenable et documenté
- Respecter les bonnes pratiques Flutter/Dart
- Implémenter toutes les fonctionnalités spécifiées
- Assurer la compatibilité avec l'API Laravel existante

### 8.2. Tests et Qualité
- Effectuer des tests unitaires (couverture minimale 70%)
- Effectuer des tests d'intégration
- Corriger tous les bugs identifiés
- Optimiser les performances

### 8.3. Communication
- Rendre compte de l'avancement hebdomadaire
- Signalement immédiat de tout problème ou retard
- Participation aux réunions de suivi (hebdomadaire)
- Disponibilité pour questions/révisions

### 8.4. Documentation
- Documentation technique complète
- Documentation utilisateur
- Guide de déploiement
- Commentaires dans le code

### 8.5. Confidentialité
- Respecter la confidentialité des informations du Client
- Ne pas divulguer le code source à des tiers
- Signature d'un NDA si nécessaire

---

## 9. OBLIGATIONS DU CLIENT

### 9.1. Accès et Ressources
- Fournir l'accès à l'API Laravel (documentation, credentials de test)
- Fournir les assets graphiques (logos, images, charte graphique)
- Mettre à disposition un environnement de test/QA
- Donner accès aux comptes stores (Google Play, App Store)

### 9.2. Validation et Feedback
- Valider les milestones dans les délais convenus (7 jours)
- Fournir des retours constructifs et détaillés
- Tester les versions de démonstration fournies
- Valider les fonctionnalités selon les spécifications

### 9.3. Paiement
- Respecter les échéances de paiement
- Effectuer les paiements selon le calendrier convenu

---

## 10. GARANTIES ET SUPPORT

### 10.1. Garantie de conformité
Le Prestataire garantit que :
- L'application répond aux spécifications définies
- Le code est fonctionnel et de qualité
- L'application est compatible avec les versions Android/iOS spécifiées
- L'application passe les validations des stores

### 10.2. Garantie de bugs
- **Période de garantie :** 2 mois après la mise en production
- **Garantie couverte :** Correction gratuite des bugs critiques et bloquants
- **Non couvert :** 
  - Modifications de fonctionnalités
  - Changements de design non prévus
  - Bugs liés à des modifications post-livraison
  - Problèmes liés au backend/API

### 10.3. Support post-lancement
- **1 mois inclus :** Support technique inclus (corrections bugs, assistance déploiement)
- **Au-delà :** Support selon tarifs supplémentaires (voir section 7.1)

---

## 11. PROPRIÉTÉ INTELLECTUELLE

### 11.1. Code source
- Le code source de l'application sera la propriété du Client après paiement intégral
- Le Prestataire conserve le droit d'utiliser les librairies/génériques développés pour d'autres projets

### 11.2. Assets et contenu
- Les assets fournis par le Client restent sa propriété
- Le contenu de l'application appartient au Client

### 11.3. Open Source
- Les packages open source utilisés restent sous leur licence respective (MIT, Apache, etc.)

---

## 12. CONFIDENTIALITÉ

Les parties s'engagent à :
- Garder confidentielles toutes les informations échangées
- Ne pas divulguer les détails du projet à des tiers sans autorisation
- Utiliser les informations uniquement pour l'exécution du contrat

---

## 13. RÉSOLUTION DES LITIGES

### 13.1. Médiation
En cas de litige, les parties s'engagent à rechercher une solution amiable par la médiation.

### 13.2. Juridiction
À défaut d'accord amiable, les litiges seront portés devant les tribunaux compétents du pays du Client.

---

## 14. MODIFICATIONS DU CONTRAT

Toute modification du présent contrat doit faire l'objet d'un avenant écrit et signé par les deux parties.

### 14.1. Changements de scope
- Changements mineurs : négociation au cas par cas
- Changements majeurs : nouvel avenant avec ajustement tarifaire et délais

---

## 15. RÉSILIATION

### 15.1. Résiliation par le Client
- Le Client peut résilier le contrat avec un préavis de 15 jours
- Paiement des travaux effectués jusqu'à la date de résiliation
- Code source livré pour les phases complétées

### 15.2. Résiliation par le Prestataire
- En cas de non-paiement supérieur à 30 jours
- En cas de non-respect des obligations du Client empêchant l'exécution du contrat
- Préavis de 15 jours

---

## 16. FORCE MAJEURE

Aucune partie ne sera tenue responsable de tout retard ou défaillance dans l'exécution de ses obligations dû à des événements indépendants de sa volonté (catastrophe naturelle, guerre, pandémie, etc.).

---

## 17. ACCEPTATION ET SIGNATURE

Le présent contrat prend effet à la date de signature par les deux parties.

Fait en double exemplaire, à [Ville], le [Date]

---

**Le Client**                                    **Le Prestataire**

_______________________                          _______________________

[Nom et Prénom]                                  [Votre Nom]

Signature                                        Signature

---

## ANNEXES

### Annexe 1 : Détail des fonctionnalités par module
(À compléter avec les spécifications détaillées)

### Annexe 2 : Charte graphique et maquettes
(À joindre les maquettes UI/UX)

### Annexe 3 : Documentation API Laravel
(À joindre la documentation de l'API backend)

### Annexe 4 : Planning détaillé (Gantt)
(À joindre le planning détaillé avec jalons)

---

**Document contractuel - À usage professionnel uniquement**
