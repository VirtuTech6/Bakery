<template>
    <v-container class="py-10 d-flex flex-column align-center page-container">
      <!-- Titre de la page -->
      <h1 class="text-center mb-2 text-h4 font-weight-bold title">Nos Produits</h1>
      <div class="title-underline"></div>
      <h2 class="text-center mb-6 text-h5 font-weight-medium subtitle">Commandez en ligne</h2>
  
      <v-row class="w-100" justify="center">
        <!-- Colonne de filtre -->
        <v-col cols="12" md="3">
          <v-card class="pa-4 filter-card" elevation="2">
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
  
            <v-checkbox v-model="filters.popular" label="Produits populaires" class="mb-4"></v-checkbox>
            
            <v-btn @click="resetFilters" color="red" block>Réinitialiser</v-btn>
          </v-card>
        </v-col>
  
        <!-- Colonne des produits -->
        <v-col cols="12" md="9">
          <v-row justify="center">
            <v-col v-if="filteredProducts.length === 0" cols="12" class="text-center text-grey-darken-1 text-h6">
              Aucun produit trouvé.
            </v-col>
            
            <v-col v-for="product in filteredProducts" :key="product.id" cols="12" sm="6" md="4">
              <v-card class="product-card d-flex flex-column align-center pa-3" elevation="2">
                <img :src="product.image" class="product-image mb-3">
                <v-card-title class="text-center text-subtitle-1 font-weight-bold">{{ product.name }}</v-card-title>
                <v-card-subtitle class="text-center text-body-2">{{ product.price }} €</v-card-subtitle>
                <v-card-actions class="justify-center">
                  <v-btn :to="`/produit/${product.id}`" color="primary">Voir le produit</v-btn>
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
  </script>

  <style scoped>
  .page-container {
    margin-top: 60px;
  }

  .title {
    color: #2c3e50;
    position: relative;
  }

  .title-underline {
    width: 50px;
    height: 4px;
    background-color: #ff6f61;
    margin: 8px auto 16px auto;
    border-radius: 2px;
  }

  .subtitle {
    color: #34495e;
    font-weight: 500;
    font-size: 1.25rem;
  }
  
  .filter-card {
    border-radius: 10px;
  }
  
  .product-card {
    transition: transform 0.2s ease-in-out;
    border-radius: 12px;
  }
  
  .product-card:hover {
    transform: scale(1.05);
  }
  
  .product-image {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
  }
  </style>
