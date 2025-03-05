<template>
  <v-container class="py-10 mt-10 page-container">
    <v-row justify="center">
      <!-- Image du produit -->
      <v-col cols="12" md="6" class="d-flex justify-center">
        <v-img :src="product.image" max-height="400" max-width="100%" contain></v-img>
      </v-col>
      
      <!-- Informations du produit -->
      <v-col cols="12" md="6">
        <h1 class="text-h4 font-weight-bold mb-2">{{ product.name }}</h1>
        <p class="text-body-1 text-grey-darken-1 mb-4">{{ product.description }}</p>
        
        <h3 class="text-h6 font-weight-bold">Ingrédients</h3>
        <v-chip-group class="mb-4">
          <v-chip v-for="ingredient in product.ingredients" :key="ingredient">{{ ingredient }}</v-chip>
        </v-chip-group>
        
        <v-select
          v-if="product.category === 'pains'"
          v-model="selectedCut"
          :items="cutOptions"
          label="Coupé"
          variant="outlined"
          dense
          class="mb-4"
        ></v-select>
        
        <v-select
          v-model="selectedQuantity"
          :items="quantities"
          label="Quantité"
          variant="outlined"
          dense
          class="mb-4"
        ></v-select>
        
        <v-btn class="artisan-btn" block @click="addToCart">Ajouter au panier</v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const productId = route.params.id;

// Simuler les données du produit
const products = [
  { id: '1', name: 'Pain de campagne', description: 'Un délicieux pain rustique.', price: 2.5, image: '/produits/paindecampagne.jpeg', ingredients: ['Farine', 'Eau', 'Sel', 'Levure'], category: 'pains' },
  { id: '2', name: 'Brioche', description: 'Une brioche moelleuse et sucrée.', price: 3.2, image: '/produits/brioche.jpeg', ingredients: ['Farine', 'Beurre', 'Oeufs', 'Sucre'], category: 'viennoiseries' },
  { id: '3', name: 'Chocolatine', description: 'Un classique du petit déjeuner.', price: 1.8, image: '/produits/painauchocolat.jpeg', ingredients: ['Farine', 'Beurre', 'Chocolat', 'Sucre'], category: 'viennoiseries' },
  { id: '4', name: 'Sandwich jambon beurre', description: 'Un sandwich simple et efficace.', price: 4.5, image: '/produits/sandwich.jpeg', ingredients: ['Pain', 'Jambon', 'Beurre'], category: 'sandwichs' },
];

const product = computed(() => products.find(p => p.id === productId) || {});

const cutOptions = ['Oui', 'Non'];
const quantities = [1, 2, 3, 4, 5];

const selectedCut = ref('Non');
const selectedQuantity = ref(1);

const addToCart = () => {
  console.log(`Ajouté au panier : ${product.value.name}, Coupé: ${selectedCut.value}, Quantité: ${selectedQuantity.value}`);
};
</script>

<style scoped>
.v-container {
  max-width: 900px;
  margin-top: 80px;
}

.page-container {
  min-height: calc(100vh - 200px); /* Ajuste la hauteur pour coller le footer en bas */
  display: flex;
  flex-direction: column;
  justify-content: center;
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
    
  }

  .artisan-btn:hover {
    background: #ffffff;
    color: #000000;
    transform: translateY(-2px);
  }
</style>
