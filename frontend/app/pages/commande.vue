<template>
    <v-container class="py-10 d-flex flex-column align-center artisan-container">
      <!-- Titre de la page -->
      <h1 class="text-center mb-10 artisan-title">Nos Produits</h1>
      <h2 class="text-center mb-6 artisan-subtitle">Commandez en ligne</h2>
  
      <v-row class="w-100" justify="center">
        <!-- Colonne de filtre -->
        <v-col cols="12" md="3">
          <v-card class="pa-4 artisan-filter" elevation="0">
            <v-card-title class="text-center text-h6 font-weight-bold">Filtres</v-card-title>
            <v-divider class="mb-4"></v-divider>
  
            <v-select
              v-model="filters.category"
              :items="categories"
              item-title="name"
              item-value="id"
              label="Catégorie"
              variant="outlined"
              dense
              class="mb-4"
            ></v-select>
  
            <v-checkbox 
              v-model="filters.popular" 
              label="Produits populaires" 
              class="mb-4 artisan-checkbox"
              hide-details
              color="black"
            ></v-checkbox>
            
            <v-btn @click="resetFilters" class="artisan-btn" block>Réinitialiser</v-btn>
          </v-card>
        </v-col>
  
        <!-- Colonne des produits -->
        <v-col cols="12" md="9">
          <v-row justify="center">
            <v-col v-if="filteredProducts.length === 0" cols="12" class="text-center text-grey-darken-1 text-h6">
              Aucun produit trouvé.
            </v-col>
            
            <v-col v-for="product in filteredProducts" :key="product.id" cols="12" sm="6" md="4">
              <v-card class="artisan-product d-flex flex-column align-center pa-3" elevation="0">
                <nuxt-link :to="`/produit/${product.id}`" class="artisan-image-link">
                  <img :src="product.image" class="artisan-image mb-3">
                </nuxt-link>
                <v-card-title class="text-center text-subtitle-1 font-weight-bold">{{ product.name }}</v-card-title>
                <v-card-subtitle class="text-center text-body-2">{{ product.price }} €</v-card-subtitle>
                <v-card-actions class="justify-center">
                  <v-btn class="artisan-btn" @click="addToCart(product)">
                    Ajouter au panier
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const products = [
    { id: 1, name: 'Pain de campagne', price: 2.5, image: '/produits/paindecampagne.jpeg', category: 'pains', popular: true },
    { id: 2, name: 'Brioche', price: 3.2, image: '/produits/brioche.jpeg', category: 'viennoiseries', popular: false },
    { id: 3, name: 'Chocolatine', price: 1.8, image: '/produits/painauchocolat.jpeg', category: 'viennoiseries', popular: true },
    { id: 4, name: 'Sandwich jambon beurre', price: 4.5, image: '/produits/sandwich.jpeg', category: 'sandwichs', popular: false },
  ];
  
  const categories = [
    { id: 'pains', name: 'Pains' },
    { id: 'viennoiseries', name: 'Viennoiseries' },
    { id: 'sandwichs', name: 'Sandwichs' },
    { id: 'patisseries', name: 'Pâtisseries' },
  ];
  
  const filters = ref({ category: null, popular: false });
  
  const filteredProducts = computed(() => {
    return products.filter(product => {
      const matchesCategory = !filters.value.category || product.category === filters.value.category;
      const matchesPopularity = !filters.value.popular || product.popular;
      return matchesCategory && matchesPopularity;
    });
  });
  
  const resetFilters = () => {
    filters.value = { category: null, popular: false };
  };

  const addToCart = (product) => {
    // TODO: Implémenter la logique d'ajout au panier
    console.log('Ajout au panier:', product);
  };
  </script>

  <style scoped>
  .artisan-container {
    min-height: 100vh;
    background: #ffffff;
    padding: 50px 20px;
    margin-top: 60px;
    position: relative;
  }

  .artisan-title {
    font-size: 3.8rem;
    font-weight: 400;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-align: center;
    color: #000000;
    margin: 60px 0;
    position: relative;
    font-family: 'Playfair Display', serif;
  }

  .artisan-title::after,
  .artisan-subtitle::after {
    content: "";
    display: block;
    height: 1px;
    background: #000000;
    margin: 20px auto 0;
  }

  .artisan-title::after {
    width: 100px;
  }

  .artisan-subtitle {
    font-size: 2.6rem;
    font-weight: 400;
    text-align: center;
    color: #000000;
    margin-bottom: 30px;
    letter-spacing: 1px;
    font-family: 'Playfair Display', serif;
    position: relative;
  }

  .artisan-subtitle::after {
    width: 60px;
    margin: 15px auto 0;
  }
  
  .artisan-filter,
  .artisan-product {
    transition: all 0.4s ease;
    background: #ffffff;
    border: none;
  }

  .artisan-filter:hover,
  .artisan-product:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  }
  
  .artisan-product {
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .artisan-image-link {
    display: block;
    text-decoration: none;
  }

  .artisan-image {
    width: 200px;
    height: 200px;
    object-fit: cover;
    transition: all 0.4s ease;
    margin: 0 auto;
    cursor: pointer;
  }

  .artisan-image:hover {
    transform: scale(1.02);
  }

  .artisan-btn {
    background: #000000;
    color: #ffffff;
    font-size: 0.9rem;
    padding: 12px 30px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 0;
    border: 1px solid #000000;
    transition: all 0.3s ease;
    font-family: 'Montserrat', sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 160px;
  }

  .artisan-btn:hover {
    background: #ffffff;
    color: #000000;
    transform: translateY(-2px);
  }

  .artisan-container::before {
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

  /* Styles Vuetify optimisés */
  :deep(.v-card-title) {
    color: #000000 !important;
  }

  :deep(.v-card-subtitle) {
    color: rgba(0, 0, 0, 0.7) !important;
  }

  :deep(.v-label),
  :deep(.v-checkbox .v-label) {
    color: rgba(0, 0, 0, 0.8) !important;
  }

  :deep(.v-field__input) {
    color: #000000 !important;
  }

  :deep(.v-field__outline) {
    color: rgba(0, 0, 0, 0.2) !important;
  }

  :deep(.v-field--focused .v-field__outline) {
    color: #000000 !important;
  }

  :deep(.artisan-checkbox) {
    margin-top: 8px;
  }

  :deep(.artisan-checkbox .v-checkbox__inner) {
    border: 3px solid #000000 !important;
    border-radius: 2px !important;
    width: 20px !important;
    height: 20px !important;
    min-width: 20px !important;
    min-height: 20px !important;
    opacity: 1 !important;
    background-color: #ffffff !important;
  }

  :deep(.artisan-checkbox:hover .v-checkbox__inner) {
    background-color: rgba(0, 0, 0, 0.05) !important;
  }

  :deep(.artisan-checkbox.v-checkbox--selected .v-checkbox__inner) {
    background-color: #000000 !important;
    border-color: #000000 !important;
  }
  </style>
