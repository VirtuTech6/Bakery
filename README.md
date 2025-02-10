# 🥖 Site Web pour boulangerie

## 📌 Description
Ce projet a pour objectif de développer un site web pour une boulangerie afin de présenter ses produits, son histoire et d'inclure une partie administrateur pour la gestion des commandes.

Le projet est basé sur une architecture **Vue.js (Front-end) / Symfony (Back-end)** avec une base de données MySQL.

---

## 🚀 Fonctionnalités
### 🌍 Partie Utilisateur
- 🏠 Page d'accueil avec présentation de la boulangerie
- 🍞 Catalogue des produits (pains, viennoiseries, pâtisseries, etc.)
- 📖 Histoire de la boulangerie
- 📞 Page de contact avec formulaire
- 🛒 Système de commande en ligne

### 🔑 Partie Administrateur
- 📋 Gestion des produits (ajout, modification, suppression)
- 📦 Gestion des commandes des clients
- 👤 Gestion des utilisateurs

---

## 📂 Structure du Projet
```
📦 Bakery
├── 📂 backend (Symfony API)
│   ├── src
│   ├── config
│   ├── migrations
│   └── ...
├── 📂 frontend (Vue.js App)
│   ├── src
│   ├── public
│   ├── components
│   ├── views
│   └── ...
└── 📜 README.md
```

---

## 🚀 Lancement du projet
1. **Lancer le Back-end**
```sh
cd backend
symfony serve
```
2. **Lancer le Front-end**
```sh
cd frontend
npm run dev
```
3. **Accéder à l'application :**
   - **Front-end** : `http://localhost:3000/`
   - **Back-end API** : `http://localhost:8000/`

---

## 📌 Améliorations futures
- 📱 Version mobile optimisée
- 📊 Tableau de bord avancé pour l'admin
- 📦 Intégration d'un système de paiement en ligne

