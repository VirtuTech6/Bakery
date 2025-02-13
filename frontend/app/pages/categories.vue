<template>
  <v-container class="py-10">
    <h1 class="text-center mb-10 title">Nos Produits</h1>

    <v-row v-for="(category, index) in categories" :key="index" class="category-container align-center mb-10"
      :class="{ 'reverse-row': index % 2 !== 0 }">
      <!-- Image -->
      <v-col cols="12" md="6">
        <v-img :src="category.image" :alt="category.title" class="category-image"></v-img>
      </v-col>

      <!-- Titre et bouton -->
      <v-col cols="12" md="6" class="text-center">
        <h2 class="category-title">{{ category.title }}</h2>
        <nuxt-link :to="category.link">
          <v-btn class="btn-orange mt-4">Voir les produits</v-btn>
        </nuxt-link>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
const categories = [
  { title: 'Nos pains', image: '/categories/pains.png', link: '/commande' },
  { title: 'Nos viennoiseries', image: '/categories/viennoiseries.png', link: '/commande' },
  { title: 'Nos pâtisseries', image: '/categories/patisseries.png', link: '/commande' },
  { title: 'Nos sandwichs', image: '/categories/sandwichs.png', link: '/commande' },
];
</script>

<style scoped>
/* ---- Ajout d'un fond plus chaleureux ---- */
.v-container {
  padding: 50px 20px;
  border-radius: 20px;
}

/* ---- Titre principal ---- */
.title  {
  font-size: 3rem;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 2px;
  text-align: center;

  /* Couleur similaire aux catégories */
  color: #8B4513; /* Marron foncé */
  
  /* Ajout d'un léger effet d'ombre */
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
  
  /* Espacement */
  margin-top: 100px; /* Pour éloigner du header */
  margin-bottom: 20px; /* Pour ne pas coller à la puce */
  position: relative;
}

/* ---- Puce décorative sous le titre ---- */
.title::after {
  content: "";
  display: block;
  width: 60px;
  height: 6px;
  background: orange; /* Même couleur que l'encadrement des catégories */
  margin: 10px auto 0; /* Centre la puce sous le titre */
  border-radius: 3px; /* Arrondit les bords */
  
}
  
/* ---- Encadrement des catégories avec un effet carte ---- */
.category-container {
  background: linear-gradient(135deg, #f7e6d5, #f4d7b5);
  border-left: 8px solid orange;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
  transition: transform 0.3s ease-in-out;
}

.category-container:hover {
  transform: scale(1.03);
}

/* ---- Styliser le titre de chaque catégorie ---- */
.category-title {
  font-size: 2rem;
  font-weight: bold;
  text-align: center;
  color: #8B4513;
}

/* ---- Adapter l'image ---- */
.category-image {
  width: 100%;
  height: auto;
  border-radius: 15px;
  transition: transform 0.3s ease-in-out;
}

.category-image:hover {
  transform: scale(1.05);
}

/* ---- Alterner les sections (image à gauche, texte à droite et inversement) ---- */
.reverse-row {
  flex-direction: row-reverse;
  border-left: none;
  border-right: 8px solid orange;
}

/* ---- Bouton plus design ---- */
.btn-orange {
  margin-top: 8px;
  transition: transform 0.3s ease-in-out;
  /* Animation fluide */
  background-color: orange;
  color: white;
  font-size: 1rem; /* Un peu plus grand */
  padding: 10px 20px; /* Ajuster le padding */
  font-weight: bold;
  text-transform: uppercase;

  border-radius: 8px;
  transition: all 0.3s ease-in-out;
}

.btn-orange:hover {
  background: linear-gradient(135deg, #e65100, #bf360c);
  box-shadow: 0 6px 15px rgba(255, 87, 34, 0.6);
  transform: scale(1.1);
}
</style>