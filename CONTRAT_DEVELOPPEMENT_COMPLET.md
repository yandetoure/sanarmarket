# CONTRAT DE DÉVELOPPEMENT WEB ET MOBILE
## Projet Sanar Market - Plateforme Complète (Laravel + Flutter)

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

Le présent contrat a pour objet :

**PARTIE A :** La finalisation, l'amélioration et l'optimisation de la plateforme web **Sanar Market** développée en **Laravel**, incluant la création d'une **API REST complète** pour l'application mobile.

**PARTIE B :** La conception, le développement, la mise en production et l'accompagnement post-lancement d'une **application mobile native** pour iOS et Android développée en **Flutter**.

Sanar Market est une **marketplace communautaire complète** destinée aux étudiants africains, offrant des services de vente, restauration, événements, forum et informations pratiques.

---

## 2. ÉTAT ACTUEL DU PROJET

### 2.1. Plateforme Web Laravel (Partie A)
**État d'avancement :** ~70% complété

**Fonctionnalités déjà implémentées :**
- ✅ Système d'authentification (login, register, logout)
- ✅ Gestion des annonces (CRUD complet)
- ✅ Système de boutiques/commerces (création, gestion, articles)
- ✅ Système de restaurants (création, gestion, menus, horaires)
- ✅ Gestion des événements (création, modération)
- ✅ Forum communautaire (groupes, threads, réponses)
- ✅ Informations utiles (prière, pharmacies, carte campus)
- ✅ Campus Spotlight
- ✅ Système de publicités
- ✅ Administration complète (dashboard, modération, gestion utilisateurs)
- ✅ Dashboard utilisateur
- ✅ Interface Designer et Marketing
- ✅ Base de données complète (22 modèles)

**À finaliser/améliorer :**
- ⚠️ API REST incomplète (seulement quelques endpoints basiques)
- ⚠️ Optimisations de performance nécessaires
- ⚠️ Tests unitaires et d'intégration manquants
- ⚠️ Documentation technique à compléter
- ⚠️ Sécurisation API (Sanctum/Passport complet)
- ⚠️ Gestion avancée des médias (optimisation images)
- ⚠️ Notifications en temps réel (WebSockets/Pusher)
- ⚠️ Système de recherche avancée (Elasticsearch/Scout)
- ⚠️ Cache et optimisation (Redis, CDN)
- ⚠️ Gestion des paiements (si nécessaire)
- ⚠️ Export de données/rapports
- ⚠️ SEO et meta tags

### 2.2. Application Mobile Flutter (Partie B)
**État d'avancement :** 0% (à développer entièrement)

---

## 3. PARTIE A : FINALISATION PLATEFORME WEB LARAVEL

### 3.1. API REST Complète

#### A. Authentification API
- ✅ Implémentation Laravel Sanctum complète
- ✅ Tokens d'authentification (access token, refresh token)
- ✅ Gestion des permissions par rôle
- ✅ Middleware d'authentification API
- ✅ Rate limiting pour sécurité
- ✅ OAuth 2.0 (optionnel : Google, Facebook)

#### B. Endpoints API pour tous les modules

**Annonces :**
- GET `/api/announcements` (liste avec filtres, pagination, recherche)
- GET `/api/announcements/{id}` (détail)
- POST `/api/announcements` (création)
- PUT `/api/announcements/{id}` (modification)
- DELETE `/api/announcements/{id}` (suppression)
- POST `/api/announcements/{id}/upload-media` (upload médias)
- GET `/api/announcements/{id}/favorites` (favoris)
- POST `/api/announcements/{id}/favorite` (ajouter favori)

**Boutiques :**
- GET `/api/boutiques` (liste avec filtres)
- GET `/api/boutiques/{id}` (détail)
- POST `/api/boutiques` (création)
- PUT `/api/boutiques/{id}` (modification)
- GET `/api/boutiques/{id}/articles` (articles d'une boutique)
- POST `/api/boutiques/{id}/articles` (créer article)
- PUT `/api/boutiques/{id}/articles/{articleId}` (modifier article)
- DELETE `/api/boutiques/{id}/articles/{articleId}` (supprimer article)
- GET `/api/boutiques/{id}/categories` (catégories boutique)

**Restaurants :**
- GET `/api/restaurants` (liste avec filtres)
- GET `/api/restaurants/{id}` (détail)
- POST `/api/restaurants` (création)
- PUT `/api/restaurants/{id}` (modification)
- GET `/api/restaurants/{id}/menu` (menu du restaurant)
- GET `/api/restaurants/{id}/menu/daily` (menu du jour)
- POST `/api/restaurants/{id}/menu-items` (ajouter plat)
- PUT `/api/restaurants/{id}/menu-items/{itemId}` (modifier plat)
- GET `/api/restaurants/{id}/schedules` (horaires)
- POST `/api/restaurants/{id}/schedules` (ajouter horaire)

**Événements :**
- GET `/api/events` (liste avec filtres calendrier)
- GET `/api/events/{id}` (détail)
- POST `/api/events` (création)
- PUT `/api/events/{id}` (modification)
- DELETE `/api/events/{id}` (suppression)
- POST `/api/events/{id}/register` (inscription événement)
- GET `/api/events/{id}/participants` (participants)

**Forum :**
- GET `/api/forum/groups` (liste groupes)
- GET `/api/forum/groups/{id}` (détail groupe)
- POST `/api/forum/groups` (créer groupe)
- POST `/api/forum/groups/{id}/join` (rejoindre groupe)
- GET `/api/forum/groups/{id}/threads` (threads du groupe)
- POST `/api/forum/threads` (créer thread)
- GET `/api/forum/threads/{id}` (détail thread)
- POST `/api/forum/threads/{id}/replies` (répondre)
- GET `/api/forum/threads/{id}/replies` (réponses nested)

**Utilisateurs :**
- GET `/api/user` (profil utilisateur)
- PUT `/api/user` (modifier profil)
- POST `/api/user/avatar` (upload photo profil)
- GET `/api/user/announcements` (annonces utilisateur)
- GET `/api/user/boutiques` (boutiques utilisateur)
- GET `/api/user/restaurants` (restaurants utilisateur)

**Informations Utiles :**
- GET `/api/useful-info/prayer-times` (horaires prière selon géolocalisation)
- GET `/api/useful-info/pharmacy-on-duty` (pharmacies de garde)
- GET `/api/useful-info/university-contacts` (contacts université)
- GET `/api/useful-info/campus-map` (carte campus)

**Campus Spotlight :**
- GET `/api/campus-spotlight` (contenus mis en avant)

**Publicités :**
- GET `/api/advertisements/active` (publicités actives)

**Catégories :**
- GET `/api/categories` (toutes les catégories)
- GET `/api/categories/{id}` (catégorie avec sous-catégories)

#### C. Fonctionnalités API avancées
- Pagination standardisée (Laravel Resource)
- Filtres avancés (query parameters)
- Recherche full-text
- Tri et ordre
- Versioning API (v1, v2)
- Documentation API (Swagger/OpenAPI)
- Validation des données (Form Requests)
- Gestion des erreurs standardisée (JSON)
- Cache API (Redis)
- Rate limiting par endpoint

### 3.2. Optimisations et Améliorations Web

#### A. Performance
- Optimisation des requêtes N+1 (eager loading)
- Cache Redis pour données fréquentes
- CDN pour assets statiques (images, CSS, JS)
- Optimisation images (compression, formats WebP)
- Lazy loading images
- Minification CSS/JS en production
- Queue pour tâches lourdes (jobs)

#### B. Sécurité
- CSRF protection renforcée
- XSS protection
- SQL injection prevention (Eloquent)
- Rate limiting sur formulaires sensibles
- Validation stricte des uploads (types, taille)
- Sanitization des inputs
- HTTPS enforcement
- Headers de sécurité (CORS configurés)

#### C. Notifications Temps Réel
- WebSockets avec Laravel Echo + Pusher/Broadcasting
- Notifications push web (Service Worker)
- Notifications email (Mail Laravel)
- Notifications in-app (Bell icon)
- Système de notification unifié

#### D. Recherche Avancée
- Laravel Scout avec Algolia ou Meilisearch
- Recherche full-text dans annonces
- Recherche par catégorie, localisation
- Filtres combinés
- Suggestions de recherche

#### E. Tests
- Tests unitaires (PHPUnit) - couverture 70%+
- Tests d'intégration (features)
- Tests API (HTTP tests)
- Tests de régression
- CI/CD setup (GitHub Actions/GitLab CI)

#### F. Documentation
- Documentation API complète (Swagger)
- Documentation technique (README, architecture)
- Documentation utilisateur (guides)
- Commentaires code (PHPDoc)

#### G. SEO et Métadonnées
- Meta tags dynamiques
- Sitemap XML
- Robots.txt optimisé
- URLs SEO-friendly
- Schema.org markup
- Open Graph tags

### 3.3. Fonctionnalités Web Supplémentaires

- Export données (Excel, PDF)
- Tableaux de bord analytics
- Système de rapports
- Gestion avancée des rôles/permissions (Spatie Permission)
- Historique des modifications (audit log)
- Backup automatique base de données
- Monitoring et logs (Sentry, Laravel Telescope)

---

## 4. PARTIE B : DÉVELOPPEMENT APPLICATION MOBILE FLUTTER

### 4.1. Justification du Choix de Flutter

#### A. Avantages Techniques

**Développement Cross-Platform Unique :**
- ✅ **Un seul codebase** pour iOS et Android → Réduction de 50% du temps vs développement natif séparé
- ✅ **Maintenance simplifiée** : une seule base de code au lieu de deux
- ✅ **Consistance UI/UX** : expérience identique sur toutes les plateformes

**Performance Native :**
- ✅ **Compilation AOT** : performance comparable aux applications natives
- ✅ **60 FPS** : animations fluides grâce au moteur Skia
- ✅ **Démarrage rapide** : optimisé pour la réactivité

**Productivité Développeur :**
- ✅ **Hot Reload** : modifications visibles instantanément (gain de temps considérable)
- ✅ **Widgets riches** : bibliothèque UI complète et moderne
- ✅ **Écosystème mature** : 30,000+ packages (pub.dev)

#### B. Parfait pour Sanar Market

**API REST Laravel :**
- ✅ Intégration seamless avec Dio, Retrofit
- ✅ Gestion des tokens Sanctum
- ✅ Upload multipart optimisé

**Gestion Médias :**
- ✅ Excellente prise en charge images/vidéos (cached_network_image, video_player)
- ✅ Cache local efficace
- ✅ Compression avant upload

**Offline-First :**
- ✅ Packages robustes : SQLite, Hive, GetStorage
- ✅ Synchronisation intelligente
- ✅ Expérience utilisateur fluide même hors ligne

**Fonctionnalités Avancées :**
- ✅ Push notifications (Firebase Messaging)
- ✅ Géolocalisation native (geolocator)
- ✅ Cartes interactives (google_maps_flutter)
- ✅ Partage social (share_plus)
- ✅ QR codes et scanning

**Authentification :**
- ✅ JWT/Sanctum compatible
- ✅ Biométrie (local_auth)
- ✅ Social login (Google, Facebook)

#### C. Avantages Business
- ✅ **Réduction des coûts** : un seul développeur au lieu de deux équipes
- ✅ **Time-to-market rapide** : publication simultanée iOS/Android
- ✅ **Maintenance facilitée** : mises à jour synchronisées
- ✅ **Évolutivité** : facile d'ajouter nouvelles fonctionnalités

#### D. Alternatives Rejetées

**React Native :** Performance inférieure, UI moins native
**Natif (Swift+Kotlin) :** Coût 2x, temps 2x, maintenance complexe
**Ionic/Cordova :** Performance webview médiocre

**Flutter = Meilleur choix pour ce projet complexe** ✅

### 4.2. Fonctionnalités de l'Application Mobile

#### A. Authentification et Profil
- Inscription/Connexion (email, téléphone, social login)
- Profil utilisateur (édition, photo de profil)
- Gestion des préférences (notifications, langue, thème)
- Notifications push (Firebase)
- Historique des activités
- Authentification biométrique (optionnel)

#### B. Marketplace d'Annonces
- Liste des annonces (grid/list view)
- Filtres avancés (catégorie, prix, localisation, date)
- Recherche full-text
- Détail d'une annonce (galerie images, vidéos)
- Création/édition/suppression d'annonces
- Upload de médias multiples (photos, vidéos)
- Catégorisation avancée
- Système de favoris
- Partage social (WhatsApp, Facebook, etc.)
- Contact vendeur (messagerie in-app ou SMS)

#### C. Boutiques et Commerces
- Liste des boutiques approuvées (carte/liste)
- Profil de boutique (infos, horaires, localisation)
- Catalogue d'articles avec recherche
- Détail d'un article (images, description, prix, disponibilité)
- Filtres par catégorie, prix
- Création et gestion de boutique (marchands)
- Gestion des articles (CRUD complet)
- Gestion des catégories boutique
- Statistiques de vente (pour marchands)
- Notifications nouvelles commandes

#### D. Restaurants
- Liste des restaurants (carte/liste)
- Profil restaurant (infos, localisation, horaires)
- Menu du jour
- Menus complets par catégorie
- Détail d'un plat (images, description, prix, allergènes)
- Horaires d'ouverture dynamiques
- Gestion de restaurant (propriétaires)
- Ajout/modification de menus
- Gestion des horaires
- Menu du campus (Restau 1, Restau 2)

#### E. Événements
- Calendrier des événements (vue mois/semaine/jour)
- Liste des événements du campus
- Filtres (date, type, localisation)
- Détails d'un événement (description, lieu, participants)
- Création d'événements
- Inscription aux événements
- Liste des participants
- Partage d'événements
- Rappels notifications

#### F. Forum Communautaire
- Liste des groupes de discussion (recherche, filtres)
- Création de groupe
- Rejoindre/quitter un groupe
- Threads de discussion (liste, pagination)
- Détail d'un thread (auteur, date, contenu)
- Système de réponses nested (commentaires imbriqués)
- Notifications de réponses
- Recherche dans les discussions
- Réactions (like, emoji)
- Modération (admin/moderateurs)

#### G. Informations Utiles
- Horaires de prière (selon géolocalisation, calcul automatique)
- Notifications rappel prière (optionnel)
- Pharmacies de garde (liste, localisation, contacts)
- Carte interactive du campus (Google Maps intégrée)
- Points d'intérêt (bibliothèques, services, etc.)
- Contacts de l'université (départements, services)
- Infos pratiques (transport, logement, etc.)

#### H. Campus Spotlight
- Contenus mis en avant (carrousel)
- Actualités du campus
- Annonces importantes
- Notifications push pour nouveaux contenus

#### I. Publicités
- Affichage des publicités approuvées
- Format bannière (en-tête, bas de page)
- Format interstitiel (entre pages)
- Format vidéo (optionnel)
- Ciblage géographique

#### J. Administration (pour administrateurs)
- Dashboard administratif (statistiques)
- Modération des contenus (annonces, posts, commentaires)
- Gestion des utilisateurs (activer/désactiver, changer rôle)
- Gestion des boutiques/restaurants (approbation, modération)
- Statistiques globales (graphiques)
- Rapports d'activité
- Gestion des publicités

#### K. Fonctionnalités Transverses
- Recherche globale avancée (tous modules)
- Filtres multiples et combinés
- Partage social (WhatsApp, Facebook, Twitter, etc.)
- Géolocalisation (carte, distance, navigation)
- Mode hors-ligne (cache données essentielles)
- Synchronisation automatique au retour en ligne
- Push notifications (toutes activités importantes)
- Gestion des médias (galerie, caméra, compression)
- Thème clair/sombre
- Multi-langue (français, anglais)
- Accessibilité (lecteurs d'écran)

### 4.3. Spécifications Techniques Mobile

**Framework :** Flutter SDK 3.x (dernière stable)
**Langage :** Dart 3.x

**Architecture :**
- Clean Architecture / MVVM
- State Management : Provider ou Riverpod
- Navigation : Go Router
- Dependency Injection : GetIt ou Riverpod

**Packages Principaux :**
- `dio` : Appels API REST
- `provider` / `riverpod` : State management
- `go_router` : Navigation
- `cached_network_image` : Cache images
- `sqflite` / `hive` : Stockage local
- `firebase_messaging` : Push notifications
- `geolocator` : Géolocalisation
- `google_maps_flutter` : Cartes
- `image_picker` : Sélection photos
- `share_plus` : Partage social
- `flutter_localizations` : Internationalisation
- `permission_handler` : Gestion permissions
- `connectivity_plus` : Détection connexion
- `shimmer` : Loading states
- `pull_to_refresh` : Actualisation

**Compatibilité :**
- Android : 5.0+ (API 21+) → 90%+ appareils
- iOS : 12.0+ → 95%+ appareils

---

## 5. PLANNING ET DÉLAIS

### Phase 1 : Finalisation API Laravel (Semaines 1-3)
- Complétion de tous les endpoints API
- Implémentation Sanctum complète
- Documentation API (Swagger)
- Tests API
- Optimisations

**Livrables :** API REST complète et documentée, Tests passants

### Phase 2 : Optimisations Web Laravel (Semaines 4-5)
- Optimisations performance
- Cache Redis
- WebSockets/Pusher
- Recherche avancée (Scout)
- Tests et corrections

**Livrables :** Plateforme web optimisée et testée

### Phase 3 : Développement Mobile - Core (Semaines 6-10)
- Setup architecture Flutter
- Authentification et profil
- Marketplace annonces
- Boutiques et Restaurants
- Événements

**Livrables :** Modules core fonctionnels

### Phase 4 : Développement Mobile - Avancé (Semaines 11-14)
- Forum communautaire
- Informations utiles
- Campus Spotlight
- Administration
- Fonctionnalités transverses

**Livrables :** Toutes fonctionnalités implémentées

### Phase 5 : Tests et Optimisation (Semaines 15-16)
- Tests unitaires et d'intégration (web + mobile)
- Tests utilisateurs (bêta)
- Correction bugs
- Optimisation performances
- Finalisation UI/UX

**Livrables :** Applications testées et optimisées

### Phase 6 : Déploiement (Semaines 17-18)
- Déploiement web (production)
- Préparation stores mobile
- Soumission Google Play
- Soumission App Store
- Documentation finale

**Livrables :** Applications publiées et opérationnelles

**Durée totale estimée :** 18 semaines (4.5 mois)

**Début prévu :** [Date]
**Fin prévue :** [Date + 18 semaines]

---

## 6. TARIFS ET MODALITÉS DE PAIEMENT

### 6.1. Tarification Globale

Le projet complet est estimé à **3,400 heures** de développement.

#### Tarif Horaire
- **Tarif horaire :** 15,000 FCFA/heure
- **Justification :**
  - Expertise Laravel avancée (API, performance, sécurité)
  - Expertise Flutter cross-platform
  - Architecture complexe multi-modules
  - Intégration API complexe
  - UI/UX soignée (web + mobile)
  - Tests et qualité
  - Déploiement et documentation

#### Répartition Détaillée des Coûts

| Partie | Phase | Tâches | Heures | Montant (FCFA) |
|--------|-------|--------|--------|----------------|
| **PARTIE A : Web Laravel** |
| | Phase 1 : API Complète | Endpoints, Sanctum, Docs, Tests | 280h | 4,200,000 |
| | Phase 2 : Optimisations | Performance, Cache, WebSockets, Recherche | 240h | 3,600,000 |
| | **Sous-total Partie A** | | **520h** | **7,800,000** |
| **PARTIE B : Mobile Flutter** |
| | Phase 3 : Core | Architecture, Auth, Annonces, Boutiques, Restos, Événements | 800h | 12,000,000 |
| | Phase 4 : Avancé | Forum, Infos, Admin, Transverse | 800h | 12,000,000 |
| | Phase 5 : Tests | Tests, Bugs, Optimisation | 400h | 6,000,000 |
| | Phase 6 : Déploiement | Stores, Documentation, Support | 280h | 4,200,000 |
| | **Sous-total Partie B** | | **2,280h** | **34,200,000** |
| **PARTIE C : Intégration & Tests Globaux** |
| | Tests d'intégration | Tests web + mobile ensemble | 200h | 3,000,000 |
| | Documentation globale | Docs techniques complètes | 160h | 2,400,000 |
| | **Sous-total Partie C** | | **360h** | **5,400,000** |
| **TOTAL GLOBAL** | | | **3,160h** | **47,400,000 FCFA** |

*Note : Les heures peuvent varier de ±10% selon la complexité réelle*

### 6.2. Options Supplémentaires (hors contrat)

| Service | Tarif |
|---------|-------|
| Support technique mensuel | 2,500,000 FCFA/mois |
| Ajout de fonctionnalités supplémentaires | 15,000 FCFA/heure |
| Maintenance corrective | 15,000 FCFA/heure |
| Formation équipe technique | 3,000,000 FCFA/jour |
| Optimisation et refactoring | 15,000 FCFA/heure |
| Hébergement et déploiement (annuel) | 1,500,000 FCFA/an |

### 6.3. Modalités de Paiement

Le paiement sera effectué selon le calendrier suivant :

- **Acompte (Signature du contrat) :** 30% = **14,220,000 FCFA**
- **Milestone 1 (Fin Phase 2 - API Laravel) :** 20% = **9,480,000 FCFA**
- **Milestone 2 (Fin Phase 4 - Mobile Avancé) :** 25% = **11,850,000 FCFA**
- **Milestone 3 (Fin Phase 5 - Tests) :** 15% = **7,110,000 FCFA**
- **Solde (Livraison finale - Déploiement) :** 10% = **4,740,000 FCFA**

**Total : 47,400,000 FCFA**

### 6.4. Conditions de Paiement
- Paiements par virement bancaire ou Mobile Money
- Facturation à chaque milestone avec facture professionnelle
- Délai de paiement : 7 jours ouvrés après validation du milestone
- Retard de paiement : pénalité de 2% par semaine de retard

---

## 7. LIVRABLES

### 7.1. Partie A : Web Laravel

#### Code Source
- Code source Laravel complet et optimisé
- Migration base de données finale
- Seeders pour données de test
- Configuration production (env.example)

#### API
- API REST complète et fonctionnelle
- Documentation API (Swagger/OpenAPI)
- Collection Postman/Insomnia
- Tests API (HTTP tests)

#### Documentation
- Documentation technique (README, architecture)
- Guide d'installation et déploiement
- Documentation API
- Commentaires code (PHPDoc)

#### Tests
- Tests unitaires (couverture 70%+)
- Tests d'intégration
- Rapport de couverture de code

### 7.2. Partie B : Mobile Flutter

#### Code Source
- Code source Flutter complet
- Architecture documentée
- Guide d'installation

#### Application
- APK Android pour tests
- IPA iOS pour tests (TestFlight)
- Application publiée sur stores

#### Documentation
- Documentation technique
- Documentation utilisateur (guide)
- Documentation déploiement

### 7.3. Documentation Globale
- Documentation projet complet
- Architecture système (web + mobile)
- Guide d'intégration
- Charte graphique respectée

---

## 8. OBLIGATIONS DU PRESTATAIRE

### 8.1. Développement
- Respecter les délais convenus
- Fournir un code de qualité, maintenable et documenté
- Respecter les bonnes pratiques (Laravel, Flutter, Dart)
- Implémenter toutes les fonctionnalités spécifiées
- Assurer la compatibilité entre web et mobile

### 8.2. Tests et Qualité
- Tests unitaires (couverture minimale 70%)
- Tests d'intégration (web + mobile)
- Correction de tous les bugs identifiés
- Optimisation des performances
- Code review et refactoring

### 8.3. Communication
- Rendre compte de l'avancement hebdomadaire
- Signalement immédiat de tout problème ou retard
- Participation aux réunions de suivi (hebdomadaire)
- Disponibilité pour questions/révisions

### 8.4. Documentation
- Documentation technique complète (web + mobile)
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
- Fournir l'accès à l'environnement de développement existant
- Fournir les assets graphiques (logos, images, charte graphique)
- Mettre à disposition un environnement de test/staging
- Donner accès aux comptes stores (Google Play, App Store)
- Fournir les credentials nécessaires (serveurs, bases de données)

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

### 10.1. Garantie de Conformité
Le Prestataire garantit que :
- Les applications répondent aux spécifications définies
- Le code est fonctionnel et de qualité professionnelle
- L'application mobile est compatible avec les versions Android/iOS spécifiées
- L'application mobile passe les validations des stores
- L'API est sécurisée et performante

### 10.2. Garantie de Bugs
- **Période de garantie :** 3 mois après la mise en production
- **Garantie couverte :** Correction gratuite des bugs critiques et bloquants
- **Non couvert :**
  - Modifications de fonctionnalités
  - Changements de design non prévus
  - Bugs liés à des modifications post-livraison
  - Problèmes liés à l'infrastructure/hébergement

### 10.3. Support Post-Lancement
- **2 mois inclus :** Support technique inclus (corrections bugs, assistance déploiement)
- **Au-delà :** Support selon tarifs supplémentaires (voir section 6.2)

---

## 11. PROPRIÉTÉ INTELLECTUELLE

### 11.1. Code Source
- Le code source (web + mobile) sera la propriété du Client après paiement intégral
- Le Prestataire conserve le droit d'utiliser les librairies/génériques développés pour d'autres projets (sans code métier spécifique)

### 11.2. Assets et Contenu
- Les assets fournis par le Client restent sa propriété
- Le contenu des applications appartient au Client

### 11.3. Open Source
- Les packages open source utilisés restent sous leur licence respective

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

### 14.1. Changements de Scope
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

### Annexe 1 : Détail des fonctionnalités web par module
(À compléter avec les spécifications détaillées)

### Annexe 2 : Détail des endpoints API
(À joindre la documentation API complète)

### Annexe 3 : Détail des fonctionnalités mobile par module
(À compléter avec les spécifications détaillées)

### Annexe 4 : Charte graphique et maquettes
(À joindre les maquettes UI/UX web + mobile)

### Annexe 5 : Planning détaillé (Gantt)
(À joindre le planning détaillé avec jalons)

### Annexe 6 : État d'avancement actuel du projet
(Liste détaillée des fonctionnalités déjà implémentées)

---

**Document contractuel - À usage professionnel uniquement**
