<template>
  <div class="categories-page">
    <!-- Section En-tête -->
    <v-img src="/home-banner.jpg" class="home-image" cover>
      <section class="hero-section">
        <div class="hero-content">
          <h1>Nos Produits</h1>
          <p>Découvrez notre sélection de produits artisanaux</p>
        </div>
      </section>
    </v-img>

    <v-container class="py-10">
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
              <v-btn class="btn-black mt-4">Voir les produits</v-btn>
          </nuxt-link>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
const categories = [
  { title: 'Nos pains', image: '/categories/pains.png', link: '/commande?category=Pains' },
  { title: 'Nos viennoiseries', image: '/categories/viennoiseries.png', link: '/commande?category=Viennoiseries' },
  { title: 'Nos pâtisseries', image: '/categories/patisseries.png', link: '/commande?category=Pâtisseries' },
  { title: 'Nos sandwichs', image: '/categories/sandwichs.png', link: '/commande?category=Sandwichs' },
];
</script>

<style scoped>
.categories-page {
  font-family: 'Playfair Display', serif;
}

.home-image {
  height: 60vh;
  position: relative;
}

.hero-section {
  height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  position: relative;
}

.hero-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
}

.hero-content {
  position: relative;
  z-index: 1;
}

.hero-content h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
}

.hero-content p {
  font-size: 1.2rem;
  font-style: italic;
}

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
.btn-black {
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

.btn-black:hover {
  background: #ffffff;
  color: #000000;
  transform: translateY(-2px);
}
</style>