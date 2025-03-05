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
/* ---- Style artisanal en noir et blanc ---- */
.v-container {
  padding: 50px 20px;
  background: #ffffff;
  min-height: 100vh;
}

/* ---- Titre principal artisanal ---- */
.title {
  font-size: 3.8rem;
  font-weight: 400;
  text-transform: uppercase;
  letter-spacing: 3px;
  text-align: center;
  color: #000000;
  margin-top: 60px;
  margin-bottom: 60px;
  position: relative;
  font-family: 'Playfair Display', serif;
}

.title::after {
  content: "";
  display: block;
  width: 100px;
  height: 2px;
  background: #000000;
  margin: 20px auto 0;
}

/* ---- Style artisanal des catégories ---- */
.category-container {
  background: #ffffff;
  border-radius: 0;
  padding: 40px;
  margin-bottom: 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  transition: all 0.4s ease;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

.category-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
}

/* ---- Titre de catégorie artisanal ---- */
.category-title {
  font-size: 2.6rem;
  font-weight: 400;
  text-align: center;
  color: #000000;
  margin-bottom: 30px;
  letter-spacing: 1px;
  font-family: 'Playfair Display', serif;
  position: relative;
}

.category-title::after {
  content: "";
  display: block;
  width: 60px;
  height: 1px;
  background: #000000;
  margin: 15px auto 0;
}

/* ---- Image artisanal ---- */
.category-image {
  width: 100%;
  height: auto;
  transition: all 0.4s ease;
}

.category-image:hover {
  transform: scale(1.02);
}

/* ---- Style alterné des sections ---- */
.reverse-row {
  flex-direction: row-reverse;
}

/* ---- Bouton artisanal ---- */
.btn-orange {
  background: #000000;
  color: #ffffff;
  font-size: 1.1rem;
  padding: 15px 40px;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 1px;
  border-radius: 0;
  border: 1px solid #000000;
  transition: all 0.3s ease;
  font-family: 'Montserrat', sans-serif;
  margin: 0 auto;
  display: inline-block;
  text-align: center;
  display: flex;
  text-decoration: none;
}

.btn-orange:hover {
  background: #ffffff;
  color: #000000;
  transform: translateY(-2px);
}

/* ---- Ajout d'un effet de texture subtil ---- */
.v-container::before {
  content: "";
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23000000' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
  pointer-events: none;
  z-index: 0;
}
</style>